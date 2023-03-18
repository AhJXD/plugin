<?php

return function (array& $args) {
    if (preg_match('~^\W?ping$~i', $args['text'])) {
        $start = microtime(true) * 1000;
        $sent  = $this->messages->sendMessage(
            message         : '`Pong !`',
            parse_mode      : 'markdown',
            peer            : $args['update'],
            reply_to_msg_id : $args['messageId']
        );
        $ping = round(microtime(true) * 1000 - $start, 2);
        $this->messages->editMessage(
            peer      : $args['update'],
            id        : $this->extractMessageId($sent),
            message   : "`Pong took $ping ms.`",
            parse_mode: 'markdown'
        );
    }
};