<?php

namespace App\TestTaker\Infrastructure\DataProvider\Adapter;



use App\TestTaker\Infrastructure\DataProvider\Contract\SearchableInterface;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class CsvAdapter
 * @package App\TestTaker\Infrastructure\DataProvider\Adapter
 */
class CsvAdapter extends AbstractFileAdapter
{
    protected const SUPPORTED_EXTENSION = ['csv'];
    protected const SUPPORTED_MIMETYPE = ['text/plain', 'text/csv', 'application/csv'];

    /** @var string  */
    protected $delimiter = ',';

    /** @var string  */
    protected $enclosure = '"';

    /** @var string  */
    protected $escape = '\\';

    /** @var SerializerInterface */
    private $serializer;

    /**
     * CsvAdapter constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param $options
     */
    public function setOptions($options): void
    {
        parent::setOptions($options);

        if (isset($options['delimiter'])) {
            $this->delimiter = $options['delimiter'];
        }

        if (isset($options['enclosure'])) {
            $this->enclosure = $options['enclosure'];
        }

        if (isset($options['escape'])) {
            $this->escape = $options['escape'];
        }
    }

    /**
     * @param string $class
     * @return array
     */
    public function query(string $class): array
    {
        $objectArray = [];
        $this->file->rewind();
        $header = $this->file->fgets();

        for ($i=0;!$this->file->eof() && $i < $this->offset; $i++) {
            $this->file->next();
        }

        for ($i=0;!$this->file->eof() && (!$this->hasLimit() || $i <= $this->limit); $i++) {
            $data = trim($this->file->fgets());

            if ($data === "") {
                continue;
            }

            if ($this->hasFilter() && mb_stripos($data, $this->filter) === false) {
                continue;
            }

            $objectArray[] = $this->stringToObject($data, $class, $header);
        }

        return $objectArray;
    }

    /**
     * @param string $class
     * @param string $id
     * @return null|object
     */
    public function find(string $class, string $id): ?object
    {
        $this->file->rewind();
        $header = $this->file->fgets();
        for ($i = 0;!$this->file->eof(); $i++) {
            $data = $this->file->fgets();
            $object = $this->stringToObject($data, $class, $header);
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
     * @param string $data
     * @param string $class
     * @param string $header
     * @return object
     */
    protected function stringToObject(string $data, string $class, string $header): object
    {
        return $this->serializer->deserialize(
            $header.$data,
            $class,
            'csv',
            [
                CsvEncoder::DELIMITER_KEY => $this->delimiter,
                CsvEncoder::ENCLOSURE_KEY => $this->enclosure,
                CsvEncoder::ESCAPE_CHAR_KEY => $this->escape
            ]
        );
    }
}