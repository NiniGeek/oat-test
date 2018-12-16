<?php

namespace App\TestTaker\Infrastructure\DataProvider\Contract;

/**
 * Interface DataFormatAdapterInterface
 * @package App\TestTaker\Infrastructure\DataProvider\Contract
 */
interface DataFormatAdapterInterface
{
    /**
     * @param array $options
     * @return bool
     */
    public function canHandleOptions(array $options): bool;

    /**
     * @param int $limit
     * @return DataFormatAdapterInterface
     */
    public function setLimit(?int $limit): DataFormatAdapterInterface;

    /**
     * @param int $offset
     * @return DataFormatAdapterInterface
     */
    public function setOffset(int $offset): DataFormatAdapterInterface;

    /**
     * @param string $filter
     * @return DataFormatAdapterInterface
     */
    public function setFilter(?string $filter): DataFormatAdapterInterface;

    /**
     * @return DataFormatAdapterInterface
     */
    public function reset(): DataFormatAdapterInterface;

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