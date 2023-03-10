<?php

require __DIR__ . '/vendor/autoload.php';

use App\Files\Manager;
use App\TreeGenerator;

$args = array_fill(0, $argc, null);
for ($i = 1; $i < $argc; $i++) {
    $args[$i - 1] = str_replace('-', '', $argv[$i]);
}

$sourcesFile = !empty($args[0]) ? $args[0] : readline('Путь к входящему файлу в формате CSV: ');
$resultFile = !empty($args[1]) ? $args[1] : readline('Путь для выгружаемого файла: ');

if (!file_exists($sourcesFile)) {
    die("Исходный файл не найден.\n");
}

$timeStart = microtime(true);

$manager = new Manager($sourcesFile);

try {
    $executor = $manager->getExecutor();
} catch (RuntimeException $exception) {
    die($exception->getMessage() . "\n");
}

if (!$executor->validation()) {
    die($executor->getErrorsText() . "\n");
}

$generator = new TreeGenerator($executor, $resultFile);

if (!$generator->saveJson()) {
    die("Не удалось сохранить выгружаемый файл\n");
}

echo 'Использовано памяти: ' . (memory_get_peak_usage() / 1024 / 1024) . " MB \n";
echo 'Время выполнения в секундах: ' . ((microtime(true) - $timeStart)) . "\n";

die("Генерация завершена \n");
