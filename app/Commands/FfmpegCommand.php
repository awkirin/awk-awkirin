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
        $defaultArgs = [
            '-crf', '38',
        ];

        $userArgs = $this->argument('args');
        $args = array_merge(['ffmpeg'], $defaultArgs, $userArgs);

        $process = new Process($args);
        $process->setTimeout(null);
        $process->run(function ($type, $buffer) {
            $this->output->write($buffer);
        });

        return $process->isSuccessful() ? CommandAlias::SUCCESS : CommandAlias::FAILURE;
    }
}
