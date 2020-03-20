<?php

namespace tests;

use App\Utils\Calculatrice;
use PHPUnit\Framework\TestCase;

class CalculatriceTest extends TestCase
{
    // vendor/bin/phpunit --> MacOS/Unix
    // call vendor/bin/phpunit[.bat] --> Windows

    /**
     * @dataProvider providerAddition
     */
    public function testAddition($a, $b, $r)
    {
        $calculatrice = new Calculatrice();

        /*$result = $calculatrice->addition(1, 2, 3, 4, 5);
        $this->assertEquals(15, $result);

        $result = $calculatrice->addition(10, 10);
        $this->assertEquals(20, $result);*/

        $result = $calculatrice->addition($a, $b);
        $this->assertEquals($r, $result);
    }

    public function testSoustraction()
    {
        $this->markTestIncomplete('A faire ...');
    }

    public function testDivision()
    {
        $this->markAsRisky();
    }

    public function providerAddition()
    {
        return [
            [0, 0, 0],
            [10, 10, 20],
            [1, -1, 0],
            [1.1, 2, 3.1],
            [-6, -8, -14]
        ];
    }

}