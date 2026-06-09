<?php


use App\Exceptions\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    // Otros métodos del manejador de excepciones...

   public function render($request, Throwable $e)
{
    $statusCode = $this->getStatusCode($e);

    $routes = [403, 419, 500, 503, 404];

    if (in_array($statusCode, $routes)) {
        return redirect()->route("error.{$statusCode}");
    }

    return parent::render($request, $e);
}

private function getStatusCode(Throwable $e): int
{
    if ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface) {
        return $e->getStatusCode();
    }

    return 500;
}
}