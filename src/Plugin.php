<?php

namespace AhJXD\Plugin;

use function Amp\File\{isDirectory, listFiles, isFile};

trait Plugin {
    private function loadPlugin(string $dir): void
    {
        foreach(listFiles($dir) as $path) {
            $realPath  = $this->makePath($dir, $path);
            if (isDirectory($realPath)) {
                foreach(listFiles($realPath) as $subPath) {
                    $realSubPath  = $this->makePath($realPath, $subPath);
                    $this->require($realSubPath, $realPath);
                }
                continue;
            }
            $this->require($path);
        }
    }

    /**
     * Reqiure file in property
     * @param string $path
     * @param string $depth
     * @param string $type
     * @return void
     */
    private function require(string $path, $depth = 'public'): void
    {
        $pathInfo = pathinfo($path);
        [ $name, $ext ] = [ $pathInfo['filename'], $pathInfo['extension'] ];
        if (isFile($path) && $ext === "php")
            $this->plugin[basename($depth)][$name] = require $path;
    }
}