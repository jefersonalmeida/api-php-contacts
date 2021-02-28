<?php

namespace Jas\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Jas\Interfaces\ContactRepository;
use Jas\Models\Contact;
use Jas\Repositories\ContactRepositoryEloquent;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class ContactService
 * @package Jas\Services\Office
 */
class ContactService
{
    /**
     * @var ContactRepository|ContactRepositoryEloquent
     */
    private $contactRepository;

    /**
     * ContactService constructor.
     * @param ContactRepository $contactRepository
     */
    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    /**
     * @param Request $request
     * @param $personId
     * @param bool $skipPresenter
     * @param null $presenter
     * @return LengthAwarePaginator|Collection|mixed
     * @throws ValidatorException
     */
    public function create(Request $request, $personId, $skipPresenter = true, $presenter = null)
    {
        $data = $request->all();
        $data['person_id'] = $personId;

        if (!$skipPresenter) {
            $this->contactRepository->skipPresenter($skipPresenter);
        }
        if ($presenter) {
            $this->contactRepository->skipPresenter(false)->setPresenter($presenter);
        }
        return $this->contactRepository->create($data);
    }

    /**
     * @param Request $request
     * @param $entityId
     * @param $personId
     * @param bool $skipPresenter
     * @param null $presenter
     * @return LengthAwarePaginator|Collection|mixed
     * @throws ValidatorException
     */
    public function update(Request $request, $personId, $entityId, $skipPresenter = true, $presenter = null)
    {
        $entity = $this->getEntityAndValidate($personId, $entityId);

        $data = $request->all();
        $data['person_id'] = $personId;

        if (!$skipPresenter) {
            $this->contactRepository->skipPresenter($skipPresenter);
        }
        if ($presenter) {
            $this->contactRepository->skipPresenter(false)->setPresenter($presenter);
        }
        return $this->contactRepository->update($data, $entity->id);
    }

    /**
     * @param $personId
     * @param $entityId
     * @return Contact
     */
    private function getEntityAndValidate($personId, $entityId): Contact
    {
        /**
         * @var $entity Contact
         */
        $entity = $this->contactRepository->skipPresenter()->skipCriteria()->find($entityId);
        abort_if(
            $entity->person_id !== $personId,
            Response::HTTP_FORBIDDEN,
            'Este contato não pertence a esta pessoa.'
        );
        return $entity;
    }

    /**
     * @param $personId
     * @param $entityId
     * @return mixed
     */
    public function find($personId, $entityId)
    {
        $entity = $this->getEntityAndValidate($personId, $entityId);
        return $this->contactRepository->skipPresenter(false)->find($entity->id);
    }

    /**
     * @param Request $request
     * @param $personId
     * @return mixed
     */
    public function index(Request $request, $personId)
    {
        return $this->contactRepository->skipPresenter(false)->listByPerson($personId);
    }

    public function delete($personId, $entityId): int
    {
        $entity = $this->getEntityAndValidate($personId, $entityId);
        return $this->contactRepository->delete($entity->id);
    }
}
