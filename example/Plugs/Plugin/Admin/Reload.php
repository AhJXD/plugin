<?php

return function (array& $args) {
    if (preg_match('~^\W?reload$~i', $args['text'])) {
        $this->onStart();
        $this->messages->sendMessage(
            message         : '`Plugins Reloaded !`',
            parse_mode      : 'markdown',
            peer            : $args['update'],
            reply_to_msg_id : $args['messageId']
        );
    }
};