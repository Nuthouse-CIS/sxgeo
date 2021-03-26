<?php

declare(strict_types=1);

namespace NuthouseCIS\SxGeo\Tests;

use NuthouseCIS\SxGeo\DatabaseException;
use NuthouseCIS\SxGeo\SxGeo;
use PHPUnit\Framework\TestCase;

class SxGeoTest extends TestCase
{
    private static $instance = null;

    public function testGetNum(): void
    {
        $sxgeo = self::getInstance();
        $num = $sxgeo->getNum('77.88.8.8');
        $this->assertSame(185,$num);
    }

    public function testGetCountry(): void
    {
        $sxgeo = self::getInstance();
        $countryCode = $sxgeo->getCountry('77.88.8.8');
        $this->assertEquals('RU', $countryCode);
    }

    public function testGetCountryId(): void
    {
        $sxgeo = self::getInstance();
        $countryId = $sxgeo->getCountryId('77.88.8.8');
        $this->assertEquals(185, $countryId);
    }

    public function testGetCityFull(): void
    {
        $sxgeo = self::getInstance();
        $cityFull = $sxgeo->getCityFull('77.88.8.8');
        $this->assertFalse($cityFull);
    }

    public function testGet(): void
    {
        $sxgeo = self::getInstance();
        $data = $sxgeo->get('77.88.8.8');
        $this->assertSame('RU',$data);
    }

    public function testGetCity(): void
    {
        $sxgeo = self::getInstance();
        $city = $sxgeo->getCity('77.88.8.8');
        $this->assertFalse($city);
    }

    public function testAbout(): void
    {
        $sxgeo = self::getInstance();
        $about = $sxgeo->about();
        $expected = [
            'Created'              => '2021.01.19',
            'Timestamp'            => 1611087670,
            'Charset'              => 'latin1',
            'Type'                 => 'SxGeo Country',
            'Byte Index'           => 224,
            'Main Index'           => 278,
            'Blocks In Index Item' => 728,
            'IP Blocks'            => 203043,
            'Block Size'           => 4,
            'City'                 => [
                'Max Length' => 0,
                'Total Size' => 0,
            ],
            'Region'               => [
                'Max Length' => 0,
                'Total Size' => 0,
            ],
            'Country'              => [
                'Max Length' => 0,
                'Total Size' => 0,
            ],
        ];
        $this->assertEquals($expected, $about);
    }

    public function testNotExists(): void
    {
        $this->expectException(DatabaseException::class);
        $this->expectExceptionMessage('Database file not exists');
        new SxGeo(__DIR__ . '/data/not_exists.dat');
    }

    public function testWrongFormat(): void
    {
        $this->expectException(DatabaseException::class);
        $this->expectExceptionMessage('Wrong database file format');
        new SxGeo(__DIR__ . '/data/wrong.dat');
    }

    protected static function getInstance(): SxGeo
    {
        if (self::$instance === null) {
            self::$instance = new SxGeo(__DIR__.'/data/SxGeo.dat', SxGeo::SXGEO_BATCH | SxGeo::SXGEO_MEMORY);
        }

        return self::$instance;
    }
}
