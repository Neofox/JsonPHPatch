<?php

use Neofox\JsonPatcher\JsonPatcher;
use PHPUnit\Framework\TestCase;

/**
 * Created by PhpStorm.
 * User: jerome
 * Date: 28/11/2017
 * Time: 16:01
 */
class JsonPatcherTest extends TestCase
{
    /**
     * @dataProvider diffProvider
     *
     * @param array  $original
     * @param array  $modified
     * @param string $res
     */
    public function testCanGenerateJsonPathFromADiff($original, $modified, $res)
    {
        $jsonPatcher = new JsonPatcher();

        $json = $jsonPatcher->diff($original, $modified);

        $this->assertJsonStringEqualsJsonString($json, $res);
    }

    public function diffProvider()
    {
        return [
            [
                [
                    'name' => 'toto',
                ],
                [
                    'name' => 'toto@toto.com',
                ],
                '{ "op": "replace", "from": "/name", "value": "toto@toto.com" }',
            ],
            [
                [
                    'name' => ['abc' => 'cde'],
                ],
                [
                    'name' => ['abc' => 'cde', 'fgh' => 'ijk'],
                ],
                '{ "op": "add", "from": "/name/-", "value": { "fgh": "ijk" } }',
            ],
            [
                [
                    'test' => ['abc' => ['cde']],
                ],
                [
                    'test' => ['abc' => ['fgh', 'cde']],
                ],
                '{ "op": "add", "from": "/test/abc/0", "value": "fgh" }',
            ],
            [
                [
                    'name' => 'toto',
                ],
                [
                    'name' => 'toto',
                    'email' => 'toto@toto.com',
                ],
                '{ "op": "add", "from": "/email", "value": "toto@toto.com" }',
            ],
            [
                [
                    'name' => 'toto',
                    'roles' => []
                ],
                [
                    'name' => 'toto',
                    'roles' => ['USER', 'ADMIN'],
                ],
                '{ "op": "replace", "from": "/roles", "value": [ "USER", "ADMIN" ] }',
            ],
            [
                [
                    'name'  => 'toto',
                    'roles' => [
                        'User'  => true,
                        'Admin' => false,
                    ],
                    'email' => 'toto@toto.com',
                ],
                [
                    'name'     => 'toto@toto.com',
                    'email'    => 'toto@toto.com',
                    'roles'    => [
                        'User' => true,
                    ],
                    'modified' => true,
                ],
                '[{ "op": "copy", "from": "/email", "path": "/name" }, { "op": "remove", "path": "/roles/1" }, { "op": "add", "path": "/modified", "value": true }]',
            ],
        ];
    }
}