<?php
/**
 * Startup
 * ! do not use arguments
 */
return function () {
    $this->messages->sendMessage(
        message   : '`Robot just started!`',
        parse_mode: 'markdown',
        peer      : 1003575162,
    );
};