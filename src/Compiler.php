<?php
namespace Fis;

use \Illuminate\View\Compilers\BladeCompiler;

class Compiler extends BladeCompiler {

    protected function compileExtends($express) {
        parent::compileExtends($express);
    }
}