<?php


namespace App\Controller;


use App\Core\AbstractController;
use App\Utils\ArrayCollection;
use App\Utils\Builder\QueryBuilder;
use App\Utils\Builder\TableBuilder;
use App\Utils\Singleton;

class DesignPattern extends AbstractController
{

    public function index()
    {
        return $this->render('design-pattern/index.phtml');
    }

    public function singleton()
    {
        $singleton = Singleton::getInstance();
        $singleton2 = Singleton::getInstance();
        $singleton2->setName("Jean");
        $singleton->setName("Stéphane");

        return $this->render('design-pattern/singleton.phtml', [
            'singleton' => $singleton->getName(),
            'singleton2' => $singleton2->getName()
        ]);
    }

    public function collection()
    {
        $collection = new ArrayCollection();
        $collection
            ->add("Aurelie")->add("Claudie")->add("Johny")
            ->add("Jonathan K")->add("Jonathan L")->add("Julia")
            ->add("Lin")->add("Stéphane")->add(null)->add("Maxime")
            ->add("Michael")->add("Nicolas")->add("Clément")
            ->add("Tadi");

        $collection->remove( $collection->indexOf("Stéphane") );

        return $this->render('design-pattern/collection.phtml', [
            'collection' => $collection
        ]);
    }

    public function table()
    {
        $tableBuilder = new TableBuilder();

        $html = $tableBuilder->addRows([
            [1, 'Jean', 'Durand', 'jean.durand@gmail.com', '06 118 218 00'],
            [2, 'John', 'Doe', 'john.doe@gmail.com', '06 118 218 01'],
            [3, 'Jane', 'Doe', 'jane.doe@gmail.com', '06 118 218 03'],
            [4, 'Eduard', 'Doe', 'eduard.doe@gmail.com', '07 118 218 10'],
        ])
            ->addHeader(['ID', 'Prénom', 'Nom', 'Email', 'Téléphone'])
            ->build()
            ->getTable();

        return $this->render('design-pattern/table.phtml', [
            'html' => $html
        ]);
    }

    public function query()
    {
        $id = 1;

        $qb = new QueryBuilder('user');
        $users = $qb->where("id = :id")
            ->setParameter(':id', $id)
            ->getQuery(true)
            ->getOneResult();

        if($users) {
            $users = [$users];

            $tableBuilder = new TableBuilder();

            $html = $tableBuilder->addRows($users)
                ->addHeader(['ID', 'Prénom', 'Nom', 'Email', 'Téléphone'])
                ->build()
                ->getTable();
        }else{
            $html = "<p>Aucune Ressource pour l'id #".$id."</p>";
        }

        return $this->render('design-pattern/query.phtml', [
            'html' => $html
        ]);
    }

}