<?php

$doctrine = new \App\Core\Doctrine();

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($doctrine->getEntityManager());