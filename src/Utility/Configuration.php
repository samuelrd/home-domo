<?php

namespace App\Utility;

class Configuration
{

    private $configuration;

    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;
    }

    public function get(string $key)
    {
        return $this->configuration[$key];
    }

    public function all()
    {
        return $this->configuration;
    }
}
