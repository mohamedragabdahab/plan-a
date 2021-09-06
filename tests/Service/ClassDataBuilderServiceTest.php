<?php

namespace App\Tests\Service;

use App\Service\ClassDataBuilderService;
use PHPUnit\Framework\TestCase;

class ClassDataBuilderServiceTest extends TestCase
{
    public function test_build_class_data(): void
    {
        $classDataBuilderService = new ClassDataBuilderService();

        $actualClassData = $classDataBuilderService->buildClassData($this->getClassData());
        $expectedClassData = [
            'class_file' => [
                'file_name' => 'MeetingRooms.php',
                'file_path' => 'Model/IndirectEmissionsOwned/Electricity',
            ],
            'class_body' => [
                'namespace' => 'App\Model\IndirectEmissionsOwned\Electricity',
                'class_name' => 'MeetingRooms',
                'table_name' => 'meeting-rooms',
            ]
        ];

        $this->assertEquals($expectedClassData, $actualClassData);
    }

    private function getClassData(): array
    {
        return [
            'scope' => [
                'indirect-emissions-owned',
                'electricity',
            ],
            'name' => 'meeting-rooms',
        ];
    }
}
