<?php


namespace App\Core;

use Symfony\Component\HttpFoundation\ParameterBag;
use \Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class App
{
    /** @var ParameterBag $container */
    protected $container;

    /** @var Request $request */
    protected $request;

    protected $routes;

    private const ALL = "/([a-z0-9]+(?:-[a-z0-9]+)*)";
    private const KEY = "#/{[a-z]+}#";

    private function loadRoutes()
    {
        $this->routes = require __DIR__ . "/../../routes.php";
    }

    private function initContainerBag()
    {
        $this->container = new ParameterBag();
    }

    public function run(Request $request)
    {
        $this->request = $request;

        // load routes
        $this->loadRoutes();

        $requestStack = new RequestStack();
        $requestStack->push($request);

        // init container
        $this->initContainerBag();
        $this->container->set('requestStack', $requestStack);
        $this->container->set('routes', $this->routes);

        // dispatch controller
        $controller = $this->dispatch();

        // call
        try {
            $response = $this->call($controller);
        } catch (\Exception $e) {
            echo "<pre>";
            echo $e;
        }

        return $response;
    }

    protected function dispatch()
    {
        $controller = null;
        foreach ($this->routes as $key => $route) {
            $route = preg_replace(self::KEY, self::ALL, $route);

            if (preg_match("#^" . $route['route'] . "$#", $this->request->getPathInfo(), $parameters)) {

                array_shift($parameters);
                $class = $route['controller'];
                $action = $route['action'];

                $this->request->attributes->set('_controller', $class . "::" . $action);
                $this->request->attributes->set('_parameters', $parameters);
                break;
            } else {
                $class = "404";
                $action = "index";
            }
        }

        return $class . "::" . $action;
    }

    /**
     * @throws \Exception
     */
    public function call($controller)
    {
        list($class, $action) = explode("::", $controller);

        $instance = new $class();

        if ($instance instanceof AbstractController) {
            $instance->setContainer($this->container);
        }

        if (class_exists($class)) {
            if (method_exists($class, $action)) {

                $parameters = $this->request->attributes->get('_parameters');
                $parameters[] = $this->request;
                $this->request->attributes->set('_parameters', $parameters);

                $response = call_user_func_array( array($instance, $action), $parameters );
            } else {
                throw new \Exception("La method " . $action . " n'existe pas dans " . $class);
            }
        } else {
            throw new \Exception("La classe " . $class . " n'a pas été trouvé");
        }

        return $response;
    }

}