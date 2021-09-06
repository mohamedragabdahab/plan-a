<?php

namespace App\Service;

class ClassValidatorService
{
    public const KEY_NAME = 'name';

    public const KEY_SCOPE = 'scope';

    public function validate(array $data): void
    {
        if (empty($data[self::KEY_NAME])) {
            throw new \Exception('Invalid provided data name.');
        }

        if (empty($data[self::KEY_SCOPE])) {
            throw new \Exception('Invalid provided data scope.');
        }

        if (!is_array($data[self::KEY_SCOPE])) {
            throw new \Exception('Provided data scope must be an array.');
        }
    }
}