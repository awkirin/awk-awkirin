<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Console\Command\Command as CommandAlias;

class FfmpegCommand extends Command
{
    protected $signature = 'ffmpeg {args* : Arguments to pass to ffmpeg}';
    protected $description = 'Run ffmpeg with predefined arguments';

    public function handle(): int
    {

        $videoCodec = env('FFMPEG_VIDEO_CODEC');
        $crf = env('FFMPEG_CRF');

        $defaultArgs  = [];

        if($videoCodec === 'h264_nvenc'){
            $defaultArgs = [
                '-c:v', $videoCodec,
                '-rc', 'vbr',
                '-cq', $crf,
            ];
        }

        $userArgs = $this->argument('args');
        $args = array_merge($defaultArgs, $userArgs);

        $process = new Process(array_merge(['ffmpeg'], $args));

        $this->info($process->getCommandLine());

        $process->setTimeout(null);
        $process->run(function ($type, $buffer) {
            $this->output->write($buffer);
        });

        return $process->isSuccessful() ? CommandAlias::SUCCESS : CommandAlias::FAILURE;
    }
}
