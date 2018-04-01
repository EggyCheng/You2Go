<?php

ini_set("log_errors", 1);
ini_set("error_log", "./php-error.log");
set_time_limit(0);
require_once('./LINEBotTiny.php');

$channelAccessToken = '';
$channelSecret = '';

$client = new LINEBotTiny($channelAccessToken, $channelSecret);
foreach ($client->parseEvents() as $event) {
    switch ($event['type']) {
        case 'message':
            $message = $event['message'];
            switch ($message['type']) {
                case 'text':

                    $String = $message['text'];
                    $FindKey1 = 'https://www.youtube.com/';
                    $FindKey2 = 'https://youtu.be/';
                    $TryStrpos1 = strpos($String,$FindKey1);
                    $TryStrpos2 = strpos($String,$FindKey2);
                    if($TryStrpos1 === false && $TryStrpos2 === false){
                      $backmsg = 'You2GO 只吃 YOUTUBE 連結喔! ＞///＜';
                    }
                    else{
                      $backmsg = '音樂已經開始下載，請稍候';
                    }

                    $client->replyMessage(array(
                        'replyToken' => $event['replyToken'],
                        'messages' => array(
                            array(
                                'type' => 'text',
                                'text' => $backmsg
                            )
                        )
                    ));

                    $chTest = curl_init();
                    curl_setopt($chTest, CURLOPT_URL, "http://<url>:5555/download?key=" . $message['text']);
                    curl_setopt($chTest, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8', 'Accept: application/json'));
                    curl_setopt($chTest, CURLOPT_HEADER, true);
                    curl_setopt($chTest, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($chTest, CURLOPT_CONNECTTIMEOUT, 600);
                    $curl_res_test = curl_exec($chTest);
                    $json_res_test = explode("\r\n", $curl_res_test);
                    $codeTest = curl_getinfo($chTest, CURLINFO_HTTP_CODE);
                    curl_close($chTest);

                    $userid = $event['source'];
                    $userid = $userid['userId'];

					$client->pushMessage(array(
                        'to' => $userid,
                        'messages' => array(
                            array(
                                'type' => 'text',
                                'text' => '下載完成，請至 http://gofile.me/3IJRN/lPjCTFC8i 下載您的音樂 (PC only)'
                            )   
                        )   
                    ));

                    break;
                default:
                    error_log("Unsupporeted message type: " . $message['type']);
                    break;
            }
            break;
        default:
            error_log("Unsupporeted event type: " . $event['type']);
            break;
    }
};
