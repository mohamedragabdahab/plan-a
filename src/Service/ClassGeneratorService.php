<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;

class ClassGeneratorService
{
    private ClassValidatorService $classValidatorService;
    private ClassDataBuilderService $classBuilderService;
    private ClassTemplateService $classTemplateService;
    private Filesystem $filesystem;

    public function __construct(
        ClassValidatorService   $classValidatorService,
        ClassDataBuilderService $classBuilderService,
        ClassTemplateService    $classTemplateService,
        Filesystem              $filesystem
    )
    {
        $this->classValidatorService = $classValidatorService;
        $this->classTemplateService = $classTemplateService;
        $this->classBuilderService = $classBuilderService;
        $this->filesystem = $filesystem;
    }

    public function generateFromArray(array $data): void
    {
        $this->classValidatorService->validate($data);

        $classData = $this->classBuilderService->buildClassData($data);

        $classContent = $classData[ClassDataBuilderService::CLASS_FILE_CONTENT];

        $classBody = $this->classTemplateService->parseTemplate($classContent);

        $this->createClass(
            $classData[ClassDataBuilderService::CLASS_FILE_DETAILS],
            $classBody
        );
    }

    private function createClass(array $classFileDetails, string $classBody): void
    {
        $filePath = $classFileDetails[ClassDataBuilderService::CLASS_FILE_PATH];
        $fileName = $classFileDetails[ClassDataBuilderService::CLASS_FILE_NAME];

        if (!$this->filesystem->exists($filePath)) {
            $this->filesystem->mkdir($filePath);
        }

        $file = sprintf('%s/%s', $filePath, $fileName);

        if (file_put_contents($file, $classBody) === false) {
            throw new \Exception('Class file not created');
        }
    }
}