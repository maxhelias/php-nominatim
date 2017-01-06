<?php

use maxh\Nominatim\Nominatim;


class ReverseTest extends PHPUnit_Framework_TestCase
{

	protected $url = "http://nominatim.openstreetmap.org/";

	private $nominatim = null;
	
	protected function setUp()
	{
		$this->nominatim = new Nominatim($this->url);
	}

	public function testAdress()
	{
		$reverse = $this->nominatim->newReverse()
			->latlon(43.4843941, -1.4960842);

		$expected = [
			'format' => 'json',
			'lat' => 43.4843941,
			'lon' => -1.4960842,
		];


		$query = $reverse->getQuery();
		$this->assertSame($expected, $query);

		$expected = http_build_query($query);
		$this->assertSame($expected, $reverse->getQueryString());
	}

}
