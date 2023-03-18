<?php

namespace AhJXD\Plugin;

use function Amp\File\{listFiles, isFile};
use danog\Loop\GenericLoop;

trait Loop {
    private function loadLoop(string $dir): void
    {
        foreach(listFiles($dir) as $path) {
            $realPath = $this->makePath($dir, $path);
            $pathInfo = pathinfo($realPath);
            [ $name, $ext ] = [ $pathInfo['filename'], $pathInfo['extension'] ];
            if (isFile($realPath) && $ext === "php")
                $this->loop[] = new GenericLoop(require $realPath, $name);
        }
    }
}