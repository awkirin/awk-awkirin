<?php

namespace App\Commands;

use Illuminate\Support\Arr;
use LaravelZero\Framework\Commands\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

abstract class Base extends Command
{
    protected array $command = [];

    protected array $options = [];

    protected function initialize(...$args): void
    {
        parent::initialize(...$args);
        $this->options = $this->input->getOptions();
        unset(
            $this->options['help'],
            $this->options['silent'],
            $this->options['quiet'],
            $this->options['verbose'],
            $this->options['version'],
            $this->options['ansi'],
            $this->options['no-interaction'],
            $this->options['env'],
        );
        $this->title("Команда: $this->name");
        $this->line($this->description);
        $this->newLine();
    }

    protected function stepConfirm(): int
    {
        if ($this->options['yes']) {
            return CommandAlias::SUCCESS;
        }

        $this->alert('Проверьте');
        $this->info('Опции');
        $this->table(
            ['Опция', 'Значение'],
            Arr::map($this->options, fn ($v, $k) => [
                $k, is_bool($v) ? ($v ? '✓' : '✗') : $v,
            ])
        );
        $this->newLine();
        $this->info('Команда');
        $this->line(Arr::join($this->command, ' '));
        if (! $this->confirm('Продолжить?', 1)) {
            return CommandAlias::FAILURE;
        }

        return CommandAlias::SUCCESS;
    }
}
