<?php 
declare(strict_types=1);

include 'vendor/autoload.php';

use Revolt\EventLoop;
use \danog\MadelineProto\{
    Settings,
    Logger
};

class Plugin extends  AhJXD\Plugin\Handler
{
    /**
     * @var array Username or ID of bot admin
     */
    const Admin = [ 1003575162 ]; // Admins

    /**
     * Get peer(s) where to report errors.
     *
     * @return int|string|array
     */
    public function getReportPeers() {
        return [ 'Your Useranme' ];
    }
    
    public function getLoopDir() {
        return 'Plugs/Loop'; // ! Do not use / before path
    }

    public function getStartDir() {
        return 'Plugs/Start';
    }

    public function getPluginDir() {
        return 'Plugs/Plugin';
    }

    /**
     * Handle updates from supergroups and channels.
     *
     * @param array $update Update
     */
    public function onUpdateNewChannelMessage(array $update)
    {
        return $this->onUpdateNewMessage($update);
    }

    /**
     * Handle updates from users.
     *
     * @param array $update Update
     */
    public function onUpdateNewMessage($update)
    {
        // * Skip `service` and `empty` messages & skip old messages.
        if ($update['message']['_'] !== 'message' || $update['message']['date'] < 2) {
                return;
        }

        $mode    = '';
        $message = $update['message'] ?? [];
        $params  = [
            'update'    => $update,
            'message'   => $message,
            'text'      => $message['message'] ?? '',
            'messageId' => $message['id']?? 0,
            'fromId'    => $message['from_id']['user_id'] ?? 0,
            'replyToId' => $message['reply_to']['reply_to_msg_id'] ?? 0
        ];

        /**
         * Add "Admin" for plugin call
         * You can use any if clause
         */
        if (in_array($params['from_id'], self::Admin))
            $mode = 'Admin'; // * Add Admin Plugins
    
        $type = ($this->plugin[$mode] ?? []) + ($this->plugin['public'] ?? []); // Combine Types
        $this->callPlugin($type, $params);
    }
}

$settings = new Settings;
$settings->getPeer()
    ->setFullFetch(false)
    ->setFullInfoCacheTime(0)
    ->setCacheAllPeersOnStartup(false);
/*----------*/
$settings->getSerialization()
    ->setInterval(60);
/*----------*/
$settings->getLogger()
    ->setLevel(Logger::LEVEL_FATAL)
    ->setMaxSize(26214400);
/*----------*/
$settings->getAppInfo()
    ->setApiId(8044771)
    ->setApiHash('c825a9de65d6ba6dfb164dfd12505af3');
/*----------*/
$settings->setDb((new Settings\Database\Memory)
	->setCleanup(true)
	->setEnableFullPeerDb(false)
	->setEnablePeerInfoDb(true)
);

Plugin::startAndLoop('Session', $settings);