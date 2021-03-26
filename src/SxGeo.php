<?php
/***************************************************************************\
 * | This package is a refactoring of the ready source code                 |
 * | for use via composer from sypexgeo.net                                 |
 * | (c)2021      Seagull-4auKa dfreemanbk@gmail.com                        |
 * | (c)2006-2014 zapimir       zapimir@zapimir.net       http://sypex.net/ |
 * | (c)2006-2014 BINOVATOR     info@sypex.net                              |
 * |------------------------------------------------------------------------|
 * |     created: 2006.10.17 18:33                                          |
 * |------------------------------------------------------------------------|
 * | Sypex Geo is released under the terms of the BSD license               |
 * |   http://sypex.net/bsd_license.txt                                     |
 * \************************************************************************/

declare(strict_types=1);

namespace NuthouseCIS\SxGeo;

class SxGeo
{
    public const SXGEO_FILE = 0;
    public const SXGEO_MEMORY = 1;
    public const SXGEO_BATCH = 2;

    /**
     * @var false|resource
     */
    protected $fh;
    /**
     * @var array|false
     */
    protected $info;
    /**
     * @var int
     */
    protected $range;
    /**
     * @var false|int
     */
    protected $dbBegin;
    /**
     * @var false|string
     */
    protected $bIndexStr;
    /**
     * @var false|string
     */
    protected $mIndexStr;
    /**
     * @var array|false
     */
    protected $bIndexArr;
    /**
     * @var array
     */
    protected $mIndexArr;
    /**
     * @var int
     */
    protected $mainIndexLength;
    /**
     * @var int
     */
    protected $dbItems;
    /**
     * @var int
     */
    protected $countrySize;
    /**
     * @var false|string
     */
    protected $db;
    /**
     * @var false|string
     */
    protected $regionsDb;
    /**
     * @var false|string
     */
    protected $citiesDb;

    /**
     * @var string[]
     */
	public $id2iso = [
		'', 'AP', 'EU', 'AD', 'AE', 'AF', 'AG', 'AI', 'AL', 'AM', 'CW', 'AO',
        'AQ', 'AR', 'AS', 'AT', 'AU', 'AW', 'AZ', 'BA', 'BB', 'BD', 'BE', 'BF',
        'BG', 'BH', 'BI', 'BJ', 'BM', 'BN', 'BO', 'BR', 'BS', 'BT', 'BV', 'BW',
        'BY', 'BZ', 'CA', 'CC', 'CD', 'CF', 'CG', 'CH', 'CI', 'CK', 'CL', 'CM',
        'CN', 'CO', 'CR', 'CU', 'CV', 'CX', 'CY', 'CZ', 'DE', 'DJ', 'DK', 'DM',
        'DO', 'DZ', 'EC', 'EE', 'EG', 'EH', 'ER', 'ES', 'ET', 'FI', 'FJ', 'FK',
        'FM', 'FO', 'FR', 'SX', 'GA', 'GB', 'GD', 'GE', 'GF', 'GH', 'GI', 'GL',
        'GM', 'GN', 'GP', 'GQ', 'GR', 'GS', 'GT', 'GU', 'GW', 'GY', 'HK', 'HM',
        'HN', 'HR', 'HT', 'HU', 'ID', 'IE', 'IL', 'IN', 'IO', 'IQ', 'IR', 'IS',
        'IT', 'JM', 'JO', 'JP', 'KE', 'KG', 'KH', 'KI', 'KM', 'KN', 'KP', 'KR',
        'KW', 'KY', 'KZ', 'LA', 'LB', 'LC', 'LI', 'LK', 'LR', 'LS', 'LT', 'LU',
        'LV', 'LY', 'MA', 'MC', 'MD', 'MG', 'MH', 'MK', 'ML', 'MM', 'MN', 'MO',
        'MP', 'MQ', 'MR', 'MS', 'MT', 'MU', 'MV', 'MW', 'MX', 'MY', 'MZ', 'NA',
        'NC', 'NE', 'NF', 'NG', 'NI', 'NL', 'NO', 'NP', 'NR', 'NU', 'NZ', 'OM',
        'PA', 'PE', 'PF', 'PG', 'PH', 'PK', 'PL', 'PM', 'PN', 'PR', 'PS', 'PT',
        'PW', 'PY', 'QA', 'RE', 'RO', 'RU', 'RW', 'SA', 'SB', 'SC', 'SD', 'SE',
        'SG', 'SH', 'SI', 'SJ', 'SK', 'SL', 'SM', 'SN', 'SO', 'SR', 'ST', 'SV',
        'SY', 'SZ', 'TC', 'TD', 'TF', 'TG', 'TH', 'TJ', 'TK', 'TM', 'TN', 'TO',
        'TL', 'TR', 'TT', 'TV', 'TW', 'TZ', 'UA', 'UG', 'UM', 'US', 'UY', 'UZ',
        'VA', 'VC', 'VE', 'VG', 'VI', 'VN', 'VU', 'WF', 'WS', 'YE', 'YT', 'RS',
        'ZA', 'ZM', 'ME', 'ZW', 'A1', 'XK', 'O1', 'AX', 'GG', 'IM', 'JE', 'BL',
        'MF', 'BQ', 'SS'
	];

    /**
     * @var bool
     */
    public $batchMode = false;
    /**
     * @var bool
     */
    public $memoryMode = false;
    /**
     * @var int
     */
    protected $byteIndexLength;
    /**
     * @var int
     */
    protected $idLength;
    /**
     * @var int|mixed
     */
    protected $blockLength;
    /**
     * @var mixed
     */
    protected $maxRegion;
    /**
     * @var mixed
     */
    protected $maxCity;
    /**
     * @var mixed
     */
    protected $maxCountry;
    /**
     * @var false|string|string[]
     */
    protected $pack;

    /**
     * SxGeo constructor.
     *
     * @param string $filePath
     * @param int    $type
     *
     * @throws DatabaseException
     */
    public function __construct(
        string $filePath,
        int $type = self::SXGEO_FILE
    ) {
        if (!file_exists($filePath)) {
            throw new DatabaseException('Database file not exists');
        }
        $this->fh = fopen($filePath, 'rb');
        // Сначала убеждаемся, что есть файл базы данных
        $header = fread(
            $this->fh,
            40
        ); // В версии 2.2 заголовок увеличился на 8 байт
        if (strlen($header) != 40 || substr($header, 0, 3) != 'SxG') {
            throw new DatabaseException('Wrong database file format');
        }
        $info = unpack(
            'Cver/Ntime/Ctype/Ccharset/Cb_idx_len/nm_idx_len/nrange/Ndb_items/Cid_len/nmax_region/nmax_city/Nregion_size/Ncity_size/nmax_country/Ncountry_size/npack_size',
            substr($header, 3)
        );
        if ($info['b_idx_len'] * $info['m_idx_len'] * $info['range']
            * $info['db_items'] * $info['time'] * $info['id_len'] == 0
        ) {
            throw new DatabaseException('Wrong database file format');
        }
        $this->range = (int)$info['range'];
        $this->byteIndexLength = (int)$info['b_idx_len'];
        $this->mainIndexLength = (int)$info['m_idx_len'];
        $this->dbItems = (int)$info['db_items'];
        $this->idLength = (int)$info['id_len'];
        $this->blockLength = 3 + $this->idLength;
        $this->maxRegion = (int)$info['max_region'];
        $this->maxCity = (int)$info['max_city'];
        $this->maxCountry = (int)$info['max_country'];
        $this->countrySize = (int)$info['country_size'];
        $this->batchMode = (bool)($type & self::SXGEO_BATCH);
        $this->memoryMode = (bool)($type & self::SXGEO_MEMORY);
        $this->pack = $info['pack_size'] ? explode(
            "\0",
            fread(
                $this->fh,
                $info['pack_size']
            )
        ) : '';
        $this->bIndexStr = fread($this->fh, $info['b_idx_len'] * 4);
        $this->mIndexStr = fread($this->fh, $info['m_idx_len'] * 4);

        $this->dbBegin = ftell($this->fh);
        if ($this->batchMode) {
            $this->bIndexArr = array_values(
                unpack("N*", $this->bIndexStr)
            ); // Быстрее в 5 раз, чем с циклом
            unset ($this->bIndexStr);
            $this->mIndexArr = str_split(
                $this->mIndexStr,
                4
            ); // Быстрее в 5 раз чем с циклом
            unset ($this->mIndexStr);
        }
        if ($this->memoryMode) {
            $this->db = fread($this->fh, $this->dbItems * $this->blockLength);
            $this->regionsDb = $info['region_size'] > 0 ? fread(
                $this->fh,
                $info['region_size']
            ) : '';
            $this->citiesDb = $info['city_size'] > 0 ? fread(
                $this->fh,
                $info['city_size']
            ) : '';
        }
        $this->info = $info;
        $this->info['regions_begin'] = $this->dbBegin + $this->dbItems
            * $this->blockLength;
        $this->info['cities_begin'] = $this->info['regions_begin']
            + $info['region_size'];
    }

    protected function searchId($ipn, int $min, int $max): int
    {
        if ($this->batchMode) {
            while ($max - $min > 8) {
                $offset = ($min + $max) >> 1;
                if ($ipn > $this->mIndexArr[$offset]) {
                    $min = $offset;
                } else {
                    $max = $offset;
                }
            }
            while ($ipn > $this->mIndexArr[$min] && $min < $max) {
                $min++;
            }
        } else {
            while ($max - $min > 8) {
                $offset = ($min + $max) >> 1;
                if ($ipn > substr($this->mIndexStr, $offset * 4, 4)) {
                    $min = $offset;
                } else {
                    $max = $offset;
                }
            }
            while ($ipn > substr($this->mIndexStr, $min * 4, 4)
                && $min < $max) {
                $min++;
            }
        }

        return $min;
    }

    protected function searchDb($str, $ipn, $min, $max): int
    {
        if ($max - $min > 1) {
            $ipn = substr($ipn, 1);
            while ($max - $min > 8) {
                $offset = ($min + $max) >> 1;
                if ($ipn > substr($str, $offset * $this->blockLength, 3)) {
                    $min = $offset;
                } else {
                    $max = $offset;
                }
            }
            while ($ipn >= substr($str, $min * $this->blockLength, 3)
                && ++$min < $max) {
            }
        } else {
            $min++;
        }

        return (int)hexdec(
            bin2hex(
                substr(
                    $str,
                    $min * $this->blockLength - $this->idLength,
                    $this->idLength
                )
            )
        );
    }

    /**
     * @param $ip
     *
     * @return int|false
     */
    public function getNum($ip)
    {
        $ip1n = (int)$ip; // Первый байт
        if ($ip1n == 0 || $ip1n == 10 || $ip1n == 127
            || $ip1n >= $this->byteIndexLength
            || false === ($ipn = ip2long($ip))
        ) {
            return false;
        }
        $ipn = pack('N', $ipn);
        // Находим блок данных в индексе первых байт
        if ($this->batchMode) {
            $blocks = [
                'min' => $this->bIndexArr[$ip1n - 1],
                'max' => $this->bIndexArr[$ip1n],
            ];
        } else {
            $blocks = unpack(
                "Nmin/Nmax",
                substr($this->bIndexStr, ($ip1n - 1) * 4, 8)
            );
        }
        if ($blocks['max'] - $blocks['min'] > $this->range) {
            // Ищем блок в основном индексе
            $part = $this->searchId(
                $ipn,
                (int)floor($blocks['min'] / $this->range),
                (int)floor($blocks['max'] / $this->range) - 1
            );
            // Нашли номер блока в котором нужно искать IP, теперь находим нужный блок в БД
            $min = $part > 0 ? $part * $this->range : 0;
            $max = $part > $this->mainIndexLength ? $this->dbItems
                : ($part + 1) * $this->range;
            // Нужно проверить чтобы блок не выходил за пределы блока первого байта
            if ($min < $blocks['min']) {
                $min = $blocks['min'];
            }
            if ($max > $blocks['max']) {
                $max = $blocks['max'];
            }
        } else {
            $min = $blocks['min'];
            $max = $blocks['max'];
        }
        $len = $max - $min;
        // Находим нужный диапазон в БД
        if ($this->memoryMode) {
            return $this->searchDb($this->db, $ipn, $min, $max);
        } else {
            fseek($this->fh, $this->dbBegin + $min * $this->blockLength);

            return $this->searchDb(
                fread($this->fh, $len * $this->blockLength),
                $ipn,
                0,
                $len
            );
        }
    }

    protected function readData($seek, $max, $type): array
    {
        $raw = '';
        if ($seek && $max) {
            if ($this->memoryMode) {
                $raw = substr(
                    $type == 1 ? $this->regionsDb : $this->citiesDb,
                    $seek,
                    $max
                );
            } else {
                fseek(
                    $this->fh,
                    $this->info[$type == 1 ? 'regions_begin' : 'cities_begin']
                    + $seek
                );
                $raw = fread($this->fh, $max);
            }
        }

        return $this->unpack($this->pack[$type], $raw);
    }

    protected function parseCity($seek, $full = false)
    {
        if (!$this->pack) {
            return false;
        }
        $only_country = false;
        if ($seek < $this->countrySize) {
            $country = $this->readData($seek, $this->maxCountry, 0);
            $city = $this->unpack($this->pack[2]);
            $city['lat'] = $country['lat'];
            $city['lon'] = $country['lon'];
            $only_country = true;
        } else {
            $city = $this->readData($seek, $this->maxCity, 2);
            $country = [
                'id'  => $city['country_id'],
                'iso' => $this->id2iso[$city['country_id']],
            ];
            unset($city['country_id']);
        }
        if ($full) {
            $region = $this->readData(
                $city['region_seek'],
                $this->maxRegion,
                1
            );
            if (!$only_country) {
                $country = $this->readData(
                    $region['country_seek'],
                    $this->maxCountry,
                    0
                );
            }
            unset($city['region_seek']);
            unset($region['country_seek']);

            return [
                'city'    => $city,
                'region'  => $region,
                'country' => $country,
            ];
        } else {
            unset($city['region_seek']);

            return [
                'city'    => $city,
                'country' => [
                    'id'  => $country['id'],
                    'iso' => $country['iso'],
                ],
            ];
        }
    }

    protected function unpack($pack, $item = ''): array
    {
        $unpacked = [];
        $empty = empty($item);
        $pack = explode('/', $pack);
        $pos = 0;
        foreach ($pack as $p) {
            list($type, $name) = explode(':', $p);
            $type0 = $type[0];
            if ($empty) {
                $unpacked[$name] = $type0 == 'b' || $type0 == 'c' ? '' : 0;
                continue;
            }
            switch ($type0) {
                case 't':
                case 'T':
                    $l = 1;
                    break;
                case 's':
                case 'n':
                case 'S':
                    $l = 2;
                    break;
                case 'm':
                case 'M':
                    $l = 3;
                    break;
                case 'd':
                    $l = 8;
                    break;
                case 'c':
                    $l = (int)substr($type, 1);
                    break;
                case 'b':
                    $l = strpos($item, "\0", $pos) - $pos;
                    break;
                default:
                    $l = 4;
            }
            $val = substr($item, $pos, $l);
            switch ($type0) {
                case 't':
                    $v = unpack('c', $val);
                    break;
                case 'T':
                    $v = unpack('C', $val);
                    break;
                case 's':
                    $v = unpack('s', $val);
                    break;
                case 'S':
                    $v = unpack('S', $val);
                    break;
                case 'm':
                    $v = unpack('l', $val.(ord($val[2]) >> 7 ? "\xff" : "\0"));
                    break;
                case 'M':
                    $v = unpack('L', $val."\0");
                    break;
                case 'i':
                    $v = unpack('l', $val);
                    break;
                case 'I':
                    $v = unpack('L', $val);
                    break;
                case 'f':
                    $v = unpack('f', $val);
                    break;
                case 'd':
                    $v = unpack('d', $val);
                    break;

                case 'n':
                    $v = current(unpack('s', $val)) / pow(10, $type[1]);
                    break;
                case 'N':
                    $v = current(unpack('l', $val)) / pow(10, $type[1]);
                    break;

                case 'c':
                    $v = rtrim($val, ' ');
                    break;
                case 'b':
                    $v = $val;
                    $l++;
                    break;
            }
            $pos += $l;
            $unpacked[$name] = is_array($v) ? current($v) : $v;
        }

        return $unpacked;
    }

    public function get($ip)
    {
        return $this->maxCity ? $this->getCity($ip) : $this->getCountry($ip);
    }

    public function getCountry($ip): string
    {
        if ($this->maxCity) {
            $tmp = $this->parseCity($this->getNum($ip));

            return $tmp['country']['iso'];
        } else {
            return $this->id2iso[$this->getNum($ip)];
        }
    }

    public function getCountryId($ip)
    {
        if ($this->maxCity) {
            $tmp = $this->parseCity($this->getNum($ip));

            return $tmp['country']['id'];
        } else {
            return $this->getNum($ip);
        }
    }

    public function getCity($ip)
    {
        $seek = $this->getNum($ip);

        return $seek ? $this->parseCity($seek) : false;
    }

    public function getCityFull($ip)
    {
        $seek = $this->getNum($ip);

        return $seek ? $this->parseCity($seek, 1) : false;
    }

    public function about(): array
    {
        $charset = ['utf-8', 'latin1', 'cp1251'];
        $types = [
            'n/a',
            'SxGeo Country',
            'SxGeo City RU',
            'SxGeo City EN',
            'SxGeo City',
            'SxGeo City Max RU',
            'SxGeo City Max EN',
            'SxGeo City Max',
        ];

        return [
            'Created'              => date('Y.m.d', $this->info['time']),
            'Timestamp'            => $this->info['time'],
            'Charset'              => $charset[$this->info['charset']],
            'Type'                 => $types[$this->info['type']],
            'Byte Index'           => $this->byteIndexLength,
            'Main Index'           => $this->mainIndexLength,
            'Blocks In Index Item' => $this->range,
            'IP Blocks'            => $this->dbItems,
            'Block Size'           => $this->blockLength,
            'City'                 => [
                'Max Length' => $this->maxCity,
                'Total Size' => $this->info['city_size'],
            ],
            'Region'               => [
                'Max Length' => $this->maxRegion,
                'Total Size' => $this->info['region_size'],
            ],
            'Country'              => [
                'Max Length' => $this->maxCountry,
                'Total Size' => $this->info['country_size'],
            ],
        ];
    }
}