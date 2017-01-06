<?php
namespace Fis;

use Illuminate\Filesystem\Filesystem;

class Fis
{
    const CSS_LINKS_HOOK = '<!--[FIS_CSS_LINKS_HOOK]-->';
    const JS_SCRIPT_HOOK = '<!--[FIS_JS_SCRIPT_HOOK]-->';
    const FRAMEWORK_HOOK = '<!--[FIS_FRAMEWORK_HOOKb]-->';
    const FRAMEWORK_CONFIG_HOOK = '<!--[FIS_FRAMEWORK_CONFIG_HOOK]-->';
    const FRAMEWORK_CONFIG_HOOK_WITH_SCRIPT = '<!--[FIS_FRAMEWORK_CONFIG_HOOK_WITH_SCRIPT]-->';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;
    /**
     * The map.json path
     * @var string
     */
    protected $path;


    public function __construct(Filesystem $files, $path) {
        $this->files = $files;
        $this->path = $path;
    }
}