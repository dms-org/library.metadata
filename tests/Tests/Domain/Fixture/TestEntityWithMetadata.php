<?php declare(strict_types=1);

namespace Dms\Library\Metadata\Tests\Domain\Fixture;

use Dms\Core\Model\Object\ClassDefinition;
use Dms\Core\Model\Object\Entity;
use Dms\Library\Metadata\Domain\IHasMetadata;
use Dms\Library\Metadata\Domain\MetadataTrait;
use Dms\Library\Metadata\Domain\ObjectMetadata;

/**
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TestEntityWithMetadata extends Entity implements IHasMetadata
{
    use MetadataTrait;

    public function __construct($id = null)
    {
        parent::__construct($id);

        $this->metadata = new ObjectMetadata();
    }

    /**
     * Defines the structure of this entity.
     *
     * @param ClassDefinition $class
     */
    protected function defineEntity(ClassDefinition $class)
    {
        $this->defineMetadata($class);
    }
}