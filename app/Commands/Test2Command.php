<?php

namespace App\Commands;
use AllowDynamicProperties;
use App\Helpers\Video;
use Illuminate\Support\Collection;
use Illuminate\Support\Number;
use Symfony\Component\Console\Command\Command as CommandAlias;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Process\Process;

class Test2Command extends Base
{
    protected array $config = [];
    protected Collection $files;
    protected $signature = 'test:test2
        {--i|input_dir= : i}
        {--o|output_dir=~/Desktop/output : o}
        {--e|output_extension=mp4 : o}
    ';

    protected $description = "";

    public function __construct()
    {
        parent::__construct();
        //$this->addUsage("-i ./ -o ./ -- 'ffmpeg {i} -c:v h264_nvenc {o}'");
    }

    protected function prepareOutputPath(SplFileInfo $file): string {
        $path = $file->getRealPath();
        $path = str_replace(
            $this->options['input_dir'],
            $this->options['output_dir'],
            $path
        );

        $path = str_replace(
            '.' . $file->getExtension(),
            '.' . $this->options['output_extension'],
            $path
        );

        $outputDir = dirname($path);
        if (!is_dir($outputDir)) {
            mkdir($outputDir, 0777, true); // Рекурсивное создание папок
        }

        return $path;
    }

    protected function prepareFile(SplFileInfo $file): array
    {
        return [
            'input' => [
                'path' => $file->getRealPath(),
                'inputSize' => Number::fileSize($file->getSize()),
            ],
            'output' => [
                'path' => $this->prepareOutputPath($file),
                'size' => ''
            ],
        ];
    }

    public function handle(): int
    {
        $this->options["input_dir"] = realpath(path($this->options["input_dir"] ?? getcwd()));
        $this->options["output_dir"] =realpath(path($this->options["output_dir"]));

        $files = Finder::create()->files()
            ->in($this->options["input_dir"])
            ->name('/\.(mov|mp4)$/i');


        $bar = $this->output->createProgressBar($files->count());
        $bar->setFormat('%message%' . PHP_EOL . 'elapsed=%elapsed:6s%' . PHP_EOL . '%current%/%max% [%bar%] %percent:3s%%');
        $bar->start();
        /* @var SplFileInfo $file */
        foreach ($files as $file) {
            $file = $this->prepareFile($file);
            $this->command = [
                'ffmpeg',
                '-i', $file['input']['path'],
                '-c:v', 'h264_nvenc',
                '-cq', '40',
                '-y',
                $file['output']['path']
            ];
            $process = new Process($this->command);
            $process->run();

            $bar->setMessage(
                "input: {$file['input']['path']}" . PHP_EOL . "output: {$file['output']['path']}"
            );
            $bar->advance();
        }
        $bar->finish();

        return CommandAlias::SUCCESS;
    }
}
