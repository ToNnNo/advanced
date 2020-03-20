<?php


namespace App\Controller;


use App\Core\AbstractController;

class SoapClientController extends AbstractController
{
    public function index()
    {
        $uri = $this->generateUrl('soap_server_product');
        $wsdl = $this->generateUrl('soap_server_index');

        try {
            $client = new \SoapClient($wsdl, [
                'location' => $uri,
                'uri' => $uri,
                'trace' => true
            ]);

            $products = $client->__soapCall("getAll", []);
        }catch (\SoapFault $exception) {
            echo "<pre>";
            var_dump($client);
            echo "</pre><hr />";
            die($exception);
        }


        return $this->render('soap/index.phtml', [
            'products' => $products
        ]);
    }
}