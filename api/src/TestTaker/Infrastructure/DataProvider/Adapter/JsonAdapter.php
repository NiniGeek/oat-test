<?php

namespace App\TestTaker\Infrastructure\DataProvider\Adapter;


use App\TestTaker\Infrastructure\DataProvider\Contract\SearchableInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class JsonAdapter
 * @package App\TestTaker\Infrastructure\DataProvider\Adapter
 */
class JsonAdapter extends AbstractFileAdapter
{
    protected const SUPPORTED_EXTENSION = ['json'];
    protected const SUPPORTED_MIMETYPE = ['text/plain', 'application/json', 'text/json'];

    /** @var SerializerInterface */
    private $serializer;

    /**
     * JsonAdapter constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param string $class
     * @param string $id
     * @return object
     */
    public function find(string $class, string $id): ?object
    {
        $objectArray = $this->retrieveData($class);
        foreach ($objectArray as $object) {
            if ($object instanceof SearchableInterface) {
                if ($object->hasId($id)) {
                    return $object;
                }
            } else {
                throw new \RuntimeException("$class must implement SearchableInterface");
            }
        }

        return null;
    }

    /**
     * @param string $class
     * @return array
     */
    public function query(string $class): array
    {
        $objectArr = $this->retrieveData($class);
        $objectArr = $this->filter($objectArr);
        return $this->paginate($objectArr);
    }

    /**
     * @param string $class
     * @return array
     */
    private function retrieveData(string $class): array
    {
        $jsonContent = $this->file->fread($this->file->getSize());
        $objectArr = $this->serializer->deserialize($jsonContent, $class . '[]', 'json');

        if (!is_array($objectArr)) {
            throw new \RuntimeException("Not an array of Object '$class'");
        }

        return $objectArr;
    }

    /**
     * @param array $array
     * @return array
     */
    private function filter(array $array): array
    {
        if (!$this->hasFilter()) {
            return $array;
        }

        $filter = $this->filter;
        return array_filter($array, function (SearchableInterface $object) use ($filter) {
            return $object->hasData($filter);
        });
    }

    /**
     * @param array $array
     * @return array
     */
    private function paginate(array $array): array
    {
        if (!$this->hasLimit()) {
            return $array;
        }

        return array_slice($array, $this->offset, $this->limit);
    }
}