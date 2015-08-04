<?php
/**
 * Post a message on Slack with Incoming Webhooks
 * @author: Sofiane Gargouri <contact@sofianeg.com>
 *
 */

$slack = array(
    "ROOM_NAME_WITHOUT_#" => "URL PROVIDED BY INCOMING WEBHOOKS"
);

/**
 * 2 cases:
 * if $attachments is false
 * @param $text: content of a regular message
 *
 * if $attachments is true
 * @param $text: block content
 * @param $message: block preview
 * @param $title: block title
 * @param $color: left line color
 * @param $room: the room where you want to post the message, without the #
 *
 */
function PostSlackMessage($text, $attachments = false, $message = null, $title = null, $color = "#555555", $room = "DEFAULT ROOM")
{
    global $slack;
    if ($attachments === true)
        $data = "payload=" . json_encode(
                array(
                    "attachments" => array(
                        array(
                            "fallback" => $message,
                            "pretext" => $message,
                            "color" => $color,
                            "fields" => array(
                                array(
                                    "title" => $title,
                                    "value" => $text,
                                    "short" => false
                                )
                            )
                        )
                    )
                )
            );
    else
        $data = "payload=" . json_encode(
                array(
                    "text" => $text
                )
            );


    $opts = array('http' =>
        array(
            'method' => 'POST',
            'header' => 'Content-type: application/x-www-form-urlencoded',
            'content' => $data
        )
    );
    $context = stream_context_create($opts);
    file_get_contents($slack[$room], false, $context);
}
?>