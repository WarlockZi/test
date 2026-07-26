<?php

namespace app\service\Rar;

use app\service\Zip\ZipException;

class RarService
{
    private string $archiveFilePath;
    private string $toPath;

    public function archiveFilePath(string $archiveFilePath): self
    {
        $this->archiveFilePath = $archiveFilePath;
        return $this;
    }
    public function toPath(string $toPath): self
    {
        $this->toPath = $toPath;
        return $this;
    }

    public function extract()
    {
        $this->checkFromTo();
        $commands = [
            'unrar x -o+ "' . escapeshellarg($this->archiveFilePath) . '" "' . escapeshellarg($this->toPath) . '"',
//            '7z x "' . escapeshellarg($this->archiveFilePath) . '" -o"' . escapeshellarg($this->toPath) . '" -y',
        ];

        $extracted = false;
        $lastError = '';

        foreach ($commands as $command) {
            $command = sprintf(
                'unrar x -o+ %s %s 2>&1',
                escapeshellarg($this->archiveFilePath),
                escapeshellarg($this->toPath)
            );

            $output = [];
            $returnCode = 0;

            if (!extension_loaded('rar')) {
                echo("❌ RAR extension not loaded!\n");
            }

            exec($command . ' 2>&1', $output, $returnCode);
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                $output = array_map(function($line) {
                    return iconv('CP866', 'UTF-8//IGNORE', $line);
                }, $output);
            }

            if ($returnCode === 0) {
                $extracted = true;
                break;
            }
            $lastError = implode("\n", $output);
        }

        if (!$extracted) {
            throw new ZipException(
                'Failed to extract RAR file. Make sure unrar or 7z is installed. Error: ' . $lastError
            );
        }

    }

    private function checkFromTo(): void
    {
        if (!$this->toPath ) {
            response()->popup('Не указана целевая папка');
        }
        if (!$this->archiveFilePath) {
            response()->popup('Не указан путь к архивному файлу');
        }
    }

}