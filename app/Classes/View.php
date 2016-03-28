<?php

namespace App\Core;

use Illuminate\Container\Container;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Engines\PhpEngine;
use Illuminate\View\Factory;
use Illuminate\View\FileViewFinder;

class View
{
    public $data = [];
    public $blade = false;

    public function __construct(Container $app)
    {
        $filesystem = $app->make('files');
        $config = $app->make('config');

        $viewResolver = new EngineResolver;

        $bladeCompiler = new BladeCompiler($filesystem, $config->get('pathToCompiledTemplates'));

        $viewResolver->register('blade', function () use ($bladeCompiler, $filesystem) {
            return new CompilerEngine($bladeCompiler, $filesystem);
        });

        $viewResolver->register('php', function () {
            return new PhpEngine;
        });

        $viewFinder = new FileViewFinder($filesystem, $config->get('pathsToTemplates'));

        $this->blade = new Factory($viewResolver, $viewFinder, $app->make('events'));
    }

    public function assign($key, $value = null)
    {
        if (is_array($key) or $key instanceof \Traversable) {
            foreach ($key as $name => $value) {
                $this->data[$name] = $value;
            }
        } else {
            $this->data[$key] = $value;
        }

        return $this;
    }

    public function fetch($file = null)
    {
        return $this->blade->make($file, $this->data)->render();
    }

    public function display($file = null)
    {
        ob_start();
        try {
            echo $this->blade->make($file, $this->data)->render();
        } catch (\Exception $e) {
            ob_end_clean();
            throw $e;
        }
        echo ob_get_clean();
    }

    public function clearAllAssign()
    {
        $this->data = [];
    }
}