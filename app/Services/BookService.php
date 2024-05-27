<?php

namespace App\Services;

class BookService
{
    public function __construct(protected ?string $configuration = null)
    {

    }
    public function load()
    {
        if ($this->configuration == null) {
            dd('loaded without configuration');
        } else {
            dd('loaded with configuration ' . $this->configuration);
        }
    }
}
