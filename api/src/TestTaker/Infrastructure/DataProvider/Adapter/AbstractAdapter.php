<?php

namespace App\TestTaker\Infrastructure\DataProvider\Adapter;


use App\TestTaker\Infrastructure\DataProvider\Contract\DataFormatAdapterInterface;

/**
 * Class AbstractAdapter
 * @package App\TestTaker\Infrastructure\DataProvider\Adapter
 */
abstract class AbstractAdapter implements DataFormatAdapterInterface
{
    /** @var array */
    protected $options;

    /** @var int */
    protected $limit;

    /** @var int */
    protected $offset = 0;

    /** @var string */
    protected $filter;

    /**
     * @param $options
     */
    public function setOptions($options): void
    {
        $this->options = $options;
    }

    /**
     * @param int $limit
     * @return DataFormatAdapterInterface
     */
    public function setLimit(?int $limit): DataFormatAdapterInterface
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasLimit(): bool
    {
        return $this->limit !== null;
    }

    /**
     * @param int $offset
     * @return DataFormatAdapterInterface
     */
    public function setOffset(int $offset): DataFormatAdapterInterface
    {
        $this->offset = $offset;
        return $this;
    }

    /**
     * @param string $filter
     * @return DataFormatAdapterInterface
     */
    public function setFilter(?string $filter): DataFormatAdapterInterface
    {
        $this->filter = $filter;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasFilter(): bool
    {
        return $this->filter !== null;
    }

    /**
     * @return DataFormatAdapterInterface
     */
    public function reset(): DataFormatAdapterInterface
    {
        $this->limit = null;
        $this->offset = 0;
        $this->filter = null;
        return $this;
    }
}