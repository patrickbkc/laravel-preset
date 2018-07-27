<?php

namespace Patrick;

use Illuminate\Support\Arr;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Console\Presets\Preset as LaravelPreset;

class Preset extends LaravelPreset
{
    public static function install()
    {
        static::moveUserModel();
        static::updateGitignore();
        static::updateStyles();
        static::updateScripts();
        static::updatePackages();
        static::removeExampleTests();
        static::updateTestCase();
        static::updatePhpUnitXml();
        static::updateMix();
    }

    public static function updatePackageArray($packages)
    {
        return array_merge([
            'laravel-mix-purgecss' => '^2.2.0',
            'tailwindcss' => '>=0.6.4'
        ], Arr::except($packages, [
            'bootstrap',
            'popper.js',
            'jquery',
        ]));
    }
    
    public static function moveUserModel()
    {
        tap(new Filesystem, function ($fileSystem) {
            $fileSystem->delete(base_path('app/User.php'));
            $fileSystem->makeDirectory(base_path('app/Models'));
        });
        
        copy(__DIR__ . '/stubs/User.php', base_path('app/Models/User.php'));
        
        file_put_contents(base_path('config/auth.php'), str_replace(
            'App\User::class',
            'App\Models\User::class',
            file_get_contents(base_path('config/auth.php'))
        ));
        
        file_put_contents(base_path('database/factories/UserFactory.php'), str_replace(
            'App\User::class',
            'App\Models\User::class',
            file_get_contents(base_path('database/factories/UserFactory.php'))
        ));
    }
    
    public static function updateGitignore()
    {
        copy(__DIR__ . '/stubs/gitignore-stub', base_path('.gitignore'));
    }
    
    public static function updateStyles()
    {
        tap(new Filesystem, function ($fileSystem) {
            $fileSystem->deleteDirectory(resource_path('assets/sass'));
            $fileSystem->makeDirectory(resource_path('assets/less'));
        });

        copy(__DIR__ . '/stubs/resources/assets/less/app.less', resource_path('assets/less/app.less'));
    }
    
    public static function updateScripts()
    {
        copy(__DIR__ . '/stubs/resources/assets/js/bootstrap.js', resource_path('assets/js/bootstrap.js'));
    }

    public static function removeExampleTests()
    {
        tap(new Filesystem, function ($fileSystem) {
            $fileSystem->delete(base_path('tests/Feature/ExampleTest.php'));
            $fileSystem->delete(base_path('tests/Unit/ExampleTest.php'));
        });
    }

    public static function updateTestCase()
    {
        copy(__DIR__ . '/stubs/tests/TestCase.php', base_path('tests/TestCase.php'));
    }
    
    public static function updatePhpUnitXml()
    {
        copy(__DIR__ . '/stubs/phpunit.xml', base_path('phpunit.xml'));
    }
    
    public static function updateMix()
    {
        copy(__DIR__ . '/stubs/webpack.mix.js', base_path('webpack.mix.js'));
    }
}