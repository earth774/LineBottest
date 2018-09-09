<?php
require_once './vendor/autoload.php';
use \LINE\LINEBot;
use \LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot\MessageBuilder\TextMessageBuilder;
// Token
$channel_token = 'WyUPHjT6UfUUuRkCVDtXLWsiQgWzrJ1CJcHumTTDc8GyvMwPYNgVuJjO5htMtKd04XjAMycLv7fCVHM4QIFufSRqxHvasVw2Rry7RLWkIZdYz/qRSRDW8PBixHYOKr5FDxTILJwsLSvcfmqGRzx3KwdB04t89/1O/w1cDnyilFU=';
$channel_secret = '23305d52c27a46d4ed5c36b63fdc602f';
// Get message from Line API
$content = file_get_contents('php://input');
$events = json_decode($content, true);
if (!is_null($events['events'])) {
// Loop through each event
    foreach ($events['events'] as $event) {
// Line API send a lot of event type, we interested in message only.
        if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
// Get replyToken
            $replyToken = $event['replyToken'];
// Split message then keep it in database.
            $appointments = explode(',', $event['message']['text']);
            if (count($appointments) == 2) {
                $host = 'ec2-54-235-160-57.compute-1.amazonaws.com';
                $dbname = 'dbgi88drnrb4b2';
                $user = 'gyyihuipnfrnst';
                $pass = 'bb1d0f4530c5eb1c470b71bfcf9402465a41a8e793220072fb5e30a00daa18ff';
                $connection = new PDO("pgsql:host=$host;dbname=$dbname", $user, $pass);
                $params = array(
                    'time' => $appointments[0],
                    'content' => $appointments[1],
                );
                $statement = $connection->prepare("INSERT INTO appointments (time, content) VALUES (:time,
:content)");
                $result = $statement->execute($params);
                $respMessage = 'Your appointment has saved.';
            } else {
                $respMessage = 'You can send appointment like this "12.00,House keeping." ';
            }
            $httpClient = new CurlHTTPClient($channel_token);
            $bot = new LINEBot($httpClient, array('channelSecret' => $channel_secret));
            $textMessageBuilder = new TextMessageBuilder($respMessage);
            $response = $bot->replyMessage($replyToken, $textMessageBuilder);
        }
    }
}
echo "OK";
