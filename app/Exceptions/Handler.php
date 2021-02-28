<?php

namespace Jas\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Validation\UnauthorizedException;
use Prettus\Validator\Exceptions\ValidatorException;
use Symfony\Component\HttpFoundation;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    const DEFAULT = 'Erro ao processar a solicitação.';
    const RESOURCE_NOT_FOUND = 'Erro ao procurar algum registro.';
    const BAD_REQUEST = 'Erro ao validar algum registro.';
    const UNAUTHORIZED = 'Erro ao buscar o usuário autenticado.';
    const FILE_NOT_FOUND = 'Erro ao buscar algum arquivo.';
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register()
    {
        $this->renderable(function (ModelNotFoundException $e, $request) {
            return $this->formatError($e,
                self::RESOURCE_NOT_FOUND,
                Response::HTTP_NOT_FOUND,
                'Recurso não encontrado.'
            );
        });
        $this->renderable(function (NotFoundHttpException $e, $request) {
            return $this->formatError($e,
                self::RESOURCE_NOT_FOUND,
                Response::HTTP_NOT_FOUND,
                'Recurso não encontrado ou o parâmetro é inválido.'
            );
        });
        $this->renderable(function (ValidatorException $e, $request) {
            return $this->formatError($e,
                self::BAD_REQUEST,
                Response::HTTP_BAD_REQUEST,
                $e->getMessageBag()
            );
        });
        $this->renderable(function (UnauthorizedException $e, $request) {
            return $this->formatError($e,
                self::UNAUTHORIZED,
                Response::HTTP_UNAUTHORIZED,
                $e->getMessage() ?: 'Você não está autenticado no sistema.'
            );
        });
        $this->renderable(function (UnauthorizedHttpException $e, $request) {
            return $this->formatError($e,
                self::UNAUTHORIZED,
                Response::HTTP_UNAUTHORIZED,
                $e->getMessage() ?: 'Você não está autenticado no sistema.'
            );
        });
        $this->renderable(function (FileNotFoundException $e, $request) {
            return $this->formatError($e,
                self::FILE_NOT_FOUND,
                Response::HTTP_NOT_FOUND,
                sprintf('Arquivo "%s" não encontrado', $e->getMessage())
            );
        });
    }

    private function formatError(Throwable $e, $title, $status, $message): JsonResponse
    {
        $path = \request()->path();
        return response()->json(config('app.debug') ? [
            'error' => true,
            'title' => $title ?: self::DEFAULT,
            'status' => $status,
            'path' => $path,
            'message' => $message,
            'exception' => get_class($e),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => collect($e->getTrace())->map(function ($trace) {
                return Arr::except($trace, ['args']);
            })->all(),
        ] : [
            'error' => true,
            'title' => $title,
            'status' => $status,
            'path' => $path,
            'message' => $message,
        ], $status);
    }

    /**
     * Convert the given exception to an array.
     *
     * @param Throwable $e
     * @return array
     */
    protected function convertExceptionToArray(Throwable $e): array
    {
        $path = \request()->path();
        return config('app.debug') ? [
            'error' => true,
            'title' => self::DEFAULT,
            'status' =>
                $this->isHttpException($e)
                && method_exists($e, 'getStatusCode')
                    ? $e->getStatusCode()
                    : Response::HTTP_INTERNAL_SERVER_ERROR,
            'path' => $path,
            'message' => $e->getMessage(),
            'exception' => get_class($e),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => collect($e->getTrace())->map(function ($trace) {
                return Arr::except($trace, ['args']);
            })->all(),
        ] : [
            'error' => true,
            'title' => self::DEFAULT,
            'status' =>
                $this->isHttpException($e)
                && method_exists($e, 'getStatusCode')
                    ? $e->getStatusCode()
                    : Response::HTTP_INTERNAL_SERVER_ERROR,
            'path' => $path,
            'message' => $this->isHttpException($e) ? $e->getMessage() : 'Erro interno do servidor',
        ];
    }

    /**
     * @param Request $request
     * @param AuthenticationException $exception
     * @return JsonResponse|HttpFoundation\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $this->formatError($exception,
            self::UNAUTHORIZED,
            Response::HTTP_UNAUTHORIZED,
            'Você não está autenticado no sistema.'
        );
    }
}
