<?php
/**
 * Created by PhpStorm.
 * User: jerome
 * Date: 28/11/2017
 * Time: 14:05
 */

namespace Neofox\JsonPatcher;

class Patch
{
    /** @var array */
    protected $document;

    /** @var array */
    private $patch = [];

    public function __construct(array $document)
    {
        $this->document = $document;
    }

    public function add($path, $value): Patch
    {
        $this->patch[] = ['op' => 'add', 'path' => $path, 'value' => $value];

        return $this;
    }

    public function remove($path): Patch
    {
        $this->patch[] = ['op' => 'remove', 'path' => $path];

        return $this;
    }

    public function replace($path, $value): Patch
    {
        $this->patch[] = ['op' => 'replace', 'path' => $path, 'value' => $value];

        return $this;
    }

    public function copy($path, $from): Patch
    {
        $this->patch[] = ['op' => 'copy', 'from' => $from, 'path' => $path];

        return $this;
    }

    public function move($path, $from): Patch
    {
        $this->patch[] = ['op' => 'move', 'from' => $from, 'path' => $path];

        return $this;
    }

    public function test($path, $value): Patch
    {
        $this->patch[] = ['op' => 'test', 'path' => $path, 'value' => $value];

        return $this;
    }

    public function __toString(): string
    {
        if (\count($this->patch) === 1) {
            $this->patch = $this->patch[0];
        }

        return json_encode($this->patch, JSON_UNESCAPED_SLASHES);
    }
}
