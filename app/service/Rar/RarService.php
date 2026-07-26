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

    public function extract(): void
    {
        $this->checkFromTo();

        $extracted = false;
        $command = sprintf(
            'unrar x -o+ -ep %s %s 2>&1',
            escapeshellarg($this->archiveFilePath),
            escapeshellarg($this->toPath)
        );

        $output     = [];
        $returnCode = 0;

//        exec('pwd', $output, $returnCode);
//        exec('cd', $output, $returnCode);
        exec($command, $output, $returnCode);
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $output = array_map(function ($line) {
                return iconv('CP866', 'UTF-8//IGNORE', $line);
            }, $output);
        }

        if ($returnCode === 0) {
            $extracted = true;
        }

        $lastError = implode("\n", $output);

        if (!$extracted) {
            response()->popup($lastError);
        }

    }

    private function checkFromTo(): void
    {
        if (!$this->toPath) {
            response()->popup('Не указана целевая папка');
        }
        if (!$this->archiveFilePath) {
            response()->popup('Не указан путь к архивному файлу');
        }
    }

}