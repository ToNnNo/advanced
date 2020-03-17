<?php


namespace App\Core;


abstract class AbstractController
{
    private function getRoutes()
    {
        return require __DIR__ . "/../../routes.php";
    }

    /**
     * @throws \Exception
     */
    protected function generateUrl($routeName, array $params = [])
    {
        $routes = $this->getRoutes();

        $key = array_search($routeName, array_column($routes, 'name'));

        if (false !== $key) {

            $route = $routes[$key]['route'];

            if (!empty($params)) {
                foreach ($params as $key => $value) {
                    $route = str_replace("{" . $key . "}", $value, $route);
                }
            }

            $path = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'] . $route;

            $path = rtrim($path, "/");
            $path = rtrim($path, 'index.php');

            return $path;
        }

        throw new \Exception("No route found");
    }

    /**
     * @throws \Exception
     */
    protected function redirectToRoute($routeName)
    {
        $route = $this->generateUrl($routeName);

        header("Location:" . $route, true, 302);
    }

    protected function render($template, array $parameters = [], $extends = "base.phtml")
    {
        extract(array_map('htmlentities', $parameters));

        ob_start();
        require __DIR__ . "/../../template/" . $template;
        $page = ob_get_clean();

        preg_match_all('#\[block:([a-z]*)\](.*)\[endblock\]#Us', $page, $extract);

        foreach ($extract[1] as $key => $value) {
            ${'block'.$value} = $extract[2][$key];
        }

        ob_start();
        require __DIR__ . "/../../template/" . $extends;
        $html = ob_get_clean();

        return new Response($html);
    }

}