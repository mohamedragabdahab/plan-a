<?php

namespace App\Tests\Service;

use App\Service\ClassDataBuilderService;
use App\Service\ClassGeneratorService;
use App\Service\ClassTemplateService;
use App\Service\ClassValidatorService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;

class ClassGeneratorServiceTest extends TestCase
{
    public function testSomething(): void
    {
        $classValidatorService = $this->createMock(ClassValidatorService::class);
        $classValidatorService->expects($this->once())
            ->method('validate')
            ->with($this->getClassData());

        $classDataBuilderService = $this->createMock(ClassDataBuilderService::class);
        $classDataBuilderService->expects($this->once())
            ->method('buildClassData')
            ->with($this->getClassData())
            ->willReturn([
                'class_file' => [
                    'file_name' => 'MeetingRooms.php',
                    'file_path' => 'Model/IndirectEmissionsOwned/Electricity',
                ],
                'class_body' => [
                    'namespace' => 'App\Model\IndirectEmissionsOwned\Electricity',
                    'class_name' => 'MeetingRooms',
                    'table_name' => 'meeting-rooms',
                ]
            ]);

        $classTemplateService = $this->createMock(ClassTemplateService::class);
        $classTemplateService->expects($this->once())
            ->method('parseTemplate')
            ->with([
                'namespace' => 'App\Model\IndirectEmissionsOwned\Electricity',
                'class_name' => 'MeetingRooms',
                'table_name' => 'meeting-rooms',
            ])
            ->willReturn(
                <<<PHP
            <?php
            namespace App\Model\IndirectEmissionsOwned\Electricity;
            
            use Illuminate\Database\Eloquent\Model;
            
            class MeetingRooms extends Model
            {
                const TABLE_NAME = "meeting-rooms";
                
                public function getTableName(): string
                {
                    return self::TABLE_NAME;
                }
            }
            PHP
            );

        $filesystem = $this->createMock(Filesystem::class);
        $filesystem->expects($this->once())
            ->method('exists')
            ->willReturn(true);

        $filesystem->expects($this->once())
            ->method('mkdir')
            ->with('Model/IndirectEmissionsOwned/Electricity');


        $classGeneratorService = new ClassGeneratorService(
            $classValidatorService,
            $classDataBuilderService,
            $classTemplateService,
            $filesystem
        );

        $classGeneratorService->generateFromArray($this->getClassData());

        $this->assertFileExists('Model/IndirectEmissionsOwned/Electricity/MeetingRooms.php');
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
