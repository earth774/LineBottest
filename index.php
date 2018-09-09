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
            try {
                // Check to see user already answer
                $host = 'ec2-54-235-160-57.compute-1.amazonaws.com';
                $dbname = 'dbgi88drnrb4b2';
                $user = 'gyyihuipnfrnst';
                $pass = 'bb1d0f4530c5eb1c470b71bfcf9402465a41a8e793220072fb5e30a00daa18ff';
                $connection = new PDO("pgsql:host=$host;dbname=$dbname", $user, $pass);
                $sql = sprintf("SELECT * FROM poll WHERE user_id='%s' ", $event['source']['userId']);
                $result = $connection->query($sql);
                error_log($sql);
                if ($result == false || $result->rowCount() <= 0) {
                    switch ($event['message']['text']) {
                        case '1':
// Insert
                            $params = array(
                                'userID' => $event['source']['userId'],
                                'answer' => '1',
                            );
                            $statement = $connection->prepare('INSERT INTO poll ( user_id, answer )
VALUES ( :userID, :answer )');
                            $statement->execute($params);
// Query
                            $sql = sprintf("SELECT * FROM poll WHERE answer='1' AND user_id='%s' ",
                                $event['source']['userId']);
                            $result = $connection->query($sql);
                            $amount = 1;
                            if ($result) {
                                $amount = $result->rowCount();
                            }
                            $respMessage = 'จ ำนวนคนตอบว่ำเพื่อน = ' . $amount;
                            break;
                        case '2':
// Insert
                            $params = array(
                                'userID' => $event['source']['userId'],
                                'answer' => '2',
                            );
                            $statement = $connection->prepare('INSERT INTO poll ( user_id, answer )
VALUES ( :userID, :answer )');
                            $statement->execute($params);
// Query
                            $sql = sprintf("SELECT * FROM poll WHERE answer='2' AND user_id='%s' ",
                                $event['source']['userId']);
                            $result = $connection->query($sql);
                            $amount = 1;
                            if ($result) {
                                $amount = $result->rowCount();
                            }
                            $respMessage = 'จ ำนวนคนตอบว่ำแฟน = ' . $amount;
                            break;
                        case '3':
// Insert
                            $params = array(
                                'userID' => $event['source']['userId'],
                                'answer' => '3',
                            );
                            $statement = $connection->prepare('INSERT INTO poll ( user_id, answer )
VALUES ( :userID, :answer )');
                            $statement->execute($params);
// Query
                            $sql = sprintf("SELECT * FROM poll WHERE answer='3' AND user_id='%s' ",
                                $event['source']['userId']);
                            $result = $connection->query($sql);
                            $amount = 1;
                            if ($result) {
                                $amount = $result->rowCount();
                            }
                            $respMessage = 'จ ำนวนคนตอบว่ำพ่อแม่ = ' . $amount;
                            break;
                        case '4':
// Insert
                            $params = array(
                                'userID' => $event['source']['userId'],
                                'answer' => '4',
                            );
                            $statement = $connection->prepare('INSERT INTO poll ( user_id, answer )
VALUES ( :userID, :answer )');
                            $statement->execute($params);
// Query
                            $sql = sprintf("SELECT * FROM poll WHERE answer='4' AND user_id='%s' ",
                                $event['source']['userId']);
                            $result = $connection->query($sql);
                            $amount = 1;
                            if ($result) {
                                $amount = $result->rowCount();
                            }
                            $respMessage = 'จ ำนวนคนตอบว่ำบุคคลอื่นๆ = ' . $amount;
                            break;
                        default:
                            $respMessage = "
บุคคลที่โทรหำบ่อยที่สุด คือ? \n\r
กด 1 เพื่อน \n\r
กด 2 แฟน \n\r
กด 3 พ่อแม่ \n\r
กด 4 บุคคลอื่นๆ \n\r
";
                            break;
                    }
                } else {
                    $respMessage = 'คุณได้ตอบโพลล์นี้แล้ว';
                }
                $httpClient = new CurlHTTPClient($channel_token);
                $bot = new LINEBot($httpClient, array('channelSecret' => $channel_secret));
                $textMessageBuilder = new TextMessageBuilder($respMessage);
                $response = $bot->replyMessage($replyToken, $textMessageBuilder);
            } catch (Exception $e) {
                error_log($e->getMessage());
            }
        }
    }
}
echo "OK";
