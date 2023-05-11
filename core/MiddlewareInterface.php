<?php
namespace core;

use Closure;
interface MiddlewareInterface
{
    public function handle($request, Closure $next);
}
