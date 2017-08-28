<?php declare(strict_types=1);

namespace Dms\Library\Metadata\Domain;

use Dms\Core\Model\Collection;
use Dms\Core\Model\ValueObjectCollection;
use Dms\Library\Metadata\Infrastructure\Persistence\LazyObjectMetadata;
use Pinq\Iterators\IIteratorScheme;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class ObjectMetadata extends ValueObjectCollection
{
    /**
     * @param \Traversable|ObjectMetadataKeyValuePair[] $values
     * @param IIteratorScheme|null                      $scheme
     * @param Collection|null                           $source
     */
    public function __construct(
        $values = [],
        IIteratorScheme $scheme = null,
        Collection $source = null
    ) {
        parent::__construct(ObjectMetadataKeyValuePair::class, [], $scheme, $source);

        $this->updateElements(new \ArrayIterator($values));
    }

    /**
     * @param callable $callback
     *
     * @return LazyObjectMetadata
     */
    public function createLazyCollection(callable $callback): LazyObjectMetadata
    {
        return new LazyObjectMetadata($callback, $this->scheme);
    }

    public function asArray()
    {
        /** @var ObjectMetadataKeyValuePair[] $pairs */
        $pairs = $this->toOrderedMap()->values();
        $array = [];

        foreach ($pairs as $pair) {
            $array[$pair->key] = $pair->value;
        }

        return $array;
    }

    public function getAll(): array
    {
        return $this->asArray();
    }

    protected function updateElements(\Traversable $elements)
    {
        $pairs = [];

        foreach ($elements as $key => $element) {
            if ($element instanceof ObjectMetadataKeyValuePair) {
                $pairs[$element->key] = $element;
            } else {
                $pairs[$key] = new ObjectMetadataKeyValuePair($key, $element);
            }
        }

        parent::updateElements(new \ArrayIterator($pairs));
    }

    public function offsetSet($index, $value)
    {
        if ($value instanceof ObjectMetadataKeyValuePair) {
            parent::offsetSet($value->key, $value);
        } else {
            parent::offsetSet($index, new ObjectMetadataKeyValuePair($index, $value));
        }
    }

    public function offsetGet($key)
    {
        $pair = parent::offsetGet($key);

        return $pair instanceof ObjectMetadataKeyValuePair ? $pair->value : $pair;
    }
}