<?php declare(strict_types=1);

namespace Dms\Library\Metadata\Infrastructure\Persistence;

use Dms\Core\Persistence\Db\Mapping\Relation\Lazy\Collection\ILazyCollection;
use Dms\Core\Persistence\Db\Mapping\Relation\Lazy\Collection\LazyCollectionTrait;
use Dms\Library\Metadata\Domain\ObjectMetadata;
use Pinq\Iterators\IIteratorScheme;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class LazyObjectMetadata extends ObjectMetadata implements ILazyCollection
{
    use LazyCollectionTrait;

    /**
     * @param callable             $valueObjectCallback
     * @param IIteratorScheme|null $scheme
     */
    public function __construct(
        callable $valueObjectCallback,
        IIteratorScheme $scheme = null
    ) {
        parent::__construct([], $scheme);

        $this->setLazyLoadingCallback($valueObjectCallback);
        $this->instanceMap = null;
    }
}