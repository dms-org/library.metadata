<?php declare(strict_types=1);

namespace Dms\Library\Metadata\Tests\Infrastructure\Persistence\Fixture;

use Dms\Core\Persistence\Db\Mapping\Definition\MapperDefinition;
use Dms\Core\Persistence\Db\Mapping\EntityMapper;
use Dms\Library\Metadata\Infrastructure\Persistence\MetadataMapper;
use Dms\Library\Metadata\Tests\Domain\Fixture\TestEntityWithMetadata;


/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TestEntityWithExternalTableMetadataMapper extends EntityMapper
{

    /**
     * Defines the entity mapper
     *
     * @param MapperDefinition $map
     *
     * @return void
     */
    protected function define(MapperDefinition $map)
    {
        $map->type(TestEntityWithMetadata::class);
        $map->toTable('data');

        $map->idToPrimaryKey('id');

        $map->embeddedCollection(TestEntityWithMetadata::METADATA)
            ->toTable('data_metadata')
            ->withPrimaryKey('id')
            ->withForeignKeyToParentAs('data_id')
            ->using(new MetadataMapper());
    }
}