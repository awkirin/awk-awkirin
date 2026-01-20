<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Process\Process;
use Throwable;

class TestCommand extends Command
{
    protected string $statusFile = '';
    protected $signature = 'test:test
        {--i|input=./ : Путь к входной директории с видео}
        {--o|output=./output : Путь к выходной директории}
        {--crf=38 : CRF значение для оптимизации (меньше = лучше качество, 18-28 рекомендуется)}
        {--f|format=mp4 : Формат выходного файла}
        {--y|yes : Пропустить подтверждение}
        {--force : Перезаписать существующие файлы}';

    protected $description = 'test';
    public function handle(): void
    {

    }
}
