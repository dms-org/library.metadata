<?php declare(strict_types=1);

namespace Dms\Library\Metadata\Tests\Domain;

use Dms\Common\Testing\CmsTestCase;
use Dms\Library\Metadata\Domain\ObjectMetadata;
use Dms\Library\Metadata\Domain\ObjectMetadataKeyValuePair;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class ObjectMetadataTest extends CmsTestCase
{
    public function testObjectMetadataFromConstructor()
    {
        $metadata = new ObjectMetadata([
            'key' => 'value',
        ]);

        $this->assertSame(true, isset($metadata['key']));
        $this->assertSame('value', $metadata['key']);
        $this->assertEquals(['key' => 'value'], $metadata->getAll());
        $this->assertEquals(['key' => 'value'], $metadata->asArray());

        $array = [];
        foreach ($metadata as $key => $value) {
            $array[$key] = $value;
        }

        $this->assertEquals(['key' => new ObjectMetadataKeyValuePair('key', 'value')], $array);
    }

    public function testObjectMetadataWithPairsFromConstructor()
    {
        $metadata = new ObjectMetadata([
            new ObjectMetadataKeyValuePair('key', 'value'),
        ]);

        $this->assertSame(true, isset($metadata['key']));
        $this->assertSame('value', $metadata['key']);
        $this->assertEquals(['key' => 'value'], $metadata->getAll());
        $this->assertEquals(['key' => 'value'], $metadata->asArray());

        $array = [];
        foreach ($metadata as $key => $value) {
            $array[$key] = $value;
        }

        $this->assertEquals(['key' => new ObjectMetadataKeyValuePair('key', 'value')], $array);
    }

    public function testObjectMetadataSetValue()
    {
        $metadata = new ObjectMetadata();

        $metadata['key'] = 'value';

        $this->assertSame(true, isset($metadata['key']));
        $this->assertSame('value', $metadata['key']);
        $this->assertEquals(['key' => 'value'], $metadata->getAll());
        $this->assertEquals(['key' => 'value'], $metadata->asArray());

        $array = [];
        foreach ($metadata as $key => $value) {
            $array[$key] = $value;
        }

        $this->assertEquals(['key' => new ObjectMetadataKeyValuePair('key', 'value')], $array);
    }

    public function testObjectMetadataSetValueAsPair()
    {
        $metadata = new ObjectMetadata();

        $metadata[] = new ObjectMetadataKeyValuePair('key', 'value');

        $this->assertSame(true, isset($metadata['key']));
        $this->assertSame('value', $metadata['key']);
        $this->assertEquals(['key' => 'value'], $metadata->getAll());
        $this->assertEquals(['key' => 'value'], $metadata->asArray());

        $array = [];
        foreach ($metadata as $key => $value) {
            $array[$key] = $value;
        }

        $this->assertEquals(['key' => new ObjectMetadataKeyValuePair('key', 'value')], $array);
    }

    public function testUnsetValue()
    {
        $metadata = new ObjectMetadata(['key' => 'value']);

        unset($metadata['key']);

        $this->assertSame(false, isset($metadata['key']));
        $this->assertSame(null, $metadata['key']);
        $this->assertEquals([], $metadata->getAll());
        $this->assertEquals([], $metadata->asArray());

        $array = [];
        foreach ($metadata as $key => $value) {
            $array[$key] = $value;
        }

        $this->assertEquals([], $array);
    }
}