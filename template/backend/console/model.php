<?php
namespace backend\console;
class model
{
    /**
     * Create a new model file
     *
     * @param string $model_name
     * @param string $force
     * @return void
     */
    public static function create($model_name, $force = "")
    {
        $model_name_array = explode('_', $model_name);
        $namespace = implode('\\', array_merge(['backend\models'], array_slice($model_name_array, 0, -1)));
        $class_name = $model_name_array[count($model_name_array) - 1];
        $file_path = dirname(__DIR__) . '/models/' . implode('/', $model_name_array) . '.php';
        $file_dir = dirname($file_path);


        if (is_file($file_path) and $force !== '-f')
            die('file already exists.');
        if (!is_dir($file_dir))
            mkdir($file_dir, 0755, true);


        $file_code = [];
        $file_code[] = '<?php';
        $file_code[] = "namespace $namespace;";
        $file_code[] = "use lemoni\database\mysql\migration;";
        $file_code[] = "use lemoni\database\mysql\model;";
        $file_code[] = "class $class_name extends model {";
        $file_code[] = "\tpublic static function init() {";
        $file_code[] = "\t\tmigration::exe([]);";
        $file_code[] = "\t}";
        $file_code[] = "}";
        fwrite(fopen($file_path, 'w+'), implode("\n", $file_code));
        echo "\n\n" . realpath($file_path) . "\n\n";
    }
}