<?php

namespace Jas\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Jas\Services\PersonService;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class PersonController
 * @package Jas\Http\Controllers
 */
class PersonController extends Controller
{
    /**
     * @var PersonService
     */
    private $personService;

    /**
     * PersonController constructor.
     * @param PersonService $personService
     */
    public function __construct(PersonService $personService)
    {
        $this->personService = $personService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json($this->personService->index($request));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidatorException
     */
    public function store(Request $request): JsonResponse
    {
        return response()->json($this->personService->create($request, false), JsonResponse::HTTP_CREATED);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        return response()->json($this->personService->find($id));
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws ValidatorException
     */
    public function update(Request $request, $id): JsonResponse
    {
        return response()->json($this->personService->update($request, $id, false));
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        return response()->json($this->personService->delete($id), Response::HTTP_NO_CONTENT);
    }
}
