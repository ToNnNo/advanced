<?php

namespace App\Controller;


use App\Core\AbstractController;
use App\Model\Product;
use App\Validator\ProductValidator;

class ORMController extends AbstractController
{
    public function course()
    {
        return $this->render('orm/course.phtml');
    }


    public function index()
    {
        $repository = $this->getDoctrine()->getEntityManager()->getRepository(Product::class);

        $products = $repository->findAll();

        return $this->render('orm/index.phtml', [
            'products' => $products
        ]);
    }

    public function add()
    {
        $error = [];
        $product = new Product();

        if (isset($_POST['envoyer'])) {
            $product->setName($_POST['name'] ?? null);
            $product->setPrice($_POST['price'] ?? null);
            $product->setDescription($_POST['description'] ?? null);
            $product->setDate(($_POST['date'] != null) ? new \DateTime($_POST['date']) : null);

            $error = ProductValidator::validate($product);

            if (count($error) === 0) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($product); // ajouter / modifier
                // $em->remove(); // suppression
                $em->flush();

                return $this->redirectToRoute('orm_index');
            }

        }

        return $this->render('orm/edit.phtml', [
            'action' => 'Ajouter',
            'errors' => $error,
            'product' => $product
        ]);
    }

    public function edit($id)
    {
        $error = [];
        /** @var Product $product */
        $product = $this->getDoctrine()->getEntityManager()->getRepository(Product::class)->find($id);

        if (!$product) {
            die('error');
        }

        if (isset($_POST['envoyer'])) {
            $product->setName($_POST['name'] ?? null);
            $product->setPrice($_POST['price'] ?? null);
            $product->setDescription($_POST['description'] ?? null);
            $product->setDate(($_POST['date'] != null) ? new \DateTime($_POST['date']) : null);

            $error = ProductValidator::validate($product);

            if (count($error) === 0) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->flush();

                return $this->redirectToRoute('orm_edit', ['id' => $id]);
            }

        }

        return $this->render('orm/edit.phtml', [
            'action' => 'Modifier',
            'errors' => $error,
            'product' => $product
        ]);
    }

    public function remove($id)
    {
        /** @var Product $product */
        $product = $this->getDoctrine()->getEntityManager()->getRepository(Product::class)->find($id);

        if (!$product) {
            die('error');
        }

        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($product);
        $em->flush();

        return $this->redirectToRoute('orm_index');
    }

}