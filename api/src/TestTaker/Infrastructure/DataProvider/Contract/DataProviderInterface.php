<?php

namespace App\TestTaker\Infrastructure\DataProvider\Contract;

/**
 * Interface DataProviderInterface
 * @package App\TestTaker\Infrastructure\DataProvider\Contract
 */
interface DataProviderInterface
{
    /**
     * @param int|null $limit
     * @return DataProviderInterface
     */
    public function setLimit(?int $limit): DataProviderInterface;

    /**
     * @param int|null $offset
     * @return DataProviderInterface
     */
    public function setOffset(?int $offset): DataProviderInterface;

    /**
     * @param string $filter
     * @return DataProviderInterface
     */
    public function setFilter(?string $filter): DataProviderInterface;

    /**
     * @return DataProviderInterface
     */
    public function reset(): DataProviderInterface;

    /**
     * @param string $class
     * @return array
     */
    public function query(string $class): array;

    /**
     * @param string $class
     * @param string $id
     * @return object|null
     */
    public function find(string $class, string $id): ?object;
}