<?php declare(strict_types=1);

namespace Dms\Library\Metadata\Infrastructure\Persistence;

use Dms\Core\Persistence\Db\Mapping\Definition\MapperDefinition;
use Dms\Core\Persistence\Db\Mapping\IndependentValueObjectMapper;
use Dms\Library\Metadata\Domain\IHasMetadata;
use Dms\Library\Metadata\Domain\ObjectMetadata;
use Dms\Library\Metadata\Domain\ObjectMetadataKeyValuePair;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class MetadataMapper extends IndependentValueObjectMapper
{
    /**
     * @param MapperDefinition $map
     * @param string           $columnName
     */
    public static function mapMetadataToJsonColumn(MapperDefinition $map, string $columnName)
    {
        $map->property(IHasMetadata::METADATA)
            ->mappedVia(function (ObjectMetadata $metadata) {
                return json_encode($metadata->asArray());
            }, function (string $json) {
                return new ObjectMetadata((array)@json_decode($json, true));
            })
            ->to($columnName)
            ->asMediumText();
    }

    /**
     * Defines the value object mapper
     *
     * @param MapperDefinition $map
     *
     * @return void
     */
    protected function define(MapperDefinition $map)
    {
        $map->type(ObjectMetadataKeyValuePair::class);

        $map->property(ObjectMetadataKeyValuePair::KEY)->to('key')->unique()->asVarchar(500);

        $map->property(ObjectMetadataKeyValuePair::VALUE)
            ->mappedVia(function ($value) {
                return json_encode($value);
            }, function (string $json) {
                return @json_decode($json, true);
            })
            ->to('value')
            ->asMediumText();
    }
}