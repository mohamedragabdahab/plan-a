<?php

namespace App\Service;

class ClassTemplateService extends AbstractTemplate
{
    public function parseTemplate(array $classContent): string
    {
        $placeHolders = array_map(function ($values) {
            return '{' . $values . '}';
        }, array_keys($classContent));

        return str_replace($placeHolders, array_values($classContent), $this->getTemplate());
    }
}