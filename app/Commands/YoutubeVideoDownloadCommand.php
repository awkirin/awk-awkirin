<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;
use Symfony\Component\Process\Process;

class YoutubeVideoDownloadCommand extends Command
{
    protected $signature = 'youtube:video:download {url : YouTube video URL}';
    protected $description = 'Скачивает видео с YouTube через yt-dlp с нужными параметрами';

    public function handle(): int
    {
        $this->info('Для работы прокси необходимо включить tor-browser');
        $this->info('Для работы команды должен быть установлен yt-dlp');


        $url = $this->argument('url');

        $this->info("Скачивание видео: {$url}");


        $process = new Process([
            'yt-dlp',
//            '--verbose',
            '--retries', '20', # default:10 | infinite

            '--compat-options', 'no-certifi',

            '--proxy', 'socks5://127.0.0.1:9150',

            '--embed-metadata',
            '--embed-thumbnail',


            '-f',
            'bestvideo[vcodec^=avc1]+bestaudio[acodec^=mp4a]/best[ext=mp4]',
            # bv*+ba/b
            # bestvideo+bestaudio/best

            '--merge-output-format',
//            'mkv',
            'mp4',

            $url,
        ]);

        $this->info($process->getCommandLine());

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
            $this->error('Ошибка при загрузке видео');
            return CommandAlias::FAILURE;
        }

        $this->info('Видео успешно скачано!');
        return CommandAlias::SUCCESS;
    }

}
