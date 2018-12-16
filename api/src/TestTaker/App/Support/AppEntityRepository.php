<?php

namespace App\TestTaker\App\Support;


use App\TestTaker\Infrastructure\DataProvider\Contract\DataProviderInterface;

/**
 * Class AppEntityRepository
 * @package App\TestTaker\App\EntityRepository
 */
abstract class AppEntityRepository
{
    /** @var DataProviderInterface */
    protected $dataProvider;

    /**
     * AppEntityRepository constructor.
     * @param DataProviderInterface $dataProvider
     */
    public function __construct(DataProviderInterface $dataProvider)
    {
        $this->dataProvider = $dataProvider;
    }
}