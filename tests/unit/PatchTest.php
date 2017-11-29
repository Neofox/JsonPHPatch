<?php

use Neofox\JsonPatcher\Patch;
use PHPUnit\Framework\TestCase;

/**
 * Created by PhpStorm.
 * User: jerome
 * Date: 28/11/2017
 * Time: 14:30
 */

class PatchTest extends TestCase
{
    public function testCanGenerateTheAddOperation()
    {
        $document = $this->getDocument();

        $res1 = (new Patch($document))->add('/toto/php', 'test');
        $res2 = (new Patch($document))->add('/toto', ['name' => 'new value']);

        $this->assertJsonStringEqualsJsonString((string) $res1, '{ "op": "add", "path": "/toto/php", "value": "test" }');
        $this->assertJsonStringEqualsJsonString((string) $res2, '{ "op": "add", "path": "/toto", "value": { "name": "new value" } }');
    }

    public function testCanGenerateTheRemoveOperation()
    {
        $document = $this->getDocument();

        $res = (new Patch($document))->remove('/name');

        $this->assertJsonStringEqualsJsonString((string) $res, '{ "op": "remove", "path": "/name" }');
    }

    public function testCanGenerateTheReplaceOperation()
    {
        $document = $this->getDocument();
        $patch = new Patch($document);

        $res = $patch->replace('/name', 'jerome');

        $this->assertJsonStringEqualsJsonString((string) $res, '{ "op": "replace", "path": "/name", "value": "jerome" }');
    }

    public function testCanGenerateTheCopyOperation()
    {
        $document = $this->getDocument();
        $patch = new Patch($document);

        $res = $patch->copy('/name', '/email');

        $this->assertJsonStringEqualsJsonString((string) $res, '{ "op": "copy", "from": "/email", "path": "/name" }');
    }

    public function testCanGenerateTheMoveOperation()
    {
        $document = $this->getDocument();
        $patch = new Patch($document);

        $res = $patch->move('/rand', '/roles');

        $this->assertJsonStringEqualsJsonString((string) $res, '{ "op": "move", "from": "/roles", "path": "/rand" }');
    }

    public function testCanGenerateTheTestOperation()
    {
        $document = $this->getDocument();
        $patch = new Patch($document);

        $res = $patch->test('/name', 'toto');

        $this->assertJsonStringEqualsJsonString((string) $res, '{ "op": "test", "path": "/name", "value": "toto" }');
    }

    public function testCanGenerateMultipleOperation()
    {
        $document = $this->getDocument();
        $patch = new Patch($document);

        $res = $patch->add('/toto', 'test')->remove('/roles/1');

        $this->assertJsonStringEqualsJsonString((string) $res, '[{ "op": "add", "path": "/toto", "value": "test" }, { "op": "remove", "path": "/roles/1" }]');

    }

    private function getDocument()
    {
        return [
            'name' => 'toto',
            'roles' => [
                'ADMIN',
                'USER'
            ],
            'rand' => [],
            'email' => 'toto@toto.com'
        ];
    }
}
