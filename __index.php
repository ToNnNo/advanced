<?php
// php -S localhost:8000
// composer install -> install les dépendances
// composer update -> met à jour les dépendances

require __DIR__ . "/vendor/autoload.php";

use \App\Utils\Useless;
use \App\Utils\Singleton;
use \App\Utils\Builder\TableBuilder;
use \App\Utils\Builder\QueryBuilder;

$useless = new Useless();

echo Useless::class; // namespace complet
echo "<br />";
echo $useless;
$u = clone $useless;
echo $u;

// Design Pattern
// Singleton

echo "<hr />";
echo "<h3>Singleton</h3>";

$singleton = Singleton::getInstance();
$singleton2 = Singleton::getInstance();
$singleton2->setName("Jean");

echo '<p>Valeur de $singleton: '.$singleton
        ->setName("Stéphane")->getName()."</p>";

echo '<p>Valeur de $singleton2: '.$singleton2->getName()."</p>";

echo "<hr />";
echo "<h3>Array Collection: Iterator</h3>";

$collection = new \App\Utils\ArrayCollection();

$collection
    ->add("Aurelie")
    ->add("Claudie")
    ->add("Johny")
    ->add("Jonathan K")
    ->add("Jonathan L")
    ->add("Julia")
    ->add("Lin")
    ->add("Stéphane")
    ->add("Maxime")
    ->add("Michael")
    ->add("Nicolas")
    ->add("Clément")
    ->add("Tadi");

$collection->remove( $collection->indexOf("Stéphane") );

echo "<p>Hello ".$collection->get(0)."</p>";

echo "<p>Il y a ".$collection->count()." présent(s)</p>";
echo "<ol>";
foreach($collection as $key => $value){
    echo "<li>(".$key.") Hello ".$value."</li>";
}
echo "</ol>";

echo "<hr />";
echo "<h3>Builder</h3>";

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

echo $html;

echo "<hr />";
echo "<h3>Query Builder</h3>";

// Créer une classe qui va construire une requete select
// champs, table, where, order
// on peut executer la requete
//  -> 1 seul resultat
//  -> +ieurs resultats

// select * from <table>

$id = 4;

$qb = new QueryBuilder('user');
$users = $qb->where("id = :id")
    ->setParameter(':id', $id)
    ->getQuery(true)
    ->getOneResult();

if($users) {
    $users = [$users];

    $tableBuilder = new TableBuilder();

    echo $tableBuilder->addRows($users)
        ->addHeader(['ID', 'Prénom', 'Nom', 'Email', 'Téléphone'])
        ->build()
        ->getTable();
}else{
    echo "<p>Aucune Ressource pour l'id #".$id."</p>";
}
