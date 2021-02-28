<?php

namespace Jas\Repositories;

use Jas\Interfaces\ContactRepository;
use Jas\Models\Contact;
use Jas\Presenters\ContactPresenter;
use Jas\Validators\ContactValidator;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class ContactRepositoryEloquent.
 *
 * @package namespace Jas\Interfaces;
 */
class ContactRepositoryEloquent extends BaseRepository implements ContactRepository
{
    use CacheableRepository;

    protected $fieldSearchable = [
        'name' => 'ilike',
    ];

    public function validator(): string
    {
        return ContactValidator::class;
    }

    public function model(): string
    {
        return Contact::class;
    }


    public function presenter(): ?string
    {
        return ContactPresenter::class;
    }

    /**
     * @throws RepositoryException
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function listByPerson($personId)
    {
        return $this->scopeQuery(function ($qb) use ($personId) {
            return $qb->select()->where('person_id', '=', $personId);
        })->get();
    }
}
