<?php

declare(strict_types=1);

namespace App\Files;

abstract class File
{
    protected ?string $filePath = null;
    protected array $errors = [];

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * @param string $error
     * @return void
     */
    public function addError(string $error): void
    {
        $this->errors[] = $error;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param string $separator
     * @return string
     */
    public function getErrorsText(string $separator = "\n"): string
    {
        return implode($separator, $this->getErrors());
    }

    abstract public function validation():bool;
    abstract public function getData():array;
}
