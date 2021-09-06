<?php

namespace App\Tests\Service;

use App\Service\ClassValidatorService;
use PHPUnit\Framework\TestCase;

class ClassValidatorServiceTest extends TestCase
{
    public function test_throw_invalid_data_name_exception(): void
    {
        $data = [
            'scope' => [
                'indirect-emissions-owned',
                'electricity',
            ],
            'invalid_name_key' => 'meeting-rooms',
        ];

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid provided data name.');
        $classValidatorService = new ClassValidatorService();
        $classValidatorService->validate($data);
    }

    public function test_throw_invalid_data_scope_exception(): void
    {
        $data = [
            'invalid_scope_key' => [
                'indirect-emissions-owned',
                'electricity',
            ],
            'name' => 'meeting-rooms',
        ];

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid provided data scope.');
        $classValidatorService = new ClassValidatorService();
        $classValidatorService->validate($data);
    }

    public function test_throw_invalid_data_scope__type_exception(): void
    {
        $data = [
            'scope' => 'invalid_scope__value_type',
            'name' => 'meeting-rooms',
        ];

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Provided data scope must be an array.');
        $classValidatorService = new ClassValidatorService();
        $classValidatorService->validate($data);
    }
}
