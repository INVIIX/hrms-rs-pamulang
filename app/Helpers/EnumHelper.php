<?php
namespace App\Helpers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

class EnumHelper
{
    public static function getAllEnums(string $namespace = 'App\\Enums'): array
    {
        $path = app_path('Enums');
        $files = File::files($path);
        $result = [];
        foreach ($files as $file) {
            $className = $namespace . '\\' . $file->getFilenameWithoutExtension();
            if (enum_exists($className)) {
                $cases = $className::cases();
                $name = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $file->getFilenameWithoutExtension()));
                $result[$name] = collect($cases)->map(fn($case) => [
                    'value' => $case->value,
                    'label' => method_exists($case, 'label') ? $case->label() : $case->value,
                ]);
            }
        }
        return $result;
    }

    public static function get(string $name, string $namespace = 'App\\Enums'): array|Collection
    {
        $className = $namespace . '\\' . str($name)->studly();
        $result = [];
        if (enum_exists($className)) {
            $cases = $className::cases();
            $result = collect($cases)->map(fn($case) => [
                'value' => $case->value,
                'label' => method_exists($case, 'label') ? $case->label() : $case->value,
            ]);
        }
        return $result;
    }
}
