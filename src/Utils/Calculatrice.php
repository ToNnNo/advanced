<?php


namespace App\Utils;


class Calculatrice
{

    public function addition(...$values)
    {
        $result = 0;
        foreach ($values as $value) {
            $result += $value;
        }

        return $result;
    }

}