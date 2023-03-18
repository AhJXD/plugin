<?php

return function (array& $args) {
    if (preg_match('~^\W?restart$~i', $args['text'])) {
        $this->messages->sendMessage(
            message         : '`Robot was restarted!`',
            parse_mode      : 'markdown',
            peer            : $args['update'],
            reply_to_msg_id : $args['messageId']
        );
        $this->restart();
    }
};