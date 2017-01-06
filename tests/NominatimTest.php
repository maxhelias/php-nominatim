<?php

use maxh\Nominatim\Nominatim;
use maxh\Nominatim\Search;
use maxh\Nominatim\Reverse;
use maxh\Nominatim\Lookup;


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

		//Instance Lookup
		$lookup = new Lookup();
		$this->assertInstanceOf(Lookup::class, $lookup);

		$baseLookup = $instance->newLookup();
		$this->assertEquals($lookup, $baseLookup);

		//Testing Client
		$this->assertInstanceOf("GuzzleHttp\\Client", $instance->getClient());

	}

}
