<?php
/**
 * Class SearchTest
 *
 * @package      maxh\Nominatim\Test
 * @author       Maxime Hélias <maximehelias16@gmail.com>
 */

namespace maxh\Nominatim\Test;

class SearchTest extends \PHPUnit_Framework_TestCase
{

    protected $url = 'http://nominatim.openstreetmap.org/';

    /**
     * Contain url of the current application
     * @var \maxh\Nominatim\Nominatim
     */
    private $nominatim;

    /**
     * @throws \maxh\Nominatim\Exceptions\NominatimException
     */
    protected function setUp()
    {
        $this->nominatim = new \maxh\Nominatim\Nominatim($this->url);
    }

    /**
     * Search HelloWorld
     */
    public function testQuery()
    {
        /** @var \maxh\Nominatim\Search $search */
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
