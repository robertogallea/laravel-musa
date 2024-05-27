<?php

namespace App\Services;

class RandomService
{
    private int $value;

    public function __construct()
    {
        $this->value = rand(0 ,10);
    }

    public function get()
    {
        return $this->value;
    }
}
