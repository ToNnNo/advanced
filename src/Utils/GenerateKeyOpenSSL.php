<?php


namespace App\Utils;


use http\Exception\RuntimeException;

class GenerateKeyOpenSSL
{

    public function generate($passphrase = null)
    {
        /**
         * echo __DIR__; --> /Users/Dawan/Desktop/phpavance/src/Utils
         * echo dirname(__DIR__); --> /Users/Dawan/Desktop/phpavance/src
         * echo dirname(__DIR__, 2); --> /Users/Dawan/Desktop/phpavance
         */
        $rootdir = dirname(__DIR__, 2);

        $privateKey = openssl_pkey_new([
            'private_key_bits' => 2048,
            'private_key_type' => OPENSSL_KEYTYPE_RSA
        ]);
        // créer la clé privé
        $status = openssl_pkey_export_to_file($privateKey, $rootdir . '/private.key', $passphrase);

        if (!$status) {
            throw new RuntimeException(openssl_error_string());
        }

        // créer la clé public
        $arrayKey = openssl_pkey_get_details($privateKey);
        file_put_contents($rootdir . '/public.key', $arrayKey['key']);

        // efface la clé de la mémoire
        openssl_free_key($privateKey);
    }

}