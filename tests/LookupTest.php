<?php

use maxh\Nominatim\Nominatim;


class LookupTest extends PHPUnit_Framework_TestCase
{

	protected $url = "http://nominatim.openstreetmap.org/";

	private $nominatim = null;
	
	protected function setUp()
	{
		$this->nominatim = new Nominatim($this->url);
	}

	public function testOsmIds()
	{
		$lookup = $this->nominatim->newLookup()
			->format('xml')
			->osmIds('R146656,W104393803,N240109189');

		$expected = [
			'format' => 'xml',
			'osm_ids' => 'R146656,W104393803,N240109189',
		];

		$query = $lookup->getQuery();
		$this->assertSame($expected, $query);

		$expected = http_build_query($query);
		$this->assertSame($expected, $lookup->getQueryString());
	}

}
