<?php

namespace App\TestTaker\Infrastructure\DataProvider\Contract;

/**
 * Interface SearchableInterface
 * @package App\TestTaker\Infrastructure\DataProvider\Contract
 */
interface SearchableInterface
{
    /**
     * @param string $data
     * @return bool
     */
    public function hasData(string $data): bool;

    /**
     * @param string $id
     * @return bool
     */
    public function hasId(string $id): bool;
}