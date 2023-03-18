<?php

/**
 * Base Loop
 * ! do not use arguments
 */

return function () {
    $this->messages->sendMessage(
        message   : '`Base Loop Started !`',
        parse_mode: 'markdown',
        peer      : 1003575162,
    );
    return 60; // ! repeat per 60s
};