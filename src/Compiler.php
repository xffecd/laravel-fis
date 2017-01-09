<?php
namespace Fis;

use Illuminate\Filesystem\Filesystem;
use \Illuminate\View\Compilers\BladeCompiler;
use Illuminate\Support\Str;

class Compiler extends BladeCompiler {

    protected function compileExtends($expression) {
        if (!Str::startsWith($expression, '(')) {
            $expression = "($expression)";
        }
        parent::compileExtends("\$__fis->uri{$expression}");
    }

    protected function compileInclude($expression) {
        if (!Str::startsWith($expression, '(')) {
            $expression = "($expression)";
        }
        return parent::compileInclude("\$__fis->uri{$expression}");
    }

    protected function compileFramework($expression) {
        return "<?php \$__fis->setFramework{$expression}; ?>";
    }

    protected function compilePlaceholder($expression) {
        return "<?php echo \$__fis->placeholder{$expression}; ?>";
    }

    protected function compileRequire($expression) {
        //app('fis')->add_test($expression);
        return "<!--f.r{$expression}-->";
    }

    protected function compileWidget($expression) {
        return $this->compileInclude($expression);
    }

    protected function compileUri($expression) {
        return "<?php echo \$__fis->uri{$expression}; ?>";
    }

    protected function compileUrl($expression) {
        return "\$__fis->uri{$expression}";
    }

    protected function compileScript($expression) {
        if (!Str::startsWith($expression, '(')) {
            $expression = "($expression)";
        }
        return "<!--$expression--><?php \$__fis->startScript{$expression}; ?>";
    }
    protected function compileEndscript($expression) {
        return "<?php \$__fis->endScript(); ?>";
    }

    protected function compileStyle($expression) {
        if (!Str::startsWith($expression, '(')) {
            $expression = "($expression)";
        }
        return "<?php \$__fis->startStyle{$expression}; ?>";
    }

    protected function compileEndstyle($expression) {
        return "<?php \$__fis->endStyle(); ?>";
    }
}