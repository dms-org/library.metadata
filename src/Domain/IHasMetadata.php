<?php declare(strict_types=1);

namespace Dms\Library\Metadata\Domain;

/**
 * The entity metadata trait.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
interface IHasMetadata
{
    const METADATA = 'metadata';

    /**
     * @return ObjectMetadata
     */
    public function getMetadata() : ObjectMetadata;
}