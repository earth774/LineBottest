<?php
require_once './vendor/autoload.php';
// Namespace
use \LINE\LINEBot;
use \LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot\MessageBuilder\VideoMessageBuilder;
// Token
$channel_token = 'WyUPHjT6UfUUuRkCVDtXLWsiQgWzrJ1CJcHumTTDc8GyvMwPYNgVuJjO5htMtKd04XjAMycLv7fCVHM4QIFufSRqxHvasVw2Rry7RLWkIZdYz/qRSRDW8PBixHYOKr5FDxTILJwsLSvcfmqGRzx3KwdB04t89/1O/w1cDnyilFU=';
$channel_secret = '23305d52c27a46d4ed5c36b63fdc602f';
// Get message from Line API
$content = file_get_contents('php://input');
$events = json_decode($content, true);
if (!is_null($events['events'])) {
    // Loop through each event
    foreach ($events['events'] as $event) {
        // Get replyToken
        $replyToken = $event['replyToken'];
        // Video
        $originalContentUrl = 'https://www.select2web.com.com/the-fuji.mp4';
        $previewImageUrl = 'https://www.select2web.com.com/the-fuji.jpg';
        $httpClient = new CurlHTTPClient($channel_token);
        $bot = new LINEBot($httpClient, array('channelSecret' => $channel_secret));
        $textMessageBuilder = new VideoMessageBuilder($originalContentUrl, $previewImageUrl);
        $response = $bot->replyMessage($replyToken, $textMessageBuilder);
    }
}

echo "OK";
