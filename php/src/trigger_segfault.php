#!/usr/bin/env php
<?php
require_once __DIR__ . '/vendor/autoload.php';

use \PAMI\Client\Impl\ClientImpl;
use \PAMI\Message\Action\OriginateAction;
use \PAMI\Message\Action\PlayDTMFAction;
use \PAMI\Message\Event\EventMessage;
use \PAMI\Message\Event\NewAccountCodeEvent;

$client = new ClientImpl(
    [
        'scheme' => 'tcp://',
        'host' => 'asterisk',
        'port' => 5038,
        'username' => 'tester',
        'secret' => 'secret',
        'connect_timeout' => 3,
        'read_timeout' => 10000,
    ]
);

$account = '' . rand(1000, 1000000);
$channel = null;
$sip_call_id = null;

$client->registerEventListener(
    function (NewAccountCodeEvent $event) use (&$channel, &$sip_call_id) {
        $channel = $event->getChannel();
        $sip_call_id = $event->getChannelVariables($channel)['sipcallid'];
    },
    function (EventMessage $event) use ($account) {
        return $event instanceof NewAccountCodeEvent && $event->getAccountCode() === $account;
    }
);

$client->open();

$originate_action = new OriginateAction('PJSIP/123@self');
$originate_action->setApplication('Dial');
$originate_action->setData('PJSIP/123@self');
$originate_action->setTimeout(60000);
$originate_action->setCallerId('+12345678901');
$originate_action->setAccount($account);
$originate_action->setAsync(true);

$result = $client->send($originate_action);

if ($result->isSuccess()) {
    $end = time() + 10;
    while (is_null($channel) && time() < $end) {
        $client->process();
        echo 'waiting...' . PHP_EOL;
        usleep(100000);
    }

    if (!$channel) {
        $client->close();
        echo 'ERROR: Failed to get channel' . PHP_EOL;
        exit(1);
    }

    echo $channel . PHP_EOL;

    do {
        $dtmf = new PlayDTMFAction($channel, 1);
        $result = $client->send($dtmf);
    } while ($result->isSuccess());
} else {
    $client->close();
    echo 'ERROR: Failed to originate' . PHP_EOL;
    exit(1);
}

$client->close();

exit(0);
