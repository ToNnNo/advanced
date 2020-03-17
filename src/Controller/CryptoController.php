<?php


namespace App\Controller;

use App\Core\AbstractController;

class CryptoController extends AbstractController
{

    public function index()
    {
        $message = null;
        $chaine = "Hello World";

        // blowfish
        $hash = password_hash($chaine, PASSWORD_ARGON2I);

        if(isset($_POST['valider'])) {
            echo $postChaine = $_POST['chaine'] ?? null;

            if( password_verify($postChaine, $hash) ) {
                $message = "Donnée correct";
            } else {
                $message = "Donnée incorrect";
            }
        }

        return $this->render('crypto/index.phtml', [
            'md5' => md5($chaine),
            'sha1' => sha1($chaine),
            'sha256' => hash('sha256', $chaine),
            'hash' =>  $hash,
            'message' => $message
        ]);
    }

}