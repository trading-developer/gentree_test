<?php

namespace App\Files;

interface HandlerInterface
{
    public function validation():bool;
    public function getData():array;
}
