<?php

namespace Jas\Repositories;

use Jas\Interfaces\PersonRepository;
use Jas\Models\Person;
use Jas\Presenters\PersonPresenter;
use Jas\Validators\PersonValidator;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class PersonRepositoryEloquent.
 *
 * @package namespace Jas\Interfaces;
 */
class PersonRepositoryEloquent extends BaseRepository implements PersonRepository
{
    use CacheableRepository;

    protected $fieldSearchable = [
        'name' => 'ilike',
    ];

    public function validator(): string
    {
        return PersonValidator::class;
    }

    public function model(): string
    {
        return Person::class;
    }


    public function presenter(): ?string
    {
        return PersonPresenter::class;
    }

    /**
     * @throws RepositoryException
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
