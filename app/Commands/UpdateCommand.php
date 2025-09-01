<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;
use Symfony\Component\Process\Process;

class UpdateCommand extends Command
{
    protected $signature = 'update';
    protected $description = 'Обновление инструмента cli';

    public function handle(): int
    {
        // Команда выполняется через shell, чтобы использовать && и ~
        $process = Process::fromShellCommandline(
            'mkdir -p ~/bin && curl -L https://github.com/awkirin/awk-laravel-zero/releases/download/latest/awk-helper -o ~/bin/awk-helper && chmod +x ~/bin/awk-helper'
        );

        $process->setTimeout(null);
        $process->setIdleTimeout(null);

        $process->run(function ($type, $buffer) {
            if ($type === Process::ERR) {
                $this->error($buffer);
            } else {
                $this->output->write($buffer);
            }
        });

        if (!$process->isSuccessful()) {
            $this->error('Ошибка при обновлении инструмента CLI');
            return CommandAlias::FAILURE;
        }

        $this->info('Инструмент CLI успешно обновлён!');
        return CommandAlias::SUCCESS;
    }

}
