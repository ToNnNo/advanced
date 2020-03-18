<?php


namespace App\Validator;


use App\Model\Product;

class ProductValidator
{

    public static function validate(Product $product)
    {
        $errors = [];

        if($product->getName() == null){
            $errors[] = "Le nom est obligatoire";
        }

        if($product->getPrice() == null){
            $errors[] = "Le prix est obligatoire";
        }

        if($product->getDate() == null){
            $errors[] = "La date est obligatoire";
        }

        return $errors;
    }

}