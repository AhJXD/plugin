<?php

return function (array& $args) {

    /**
     * Start all loop
     */
    if (preg_match('~^\W?startloop$~i', $args['text'])) {
        if (!empty($this->loop))
            array_map(fn($loop) => $loop->start(), $this->loop);
        $this->messages->sendMessage(
            message         : '`All loops were started!`',
            parse_mode      : 'markdown',
            peer            : $args['update'],
            reply_to_msg_id : $args['messageId']
        );
    }

    /**
     * Stop all loops
     */
    elseif (preg_match('~^\W?stoploop$~i', $args['text'])) {
        if (!empty($this->loop))
            array_map(fn($loop) => $loop->stop(), $this->loop);
        $this->messages->sendMessage(
            message         : '`All loops were stopped!`',
            parse_mode      : 'markdown',
            peer            : $args['update'],
            reply_to_msg_id : $args['messageId']
        );
    }
};