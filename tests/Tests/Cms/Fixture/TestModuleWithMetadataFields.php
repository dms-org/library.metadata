<?php declare(strict_types=1);

namespace Dms\Library\Metadata\Tests\Cms\Fixture;

use Dms\Common\Structure\Field;
use Dms\Core\Common\Crud\CrudModule;
use Dms\Core\Common\Crud\Definition\CrudModuleDefinition;
use Dms\Core\Common\Crud\Definition\Form\CrudFormDefinition;
use Dms\Core\Common\Crud\Definition\Table\SummaryTableDefinition;
use Dms\Library\Metadata\Cms\MetadataProperty;
use Dms\Library\Metadata\Tests\Domain\Fixture\TestEntityWithMetadata;


/**
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TestModuleWithMetadataFields extends CrudModule
{

    /**
     * Defines the structure of this module.
     *
     * @param CrudModuleDefinition $module
     */
    protected function defineCrudModule(CrudModuleDefinition $module)
    {
        $module->name('test');

        $module->labelObjects()->fromProperty(TestEntityWithMetadata::ID);

        $module->crudForm(function (CrudFormDefinition $form) {
            $form->section('Details', [
                $form->field(
                    Field::create('string', 'String')->string()
                )->bindTo(new MetadataProperty('key-string')),
                //
                $form->field(
                    Field::create('int', 'Int')->int()
                )->bindTo(new MetadataProperty('key-int')),
                //
            ]);
        });

        $module->removeAction()->deleteFromDataSource();

        $module->summaryTable(function (SummaryTableDefinition $table) {
            $table->view('all', 'All')
                ->asDefault()
                ->loadAll();
        });
    }
}