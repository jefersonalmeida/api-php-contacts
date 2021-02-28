<?php

namespace Jas\Interfaces;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface PersonRepository.
 *
 * @package namespace Jas\Repositories;
 */
interface ContactRepository extends RepositoryInterface
{
    /**
     * @param $personId
     * @return mixed
     */
    public function listByPerson($personId);
}
