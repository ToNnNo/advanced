<?php


namespace App\Controller;


use App\Core\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class RestController extends AbstractController
{
    public function course()
    {
        return $this->render('rest/course.phtml');
    }


    public function index()
    {

        return new Response();
    }

}