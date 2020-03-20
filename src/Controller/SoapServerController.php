<?php


namespace App\Controller;


use App\Core\AbstractController;
use App\Soap\SoapProduct;
use Laminas\Soap\AutoDiscover;
use Symfony\Component\HttpFoundation\Response;

class SoapServerController extends AbstractController
{

    public function index()
    {
        $autodiscover = new AutoDiscover();
        $autodiscover
            ->setClass(SoapProduct::class)
            ->setUri($this->generateUrl('soap_server_product'))
        ;

        $wsdl = $autodiscover->generate();

        $path = dirname(__DIR__, 2)."/public/wsdl/product.wsdl";
        $wsdl->dump($path);

        $response = new Response($wsdl->toXML());
        $response->headers->set('Content-type', 'text/xml');

        return $response;
    }

    public function product()
    {
        // index.php/soap/product
        $uri = $this->generateUrl('soap_server_product');
        $wsdl = $this->generateUrl('soap_server_index');

        $path = dirname(__DIR__, 2)."/public/wsdl/product.wsdl";

        try {
            $server = new \SoapServer($wsdl, ['uri' => $uri, 'trace'=>true]);
            $server->setClass(SoapProduct::class);
            $server->handle();
        }catch(\SoapFault $exception){
            die($exception);
        }

        return new Response();
    }

}