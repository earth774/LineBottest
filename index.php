<?php
require_once './vendor/autoload.php';
// Namespace
use \LINE\LINEBot;
use \LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot\MessageBuilder\TextMessageBuilder;
$channel_token = '0qOVn59vvLLr7lsoCh1lGgcoLf3UdxpdRRyqJbdv/vBZWLTB/weiPZ9VnOO9nssv4XjAMycLv7fCVHM4QIFufSRqxHvasVw2Rry7RLWkIZc8naoH7CfMXXbRtVxCcYkrCKuYC2NflRHcOLEKs8AOmQdB04t89/1O/w1cDnyilFU=';
$channel_secret = '23305d52c27a46d4ed5c36b63fdc602f';
// Get message from Line API
$content = file_get_contents('php://input');
$events = json_decode($content, true);
if (!is_null($events['events'])) {
// Loop through each event
    foreach ($events['events'] as $event) {
// Line API send a lot of event type, we interested in message only.
        if ($event['type'] == 'message') {
            switch ($event['message']['type']) {
                case 'text':
                    // Get replyToken
                    $replyToken = $event['replyToken'];
                    // Reply message
                    $respMessage = 'Hello, your message is ' . $event['message']['text'];
                    break;
                case 'image':
                    $messageID = $event['message']['id'];
                    $respMessage = 'Hello, your image ID is ' . $messageID;
                    break;
                default:
                    $respMessage = 'Please send image only';
                    break;
            }
            $httpClient = new CurlHTTPClient($channel_token);
            $bot = new LINEBot($httpClient, array('channelSecret' => $channel_secret));
            $textMessageBuilder = new TextMessageBuilder($respMessage);
            $response = $bot->replyMessage($replyToken, $textMessageBuilder);

        }
    }
}
echo "OK";
