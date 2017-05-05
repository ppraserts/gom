<?php
/**
 * Created by PhpStorm.
 * User: BERM-NOTEBOOK
 * Date: 5/5/2017
 * Time: 11:02 AM
 */

namespace app\Helpers;

use Illuminate\Support\Facades\Schema;

class MigrationHelper
{
    public static function listTableForeignKeys($table)
    {
        $conn = Schema::getConnection()->getDoctrineSchemaManager();
        return array_map(function($key) {
            return $key->getName();
        }, $conn->listTableForeignKeys($table));
    }
}