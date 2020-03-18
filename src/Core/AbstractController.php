<?php


namespace App\Core;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractController
{
    /** @var ParameterBag $container */
    protected $container;

    protected $doctrine;

    /**
     * @param mixed $container
     */
    public function setContainer($container)
    {
        $this->container = $container;
    }

    public function getDoctrine()
    {
        if( null == $this->doctrine){
            $this->doctrine = new Doctrine();
        }

        return $this->doctrine;
    }

    protected function generateUrl($routeName, array $params = [])
    {
        $routes = $this->container->get('routes');
        /** @var Request $request */
        $request = $this->container->get('requestStack')->getCurrentRequest();

        $key = array_search($routeName, array_column($routes, 'name'));

        if (false !== $key) {

            $route = $routes[$key]['route'];

            if (!empty($params)) {
                foreach ($params as $key => $value) {
                    $route = str_replace("{" . $key . "}", $value, $route);
                }
            }

            return $request->getSchemeAndHttpHost().$request->getBasePath().$route;
        }

        return null;
    }

    protected function redirectToRoute($routeName, array $params = [])
    {
        $route = $this->generateUrl($routeName, $params);

        return new RedirectResponse($route);
    }

    protected function render($template, array $parameters = [], $extends = "base.phtml")
    {
        extract(array_map(function($param){
            if(is_string($param)){
                return htmlentities($param);
            }

            return $param;
        }, $parameters));

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