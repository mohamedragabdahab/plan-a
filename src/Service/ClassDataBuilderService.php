<?php

namespace App\Service;

class ClassDataBuilderService
{
    private const CLASS_NAME = 'class_name';
    private const CLASS_TABLE_NAME = 'table_name';
    private const CLASS_NAMESPACE = 'namespace';

    public const CLASS_FILE_NAME = 'file_name';
    public const CLASS_FILE_PATH = 'file_path';

    public const CLASS_FILE_CONTENT = 'class_body';
    public const CLASS_FILE_DETAILS = 'class_file';

    private const CLASS_PHP_FILE_EXTENSION = '.php';

    private const PROJECT_MODEL_NAMESPACE = "App\Model\\";

    private array $data;

    public function buildClassData(array $data): array
    {
        $this->data = $data;

        return [
            self::CLASS_FILE_DETAILS => [
                self::CLASS_FILE_NAME => $this->getFileName(),
                self::CLASS_FILE_PATH => $this->getFilePath(),
            ],
            self::CLASS_FILE_CONTENT => [
                self::CLASS_NAMESPACE => $this->getNamespace(),
                self::CLASS_NAME => $this->getClassName(),
                self::CLASS_TABLE_NAME => $this->getTableName(),
            ]
        ];
    }

    private function getFileName(): string
    {
        return sprintf('%s%s', $this->getClassName(), $this->getFileExtension());
    }

    private function getNamespace(): string
    {
        $nameSpaceParts = [];

        $classDataScopes = $this->data[ClassValidatorService::KEY_SCOPE];

        foreach ($classDataScopes as $scope) {
            $nameSpaceParts[] = $this->buildName($scope);
        }

        $namespace = implode("\\", $nameSpaceParts);

        return self::PROJECT_MODEL_NAMESPACE . $namespace;
    }

    private function getFilePath(): string
    {
        $namespaceParts = str_replace('App\\', '', $this->getNamespace());

        return str_replace('\\', '/', $namespaceParts);
    }

    private function getFileExtension(): string
    {
        return self::CLASS_PHP_FILE_EXTENSION;
    }

    private function getClassName(): string
    {
        $className = $this->data[ClassValidatorService::KEY_NAME];

        return $this->buildName($className);
    }

    private function getTableName(): string
    {
        $tableName = $this->data[ClassValidatorService::KEY_NAME];

        return strtolower($tableName);
    }

    private function buildName(string $itemName, string $itemDelimiter = '-'): string
    {
        $nameInLowerCase = strtolower($itemName);
        $nameInCamelCase = ucwords($nameInLowerCase, $itemDelimiter);

        return str_replace($itemDelimiter, '', $nameInCamelCase);
    }
}