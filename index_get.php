<?php
require_once './vendor/autoload.php';
// Namespace
use \LINE\LINEBot;
use \LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot\MessageBuilder\TextMessageBuilder;

$channel_token = 'WyUPHjT6UfUUuRkCVDtXLWsiQgWzrJ1CJcHumTTDc8GyvMwPYNgVuJjO5htMtKd04XjAMycLv7fCVHM4QIFufSRqxHvasVw2Rry7RLWkIZdYz/qRSRDW8PBixHYOKr5FDxTILJwsLSvcfmqGRzx3KwdB04t89/1O/w1cDnyilFU=';
$channel_secret = '23305d52c27a46d4ed5c36b63fdc602f';
// Get message from Line API
$content = file_get_contents('php://input');
$events = json_decode($content, true);
if (!is_null($events['events'])) {
    // Loop through each event
    foreach ($events['events'] as $event) {
        // Line API send a lot of event type, we interested in message only.
        if ($event['type'] == 'message') {
            // Get replyToken
            $replyToken = $event['replyToken'];
            $httpClient = new CurlHTTPClient($channel_token);
            $bot = new LINEBot($httpClient, array('channelSecret' => $channel_secret));
            switch ($event['message']['type']) {
                case 'text':
                    // Get replyToken
                    // Reply message
                    $respMessage = 'Hello, your message is ' . $event['message']['text'];
                    break;
                case 'image':
                    $messageID = $event['message']['id'];
                    $respMessage = 'Hello, your image ID is ' . $messageID;
                    break;
                case 'sticker':
                    $messageID = $event['message']['packageId'];
                    // Reply message
                    $respMessage = 'Hello, your Sticker Package ID is ' . $messageID;
                    break;
                case 'video':
                    $messageID = $event['message']['id'];
                    // Create video file on server.
                    $fileID = $event['message']['id'];
                    $response = $bot->getMessageContent($fileID);
                    $fileName = 'linebot.mp4';
                    $file = fopen($fileName, 'w');
                    fwrite($file, $response->getRawBody());
                    // Reply message
                    $respMessage = 'Hello, your video ID is ' . $messageID;
                    break;
                case 'audio':
                    $messageID = $event['message']['id'];
                    // Create audio file on server.
                    $fileID = $event['message']['id'];
                    $response = $bot->getMessageContent($fileID);
                    $fileName = 'linebot.m4a';
                    $file = fopen($fileName, 'w');
                    fwrite($file, $response->getRawBody());
                    // Reply message
                    $respMessage = 'Hello, your audio ID is ' . $messageID;
                    break;
                case 'location':
                    $address = $event['message']['address'];
                    // Reply message
                    $respMessage = 'Hello, your address is ' . $address;
                    break;
                default:
                    $respMessage = 'Please send image only';
                    break;
            }
            // $httpClient = new CurlHTTPClient($channel_token);

            $textMessageBuilder = new TextMessageBuilder($respMessage);
            $response = $bot->replyMessage($replyToken, $textMessageBuilder);
        }
    }
}
echo "OK";
