<?php

declare(strict_types=1);

namespace App\Files;

class Csv extends File
{

    private const MAX_ROW_FILE = 20000;
    private const SEPARATOR = ';';

    /**
     * @return bool
     */
    public function validation(): bool
    {
        $file = file($this->filePath, FILE_SKIP_EMPTY_LINES);

        if (count($file) > self::MAX_ROW_FILE) {
            $this->addError('Превышено количество строк в файле!');
            return false;
        }

        $header = array_shift($file);

        if (trim($header) !== '"Item Name";"Type";"Parent";"Relation"') {
            $this->addError('Некорректные заголовки в файле!');
            return false;
        }

        return true;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        $fh = fopen($this->filePath, 'rb');
        $data = [];
        fgets($fh); //skip header

        while(($row = fgetcsv($fh, 0, self::SEPARATOR)) !== false) {
            [$name, $type, $parent, $relation] = $row;
            $data[] = [
                'name' => $name,
                'type' => $type,
                'parent' => $parent,
                'relation' => $relation,
            ];
        }
        return $data;
    }
}
