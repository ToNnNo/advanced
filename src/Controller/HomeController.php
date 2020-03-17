<?php


namespace App\Controller;

use App\Core\AbstractController;

class HomeController extends AbstractController
{

    public function index()
    {

        // appeler un fichier de vue
        return $this->render("home/index.phtml", [
            'message' => "<b>Hello World</b>" // <script>alert('Attaque !!')</script>
        ]);
    }

}