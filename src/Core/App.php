<?php


namespace App\Core;


class App
{
    private const ALL = "/([a-z0-9]+(?:-[a-z0-9]+)*)";
    private const KEY = "#/{[a-z]+}#";

    private function loadRoutes()
    {
        return require __DIR__  . "/../../routes.php";
    }

    public function run(Request $request)
    {
        // route
        $routes = $this->loadRoutes();

        // load controller
        try{
            $response = $this->loadController($request, $routes);
        } catch (\Exception $e) {
            echo "<pre>";
            echo $e;
        }

        return $response;
    }

    /**
     * @throws \Exception
     */
    protected function loadController(Request $request, array $routes)
    {
        $path = str_replace("index.php", "", $request->getPathInfo());

        foreach($routes as $key => $route)
        {
            $route = preg_replace(self::KEY, self::ALL, $route);

            if( preg_match("#^".$route['route']."$#", $path,$parameters) ) {

                array_shift($parameters);
                $controller = $route['controller'];
                $action = $route['action'];
                break;
            } else {
                $controller = "404";
                $action = "index";
            }
        }

        if (class_exists($controller)) {
            if (method_exists($controller, $action)) {
                $response = call_user_func_array(array(new $controller(), $action), $parameters);
            }else{
                throw new \Exception("La method ".$action." n'existe pas dans ".$controller);
            }
        }else{
            throw new \Exception("La classe ".$controller." n'a pas été trouvé");
        }

        return $response;
    }

}