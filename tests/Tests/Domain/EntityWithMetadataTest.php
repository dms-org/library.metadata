<?php declare(strict_types=1);

namespace Dms\Library\Metadata\Tests\Domain;

use Dms\Common\Testing\CmsTestCase;
use Dms\Library\Metadata\Domain\ObjectMetadata;
use Dms\Library\Metadata\Tests\Domain\Fixture\TestEntityWithMetadata;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class EntityWithMetadataTest extends CmsTestCase
{
    public function testEntity()
    {
        $entity = new TestEntityWithMetadata();

        $entity->metadata['key'] = 'value';

        $this->assertInstanceOf(ObjectMetadata::class, $entity->metadata);
        $this->assertSame('value', $entity->metadata['key']);
    }
}