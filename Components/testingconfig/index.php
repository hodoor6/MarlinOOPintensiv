<?php

require $_SERVER['DOCUMENT_ROOT'] . '/Components/Config.php';

$GLOBALS['config'] = [
    'test' => [
        'something' => [
            'no' => [
                'foo' => [
                    'bar'=>'baz'
                ]
            ]
        ]
    ],
    'config_my' => []
];

echo $test = Config::get('test.something.no.foo.bar');




