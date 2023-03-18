<?php

namespace AhJXD\Plugin;

use danog\MadelineProto\EventHandler;
use Revolt\EventLoop;

class Handler extends EventHandler
{
    use Start, Loop, Plugin;
    protected array $plugin, $loop, $start;
    final public function onStart() {

        // init
        $this->loop   = [];
        $this->plugin = [];
        $this->start  = [];

        // Load Plugins
        $this->loadPlugin($this->getPluginDir());
        $this->loadStart($this->getStartDir());
        $this->loadLoop($this->getLoopDir());

        // Call onStart Plugins once
        array_map(fn($plugin) => EventLoop::queue($plugin), $this->start);

        // Start Loops
        if (!empty($this->loop))
            array_map(fn($loop) => $loop->start(), $this->loop);
    }

    /**
     * Get Loop Plugin Directory
     * @return string 
     */
    protected function getLoopDir()
    {
        return '';
    }

    /**
     * Get onStart Plugin Directory
     * @return string
     */
    protected function getStartDir()
    {
        return '';
    }

    /**
     * Get Plugin Directory
     * @return string
     */
    protected function getPluginDir()
    {
        return '';
    }

    /**
     * Makes an absolute path, using an array of dir|file names.
     * @param string ...$args
     * @return string
     */
    public function makePath(string ...$args): string
    {
        return implode(DIRECTORY_SEPARATOR, $args);
    }

    /**
     * Excute all plugins 
     */
    public function callPlugin(array $mode ,array $params) {
        array_map(fn($plugin) => EventLoop::queue($plugin, $params), $mode);
    }
}