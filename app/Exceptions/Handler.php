<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
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
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {



      //  return parent::render($request, $exception);



        if($exception instanceof  ValidationException){
            return $this->convertValidationExceptionToResponse($exception, $request);
        }
        if ($exception instanceof ModelNotFoundException){
            $modelo= strtolower( class_basename($exception->getModel()));
            return response()->json('No existe la instancia '.$modelo.' con el id especifico', 404);

            return $this->errorResponse('No existe la instancia '.$modelo.' con el id especifico', 404);
        }

        //En el curso aqui manda el error de autentificación,pero no la implemente por que ya esta implementada la árte de JWT


        if($exception instanceof AuthorizationException){
            return $this->errorResponse('No posee permisos para ejecutar esta acción', 403);
        }

        if($exception instanceof NotFoundHttpException){

            return $this->errorResponse('No se encontro la URL especificada', 404);
        }

        if($exception instanceof MethodNotAllowedHttpException){
            //405 codigo metodo no valido
            return $this->errorResponse('El metodo especificado en la petición no es válido', 405);
        }

        if($exception instanceof HttpException){
            //Los codigos son diversos dependiendo del error
            return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());
        }

        if($exception instanceof QueryException){
            //1451 Codigo violacion de integridad
            // 409 Conflicto dentro del sistema
            $codigo = $exception->errorInfo[1];
            if ($codigo == 1451){
                return $this->errorResponse('No se puede eliminar de forma permanente el recurso por que esta relacionado con algún otro', 409);
            }
        }

        if (config('app.debug')){
            return parent::render($request,$exception);
        }
        //500 Error interno del servidor inesperado
        return parent::render($request, $exception);
    }

    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {

        if ($e->response) {
            return $e->response;
        }

        return $request->expectsJson()
            ? $this->invalidJson($request, $e)
            : $this->invalid($request, $e);


        $errors = $e->validator->errors()->getMessages();
        return $errors;
        return $this->errorResponse($errors, 422);
        //return response()->json($errors,422);
    }

}
