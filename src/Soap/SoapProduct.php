<?php


namespace App\Soap;


use App\Core\Doctrine;
use App\Model\Product;

class SoapProduct
{
    /**
     * @return array|object[]
     */
    public function getAll()
    {
        $doctrine = new Doctrine();
        $repository = $doctrine->getEntityManager()->getRepository(Product::class);

        return $repository->findAll();
    }

}