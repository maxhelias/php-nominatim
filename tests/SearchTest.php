<?php

namespace maxh\Nominatim\Test;

use maxh\Nominatim\Nominatim;

class SearchTest extends \PHPUnit_Framework_TestCase
{

    protected $url = 'http://nominatim.openstreetmap.org/';

    private $nominatim;

    protected function setUp()
    {
        $this->nominatim = new Nominatim($this->url);
    }

    /**
     * Search HelloWorld
     */
    public function testQuery()
    {
        $search = $this->nominatim->newSearch()
            ->query('HelloWorld');

        $expected = [
            'format' => 'json',
            'q' => 'HelloWorld',
        ];

        $query = $search->getQuery();
        $this->assertSame($expected, $query);

        $expected = http_build_query($query);
        $this->assertSame($expected, $search->getQueryString());
    }

    public function testAddress()
    {
        $search = $this->nominatim->newSearch()
            ->country('France')
            ->city('Bayonne')
            ->postalCode('64100')
            ->addressDetails();

        $expected = [
            'format' => 'json',
            'country' => 'France',
            'city' => 'Bayonne',
            'postalcode' => '64100',
            'addressdetails' => '1'
        ];


        $query = $search->getQuery();
        $this->assertSame($expected, $query);

        $expected = http_build_query($query);
        $this->assertSame($expected, $search->getQueryString());
    }
}
