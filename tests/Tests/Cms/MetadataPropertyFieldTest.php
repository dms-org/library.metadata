<?php declare(strict_types=1);

namespace Dms\Library\Metadata\Tests\Cms;

use Dms\Core\Auth\IPermission;
use Dms\Core\Auth\Permission;
use Dms\Core\Common\Crud\ICrudModule;
use Dms\Core\Model\IMutableObjectSet;
use Dms\Core\Tests\Common\Crud\Modules\CrudModuleTest;
use Dms\Core\Tests\Module\Mock\MockAuthSystem;
use Dms\Library\Metadata\Tests\Cms\Fixture\TestModuleWithMetadataFields;
use Dms\Library\Metadata\Tests\Domain\Fixture\TestEntityWithMetadata;


/**
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class MetadataPropertyFieldTest extends CrudModuleTest
{

    /**
     * @return IMutableObjectSet
     */
    protected function buildRepositoryDataSource(): IMutableObjectSet
    {
        $entity                         = new TestEntityWithMetadata(1);
        $entity->metadata['key-string'] = 'initial-value';

        return TestEntityWithMetadata::collection([$entity,]);
    }

    /**
     * @param IMutableObjectSet $dataSource
     * @param MockAuthSystem    $authSystem
     *
     * @return ICrudModule
     */
    protected function buildCrudModule(IMutableObjectSet $dataSource, MockAuthSystem $authSystem): ICrudModule
    {
        return new TestModuleWithMetadataFields($dataSource, $authSystem);
    }

    /**
     * @return string
     */
    protected function expectedName()
    {
        return 'test';
    }

    /**
     * @return IPermission[]
     */
    protected function expectedReadModulePermissions()
    {
        return [
            Permission::named(ICrudModule::CREATE_PERMISSION),
            Permission::named(ICrudModule::EDIT_PERMISSION),
            Permission::named(ICrudModule::REMOVE_PERMISSION),
        ];
    }

    /**
     * @inheritDoc
     */
    protected function expectedReadModuleRequiredPermissions()
    {
        return [Permission::named(ICrudModule::VIEW_PERMISSION)];
    }

    public function testCreate()
    {
        $entity = $this->module->getCreateAction()->run([
            'string' => 'abc',
            'int'    => 123,
        ]);

        $this->assertEquals([
            'key-string' => 'abc',
            'key-int'    => 123,
        ], $entity->metadata->getAll());
    }

    public function testEditInitialValues()
    {
        $values = $this->module->getEditAction()->getStagedForm()->tryLoadFormForStage(2, ['object' => 1])->getInitialValues();

        $this->assertEquals([
            'string' => 'initial-value',
            'int'    => null,
        ], $values);
    }

    public function testEdit()
    {
        $entity = $this->module->getEditAction()->run([
            'object' => 1,
            'string' => 'abc',
            'int'    => 123,
        ]);

        $this->assertEquals([
            'key-string' => 'abc',
            'key-int'    => 123,
        ], $entity->metadata->getAll());
    }
}