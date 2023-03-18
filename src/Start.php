<?php

namespace AhJXD\Plugin;

use function Amp\File\{ listFiles, isFile };

trait Start {
    private function loadStart(string $dir): void
    {
        foreach(listFiles($dir) as $path) {
            $realPath = $this->makePath($dir, $path);
            $pathInfo = pathinfo($realPath);
            [ $name, $ext ] = [ $pathInfo['filename'], $pathInfo['extension'] ];
            if (isFile($realPath) && $ext === "php")
                $this->start[$name] = require $realPath;
        }
    }
}