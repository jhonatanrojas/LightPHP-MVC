<?php

namespace core;

use controllers\NotFoundController;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

use Exception;

class Core
{
	private $router;


	public function run()
	{
		$routes = require __DIR__ . '/../routes.php'; // Asegúrate de que la ruta sea la correcta.



		$dispatcher = simpleDispatcher(function (RouteCollector $r) use ($routes) {
			foreach ($routes as $route) {
				if ($route[0] === 'GROUP') {
					$r->addGroup($route[1], function (RouteCollector $r) use ($route) {
						foreach ($route[2] as $subroute) {
							$r->addRoute($subroute[0], $subroute[1], $subroute[2]);
						}
					});
				} else {
					$r->addRoute($route[0], $route[1], $route[2]);
				}
			}
		});


		$httpMethod 	= $_SERVER['REQUEST_METHOD'];
		$uri 			= $_SERVER['REQUEST_URI'];
		$scriptName 	= $_SERVER['SCRIPT_NAME'];
		$baseSegment 	= str_replace('/index.php', '', $scriptName);


		if (substr($uri, 0, strlen($baseSegment)) == $baseSegment) {
			$uri = substr($uri, strlen($baseSegment));
		}

		$uri 	= rawurldecode($uri);

		$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

		switch ($routeInfo[0]) {
			case Dispatcher::NOT_FOUND:
				$controller = new NotFoundController();
				$controller->index();

				break;
			case Dispatcher::METHOD_NOT_ALLOWED:
				$allowedMethods = $routeInfo[1];
				echo 'Método no permitido. Debe ser uno de: ' . implode(', ', $allowedMethods);
				break;
			case Dispatcher::FOUND:
				$handler = $routeInfo[1];
				$vars = $routeInfo[2];
				$controllerClass = "\\controllers\\" . $handler[0];
				$method = $handler[1];
				if (class_exists($controllerClass)) {
					$controller = new $controllerClass();
					call_user_func_array(array($controller, $method), $vars);
				} else {
					echo "Controller class $controllerClass not found";
				}
				break;
		}
	}
}
