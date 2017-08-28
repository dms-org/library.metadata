<?php declare(strict_types=1);

namespace Dms\Library\Metadata\Cms;

use Dms\Core\Form\Binding\Accessor\FieldAccessor;
use Dms\Library\Metadata\Domain\IHasMetadata;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class MetadataProperty extends FieldAccessor
{
    /**
     * @var string
     */
    private $metadataKey;

    public function __construct(string $metadataKey)
    {
        parent::__construct(IHasMetadata::class);
        $this->metadataKey = $metadataKey;
    }

    /**
     * @param IHasMetadata $object
     *
     * @return mixed
     */
    protected function getValueFrom($object)
    {
        return $object->getMetadata()[$this->metadataKey];
    }

    /**
     * @param IHasMetadata $object
     * @param mixed  $processedFieldValue
     *
     * @return void
     */
    protected function bindValueTo($object, $processedFieldValue)
    {
        $object->getMetadata()[$this->metadataKey] = $processedFieldValue;
    }
}