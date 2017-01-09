<?php
namespace Fis;

use Illuminate\View\Engines\CompilerEngine;

class Engine extends CompilerEngine {

    public function get($path, array $data = array()) {
        $env = (Object)$data['__env'];
        $result =  parent::get($path, $data);
        $env->decrementRender();
        $doneRendering = $env->doneRendering();
        $env->incrementRender();
        $doneRendering && ($result = app('fis')->filter($result));
        return $result;
    }
}