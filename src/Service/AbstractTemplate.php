<?php

namespace App\Service;

class AbstractTemplate
{
    public function getTemplate(): string
    {
        return <<<PHP
            <?php
            namespace {namespace};
            
            use Illuminate\Database\Eloquent\Model;
            
            class {class_name} extends Model
            {
                const TABLE_NAME = "{table_name}";
                
                public function getTableName(): string
                {
                    return self::TABLE_NAME;
                }
            }
            PHP;
    }
}