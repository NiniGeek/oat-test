<?php

namespace App\TestTaker\Infrastructure\DataProvider;



use App\TestTaker\Infrastructure\DataProvider\Contract\DataFormatAdapterInterface;
use App\TestTaker\Infrastructure\DataProvider\Contract\DataProviderInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class DataProvider
 * @package App\TestTaker\Infrastructure\DataProvider
 */
class DataProvider implements DataProviderInterface
{
    /** @var DataFormatAdapterInterface */
    protected $adapter;

    /** @var ValidatorInterface */
    protected $validator;

    /** @var LoggerInterface */
    protected $logger;

    /**
     * DataProvider constructor.
     * @param array $adapterList
     * @param array $options
     * @param ValidatorInterface $validator
     * @param LoggerInterface $logger
     */
    public function __construct(array $adapterList, array $options, ValidatorInterface $validator, LoggerInterface $logger)
    {
        foreach ($adapterList as $adapter) {
            if ($adapter instanceof DataFormatAdapterInterface && $adapter->canHandleOptions($options)) {
                $this->adapter = $adapter;
                $this->adapter->setOptions($options);
                break;
            }
        }

        if ($this->adapter === null) {
            throw new \RuntimeException('DataProvider is missconfigured or provider not found for this options');
        }
        $this->validator = $validator;
        $this->logger = $logger;
    }

    /**
     * @param int|null $limit
     * @return DataProviderInterface
     */
    public function setLimit(?int $limit): DataProviderInterface
    {
        $this->adapter->setLimit($limit);
        return $this;
    }

    /**
     * @param int|null $offset
     * @return DataProviderInterface
     */
    public function setOffset(?int $offset): DataProviderInterface
    {
        $this->adapter->setOffset((int) $offset);
        return $this;
    }

    /**
     * @param string $filter
     * @return DataProviderInterface
     */
    public function setFilter(?string $filter): DataProviderInterface
    {
        $this->adapter->setFilter($filter);
        return $this;
    }

    /**
     * @return DataProviderInterface
     */
    public function reset(): DataProviderInterface
    {
        $this->adapter->reset();
        return $this;
    }

    /**
     * @param string $class
     * @return array
     */
    public function query(string $class): array
    {
        try {
            $dataList = $this->adapter->query($class);

            foreach ($dataList as $key => $data) {
                $validatorResult = $this->validator->validate($data);
                if ($validatorResult->count() > 0) {
                    /** @var ConstraintViolationInterface $constraint */
                    foreach ($validatorResult as $constraint) {
                        $this->logger->warning("No valid data input for $class: " . $constraint->getMessage() . ' ' .print_r($data, true));
                    }
                    unset($dataList[$key]);
                }
            }

            return $dataList;
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage());
            return [];
        }
    }

    /**
     * @param string $class
     * @param string $id
     * @return object|null
     */
    public function find(string $class, string $id): ?object
    {
        try {
            $data = $this->adapter->find($class, $id);
            $validatorResult = $this->validator->validate($data);
            if ($validatorResult->count() > 0) {
                throw new \RuntimeException("No valid data input for $class: " . print_r($validatorResult, true) . ' ' . print_r($data, true));
            }
            return $data;
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage());
            return null;
        }
    }
}