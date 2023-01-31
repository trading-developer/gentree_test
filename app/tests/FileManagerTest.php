<?php

declare(strict_types=1);

use App\TreeGenerator;
use PHPUnit\Framework\TestCase;

final class FileManagerTest extends TestCase
{

    /**
     * Проверяем ошибку не корректного формата исходного файла
     * @return void
     */
    public function testCannotFormatManager(): void
    {
        $this->expectException(RuntimeException::class);

        $manager = new \App\Files\Manager('files/input.bad');
        $manager->getExecutor();
    }

    /**
     * Проверяем правильность исполняющего класса
     * @return void
     */
    public function testExecutorClass(): void
    {
        $manager = new \App\Files\Manager('files/input.csv');

        $this->assertInstanceOf(
            App\Files\Csv::class,
            $manager->getExecutor(),
        );
    }

    /**
     * Проверяем корректность построения дерева
     * @return void
     * @throws JsonException
     */
    public function testResultTree(): void
    {
        $manager = new \App\Files\Manager('files/fortest.csv');

        $generator = new TreeGenerator($manager->getExecutor(), '');

        $expected = <<<JSON
[{"ItemName":"Total","parent":"","children":[{"ItemName":"ПВЛ","parent":"Total","children":[{"ItemName":"Стандарт.#1","parent":"ПВЛ","children":[{"ItemName":"Тележка Б25.#2","parent":"Стандарт.#1","children":[]},{"ItemName":"Комплект СВЛ стд+надпятник.#3","parent":"Стандарт.#1","children":[]}]}]},{"ItemName":"ПВЛ соч","parent":"Total","children":[]},{"ItemName":"ПВЛ 103м Б27","parent":"Total","children":[]},{"ItemName":"Адаптер подшипника 4536-07.00.00.001","parent":"Total","children":[]}]},{"ItemName":"Стандарт.#101","parent":"ХОП 101","children":[{"ItemName":"Тележка Б25.#205","parent":"Стандарт.#101","children":[]},{"ItemName":"Комплект СВЛ с УЗ01К.#206","parent":"Стандарт.#101","children":[]}]},{"ItemName":"Доп1.#113","parent":"","children":[{"ItemName":"Тележка Б25.#255","parent":"Доп1.#113","children":[]}]},{"ItemName":"Стандарт.#112","parent":"","children":[{"ItemName":"Комплект СВЛ стд.#256","parent":"Стандарт.#112","children":[]}]}]
JSON;

        $this->assertEquals(
            $expected,
            $generator->getResult()
        );
    }
}
