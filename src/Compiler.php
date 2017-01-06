<?php
namespace Fis;

use \Illuminate\View\Compilers\BladeCompiler;

class Compiler extends BladeCompiler {

    protected function compileExtends($expression) {
        $path = $expression;
        $fis = $this->app->make('fis');

        if (Str::startsWith($path, '(')) {
            $path = substr($path, 1, -1);
        }
        $path = $fis->uri($path);
        return parent::compileExtends($path);
    }
}