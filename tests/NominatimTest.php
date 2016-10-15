<?php

use maxh\Nominatim\Nominatim;
use maxh\Nominatim\Search;
use maxh\Nominatim\Reverse;

use Mockery as m;


class NominatimTest extends PHPUnit_Framework_TestCase
{

	protected $url = "http://nominatim.openstreetmap.org/";

	public function testNominatimFactory()
	{

		//Instance Nominatim
		$instance = new Nominatim($this->url);
		$this->assertInstanceOf(Nominatim::class, $instance);

		//Instance Search
		$search = new Search();
		$this->assertInstanceOf(Search::class, $search);

		$baseSearch = $instance->newSearch();
		$this->assertEquals($search, $baseSearch);

		//Instance Reverse
		$reverse = new Reverse();
		$this->assertInstanceOf(Reverse::class, $reverse);

		$baseReverse = $instance->newReverse();
		$this->assertEquals($reverse, $baseReverse);

		//Testing Client
		$guzzle = m::mock("GuzzleHttp\\Client");
		$this->assertSame($guzzle, $instance->getClient());

	}

	public function testInvalidMethod(){
		$n = new Nominatim($this->url);
		$n->foo();
	}

}