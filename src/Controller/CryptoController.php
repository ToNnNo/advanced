<?php


namespace App\Controller;

use App\Core\AbstractController;
use App\Utils\GenerateKeyOpenSSL;

class CryptoController extends AbstractController
{

    private $filename = __DIR__ . "/../../public/openssl/file.txt";
    private $rootdir;

    public function __construct()
    {
        $this->rootdir = dirname(__DIR__, 2);
    }

    public function index()
    {
        $message = null;
        $chaine = "Hello World";

        // blowfish
        $hash = password_hash($chaine, PASSWORD_ARGON2I);

        if (isset($_POST['valider'])) {
            echo $postChaine = $_POST['chaine'] ?? null;

            if (password_verify($postChaine, $hash)) {
                $message = "Donnée correct";
            } else {
                $message = "Donnée incorrect";
            }
        }

        return $this->render('crypto/index.phtml', [
            'md5' => md5($chaine),
            'sha1' => sha1($chaine),
            'sha256' => hash('sha256', $chaine),
            'hash' => $hash,
            'message' => $message
        ]);
    }

    public function generate()
    {
        if (isset($_POST['create'])) {
            $opensslService = new GenerateKeyOpenSSL();
            $opensslService->generate($_POST['passphrase']);
        }

        return $this->render('crypto/generate.phtml');
    }

    public function decrypt()
    {
        $encrypted = file_get_contents($this->filename);
        $decrypted = null;

        if (isset($_POST['decrypt'])) {
            $private = file_get_contents($this->rootdir . "/private.key");

            if (!$privateKey = openssl_pkey_get_private($private, $_POST['passphrase']))
                die('Error: unable to extract private key');

            if (!openssl_private_decrypt($encrypted, $decrypted, $privateKey))
                die('Error: unable to decrypt the message');
        }

        return $this->render('crypto/decrypt.phtml', [
            'encrypted' => base64_encode($encrypted),
            'decrypted' => $decrypted
        ]);
    }

    public function crypt()
    {
        $encrypted = "";
        $message = "Quand je retire mes lunettes, je suis Superman !!";

        if (isset($_POST['crypt'])) {
            $public = file_get_contents($this->rootdir . '/public.key');

            if (!$publicKey = openssl_pkey_get_public($public))
                die('Error: unable to extract public key');

            if (!openssl_public_encrypt($_POST['message'], $encrypted, $publicKey))
                die('Error: unable to encrypt message');

            file_put_contents($this->filename, $encrypted);
        }

        return $this->render('crypto/crypt.phtml', [
            'message' => $message
        ]);
    }

}