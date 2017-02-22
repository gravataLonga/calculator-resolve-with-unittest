<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Calculator\Calculator;

class CalculadoraTest extends TestCase
{

    /**
     * @dataProvider dataProvider
     */
    public function testCalculator($expression, $result)
    {
    	$calculate = new Calculator;
    	$calculate->set($expression);
    	$myresult = $calculate->calculate();
    	$this->assertEquals($result, $myresult);
    }

    public function dataProvider()
    {
    	return [
    		['1 + 2 * 3', 9],
    		['1 - 1 * 1 + 3', 3], 
    		['2 / 2 * 3 + 1 - 1', 3],
    		['5 + 3 * 5', 40],
    		['5 + 1 MOD 2', 0],
    		['5 + 1 MOD 5 / 0', null]
    	];
    }
}
