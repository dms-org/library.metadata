<?php declare(strict_types=1);

namespace Dms\Library\Metadata\Domain;

use Dms\Core\Model\Object\ClassDefinition;
use Dms\Core\Model\Type\Builder\Type;

/**
 * The entity metadata trait.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
trait MetadataTrait
{
    /**
     * @var ObjectMetadata|ObjectMetadataKeyValuePair[]
     */
    public $metadata;

    /**
     * Defines the structure of this trait.
     *
     * @param ClassDefinition $class
     */
    final protected function defineMetadata(ClassDefinition $class)
    {
        $class->property($this->metadata)->asType(ObjectMetadataKeyValuePair::collectionType());
    }

    /**
     * @return ObjectMetadata
     */
    public function getMetadata() : ObjectMetadata
    {
        if (!$this->metadata) {
            $this->metadata = new ObjectMetadata();
        }

        return $this->metadata;
    }
}