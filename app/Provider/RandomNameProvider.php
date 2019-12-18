<?php

namespace App\Provider;

class RandomNameProvider
{
    static $server_animals = [
        'walrus',
        'whale',
        'seahorse',
        'seal',
        'starfish',
        'otter',
        'turtle',
        'manatee',
        'squid',
        'jellyfish',
    ];

    static $server_personas = [
        'ludicrous',
        'sassy',
        'delightful',
        'exotic',
        'gracious',
        'fine',
        'lovesome',
        'scrumptious',
        'jolly',
        'cheerful',
        'charming',
        'righteous',
    ];

    static function getName()
    {
        return self::$server_personas[array_rand(self::$server_personas)] . '-' . self::$server_animals[array_rand(self::$server_animals)];
    }
}