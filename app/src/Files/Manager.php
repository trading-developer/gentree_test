<?php

declare(strict_types=1);

namespace App\Files;

class Manager
{
    private ?string $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function getExecutor(): Csv|Excel|Json
    {
        $extension = $this->getExtensionFile();

        if ($extension === 'text/plain') {
            return new Csv($this->filePath);
        }

        //Не тестировал, тут показан принцип стратегии, что имея общий интерфейс для обработчиков мы можем
        // подавать на вход другие форматы файлов(не только csv)
        //Подошел с фантазией :-)
        if ($extension === 'excel') {
            return new Excel($this->filePath);
        }

        if ($extension === 'text/json') {
            return new Json($this->filePath);
        }

        throw new \RuntimeException('Не известный тип файла');
    }

    private function getExtensionFile(): bool|string
    {
        return mime_content_type($this->filePath);
    }
}
