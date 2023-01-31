<?php

declare(strict_types=1);

namespace App;

class TreeGenerator
{
    private Files\Json|Files\Excel|Files\Csv $executor;
    private array $resultTree;
    private string $resultFile;

    public function __construct($executor, string $resultFile)
    {
        $this->executor = $executor;
        $this->resultFile = $resultFile;

        $this->build();
    }

    private function build(): void
    {
        $list = [];
        foreach ($this->executor->getData() as $item) {
            $list[$item['name']] = [
                'ItemName' => $item['name'],
                'parent' => $item['parent'],
                'children' => [],
            ];
        }

        $result = [];
        foreach ($list as $item) {
            if (empty($item['parent']) || empty($list[$item['parent']])) {
                $result[] = &$list[$item['ItemName']];
            } else {
                $parent = &$list[$item['parent']];
                $parent['children'][] = &$list[$item['ItemName']];
            }
        }

        $this->resultTree = $result;
    }

    /**
     * @return string
     * @throws \JsonException
     */
    public function getResult(): string
    {
        return json_encode($this->resultTree, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    }

    public function saveJson(): bool|int
    {
        return file_put_contents($this->resultFile, $this->getResult());
    }
}
