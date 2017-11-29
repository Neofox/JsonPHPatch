<?php
/**
 * Created by PhpStorm.
 * User: jerome
 * Date: 28/11/2017
 * Time: 13:50
 */

namespace Neofox\JsonPatcher;

class JsonPatcher
{
    public function apply(array $document, string $patch): array
    {
        $newDocument = [];

        return $newDocument;
    }

    public function diff(array $original, array $updated): string
    {
        return '';
    }
}
