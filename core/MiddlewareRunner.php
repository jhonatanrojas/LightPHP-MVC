<?php
namespace core;

class MiddlewareRunner
{
    protected $middlewares = [];

    public function __construct(array $middlewares)
    {
        $this->middlewares = $middlewares;
    }

    public function run($request)
    {
        $middlewareChain = $this->buildMiddlewareChain($request);
        return $middlewareChain($request);
    }

    protected function buildMiddlewareChain($request)
    {
        $middlewareChain = function ($request) {
            // La solicitud final después de todos los middlewares
            return $request;
        };

        // Recorre los middlewares en orden inverso para construir la cadena
        foreach (array_reverse($this->middlewares) as $middleware) {
            $middlewareChain = function ($request) use ($middleware, $middlewareChain) {
                return $middleware->handle($request, $middlewareChain);
            };
        }

        return $middlewareChain;
    }
}
