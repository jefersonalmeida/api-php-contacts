<?php


namespace Jas\Services;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Jas\Interfaces\PersonRepository;
use Jas\Repositories\PersonRepositoryEloquent;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class PersonService
 * @package Jas\Services
 */
class PersonService
{
    /**
     * @var PersonRepository|PersonRepositoryEloquent
     */
    private $personRepository;

    /**
     * PersonService constructor.
     * @param PersonRepository $personRepository
     */
    public function __construct(PersonRepository $personRepository)
    {
        $this->personRepository = $personRepository;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        return $this->personRepository->skipPresenter(false)->all();
    }

    /**
     * @param Request $request
     * @param bool $skipPresenter
     * @param null $presenter
     * @return LengthAwarePaginator|Collection|mixed
     * @throws ValidatorException
     */
    public function create(Request $request, $skipPresenter = true, $presenter = null)
    {
        if (!$skipPresenter) {
            $this->personRepository->skipPresenter($skipPresenter);
        }
        if ($presenter) {
            $this->personRepository->skipPresenter(false)->setPresenter($presenter);
        }
        return $this->personRepository->create($request->all());
    }

    /**
     * @param Request $request
     * @param $id
     * @param bool $skipPresenter
     * @param null $presenter
     * @return LengthAwarePaginator|Collection|mixed
     * @throws ValidatorException
     */
    public function update(Request $request, $id, $skipPresenter = true, $presenter = null)
    {
        if (!$skipPresenter) {
            $this->personRepository->skipPresenter($skipPresenter);
        }
        if ($presenter) {
            $this->personRepository->skipPresenter(false)->setPresenter($presenter);
        }
        return $this->personRepository->update($request->all(), $id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->personRepository->skipPresenter(false)->find($id);
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id): int
    {
        return $this->personRepository->delete($id);
    }
}
