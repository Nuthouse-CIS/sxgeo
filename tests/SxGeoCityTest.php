<?php

declare(strict_types=1);

namespace NuthouseCIS\SxGeo\Tests;

use NuthouseCIS\SxGeo\SxGeo;
use PHPUnit\Framework\TestCase;

class SxGeoCityTest extends TestCase
{
    private static $instance = null;

    public function testGetNum()
    {
        $sxgeo = self::getInstance();
        $num = $sxgeo->getNum('77.88.8.8');
        $this->assertSame(596568, $num);
    }

    public function testGetCountry()
    {
        $sxgeo = self::getInstance();
        $countryCode = $sxgeo->getCountry('77.88.8.8');
        $this->assertEquals('RU', $countryCode);
    }

    public function testGetCountryId()
    {
        $sxgeo = self::getInstance();
        $countryId = $sxgeo->getCountryId('77.88.8.8');
        $this->assertEquals(185, $countryId);
    }

    public function testGetCityFull()
    {
        $sxgeo = self::getInstance();
        $cityFull = $sxgeo->getCityFull('77.88.8.8');
        $expected = [
            'city'    => [
                'id'      => 524901,
                'lat'     => 55.75222,
                'lon'     => 37.61556,
                'name_ru' => 'Москва',
                'name_en' => 'Moscow',
            ],
            'region'  => [
                'id'      => 524894,
                'name_ru' => 'Москва',
                'name_en' => 'Moskva',
                'iso'     => 'RU-MOW',
            ],
            'country' => [
                'id'      => 185,
                'iso'     => 'RU',
                'lat'     => 60,
                'lon'     => 100,
                'name_ru' => 'Россия',
                'name_en' => 'Russia',
            ],
        ];
        $this->assertSame($expected, $cityFull);
    }

    public function testGet()
    {
        $sxgeo = self::getInstance();
        $data = $sxgeo->get('77.88.8.8');
        $expected = [
            'city'    => [
                'id'      => 524901,
                'lat'     => 55.75222,
                'lon'     => 37.61556,
                'name_ru' => 'Москва',
                'name_en' => 'Moscow',
            ],
            'country' => [
                'id'      => 185,
                'iso'     => 'RU'
            ],
        ];
        $this->assertSame($expected, $data);
    }

    public function testGetCity()
    {
        $sxgeo = self::getInstance();
        $city = $sxgeo->getCity('77.88.8.8');
        $expected = [
            'city'    => [
                'id'      => 524901,
                'lat'     => 55.75222,
                'lon'     => 37.61556,
                'name_ru' => 'Москва',
                'name_en' => 'Moscow',
            ],
            'country' => [
                'id'      => 185,
                'iso'     => 'RU'
            ],
        ];
        $this->assertSame($expected, $city);
    }

    public function testAbout()
    {
        $sxgeo = self::getInstance();
        $about = $sxgeo->about();
        $expected = [
            'Created' => '2021.01.19',
            'Timestamp' => 1611087494,
            'Charset' => 'utf-8',
            'Type' => 'SxGeo City EN',
            'Byte Index' => 224,
            'Main Index' => 1775,
            'Blocks In Index Item' => 3376,
            'IP Blocks' => 5994806,
            'Block Size' => 6,
            'City' => [
                'Max Length' => 127,
                'Total Size' => 2677927,
            ],
            'Region' => [
                'Max Length' => 175,
                'Total Size' => 109099,
            ],
            'Country' => [
                'Max Length' => 147,
                'Total Size' => 9387,
            ]
        ];
        $this->assertEquals($expected, $about);
    }

    protected static function getInstance(): SxGeo
    {
        if (self::$instance === null) {
            self::$instance = new SxGeo(__DIR__.'/data/SxGeoCity.dat', SxGeo::SXGEO_BATCH | SxGeo::SXGEO_MEMORY);
        }

        return self::$instance;
    }
}
