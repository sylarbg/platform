<?php

declare(strict_types=1);

namespace Orchid\Press\Entities;

abstract class Single
{
    use Structure;

    /**
     * Registered fields for main.
     *
     * @return array
     */
    public function main(): array
    {
        return [];
    }
}
