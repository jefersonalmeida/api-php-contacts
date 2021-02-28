<?php

namespace Jas\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Jas\Services\ContactService;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class ContactController
 * @package Jas\Http\Controllers
 */
class ContactController extends Controller
{
    /**
     * @var ContactService
     */
    private $contactService;

    /**
     * ContactController constructor.
     * @param ContactService $contactService
     */
    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    /**
     * @param Request $request
     * @param $personId
     * @return JsonResponse
     */
    public function index(Request $request, $personId): JsonResponse
    {
        return response()->json($this->contactService->index($request, $personId));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidatorException
     */
    public function store(Request $request, $personId): JsonResponse
    {
        return response()->json($this->contactService->create($request, $personId, false), JsonResponse::HTTP_CREATED);
    }

    /**
     * @param $personId
     * @param $id
     * @return JsonResponse
     */
    public function show($personId, $id): JsonResponse
    {
        return response()->json($this->contactService->find($personId, $id));
    }

    /**
     * @param Request $request
     * @param $personId
     * @param $id
     * @return JsonResponse
     * @throws ValidatorException
     */
    public function update(Request $request, $personId, $id): JsonResponse
    {
        return response()->json($this->contactService->update($request, $personId, $id, false));
    }

    /**
     * @param $personId
     * @param $id
     * @return JsonResponse
     */
    public function destroy($personId, $id): JsonResponse
    {
        return response()->json($this->contactService->delete($personId, $id), Response::HTTP_NO_CONTENT);
    }
}
