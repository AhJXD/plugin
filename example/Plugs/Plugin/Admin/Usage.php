<?php

return function (array& $args) {
    if (preg_match('~^\W?usage$~i', $args['text'])) {
        $memory = memory_get_usage(true) / 1024/ 1024;
        $this->messages->sendMessage(
            message         : "`Memory usage is ".$memory." Mb`",
            parse_mode      : 'markdown',
            peer            : $args['update'],
            reply_to_msg_id : $args['messageId']
        );
    }
};