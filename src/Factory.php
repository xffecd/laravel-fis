<?php
namespace Fis;

use Illuminate\View\Factory as ViewFactory;

class Factory extends ViewFactory {

    public function make($view, $data = [], $mergeData = [])
    {
        $ext = '.blade.php';
        $len = strlen($ext);
        if (substr($view, 0-$len) === $ext) {
            $view = substr($view, 0, 0-$len);
        }
        return parent::make($view, $data, $mergeData);
    }
}