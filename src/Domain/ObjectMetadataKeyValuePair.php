<?php declare(strict_types=1);

namespace Dms\Library\Metadata\Domain;

use Dms\Core\Model\Object\ClassDefinition;
use Dms\Core\Model\Object\MutableValueObject;
use Dms\Core\Model\Type\CollectionType;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class ObjectMetadataKeyValuePair extends MutableValueObject
{
    const KEY = 'key';
    const VALUE = 'value';

    /**
     * @var string
     */
    public $key;

    /**
     * @var mixed
     */
    public $value;

    /**
     * ObjectMetadataKeyValuePair constructor.
     *
     * @param string $key
     * @param mixed  $value
     */
    public function __construct(string $key, $value)
    {
        parent::__construct();
        $this->key   = $key;
        $this->value = $value;
    }

    /**
     * @param array $objects
     *
     * @return ObjectMetadata
     */
    public static function collection(array $objects = [])
    {
        return new ObjectMetadata($objects);
    }


    /**
     * @return CollectionType
     */
    public static function collectionType(): CollectionType
    {
        return new CollectionType(self::type(), ObjectMetadata::class);
    }


    /**
     * Defines the structure of this class.
     *
     * @param ClassDefinition $class
     */
    protected function define(ClassDefinition $class)
    {
        $class->property($this->key)->asString();

        $class->property($this->value)->asMixed();
    }
}