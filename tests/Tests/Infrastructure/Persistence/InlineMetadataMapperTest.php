<?php declare(strict_types=1);

namespace Dms\Library\Metadata\Tests\Tests\Infrastructure\Persistence;

use Dms\Core\Persistence\Db\Mapping\CustomOrm;
use Dms\Core\Persistence\Db\Mapping\IOrm;
use Dms\Core\Tests\Persistence\Db\Integration\Mapping\DbIntegrationTest;
use Dms\Library\Metadata\Tests\Domain\Fixture\TestEntityWithMetadata;
use Dms\Library\Metadata\Tests\Infrastructure\Persistence\Fixture\TestEntityWithInlineMetadataMapper;


/**
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class InlineMetadataMapperTest extends DbIntegrationTest
{

    /**
     * @return IOrm
     */
    protected function loadOrm()
    {
        return CustomOrm::from([TestEntityWithMetadata::class => TestEntityWithInlineMetadataMapper::class]);
    }

    public function testSaveAndLoad()
    {
        $entity                    = new TestEntityWithMetadata();
        $entity->metadata['key-1'] = 'value';
        $entity->metadata['key-2'] = 123;

        $this->repo->save($entity);

        $this->assertDatabaseDataSameAs([
            'data' => [
                [
                    'id'       => 1,
                    'metadata' => '{"key-1":"value","key-2":123}',
                ]
            ],
        ]);

        $loadedEntity = $this->repo->get(1);
        $this->assertEquals($entity->metadata->getAll(), $loadedEntity->metadata->getAll());
    }
}