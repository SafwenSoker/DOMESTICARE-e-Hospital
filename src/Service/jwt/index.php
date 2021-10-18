<?php

include_once 'Zoom_Api.php';
$zoom_meeting = new Zoom_Api();

$data = [];
$data['topic'] = 'Example Text Meeting';
$data['start_date'] = date('Y-m-d h:i:s', strtotime('tomorrow'));
$data['duration'] = 30;
$data['type'] = 2;
$data['password'] = '12345';

try {
    $response = $zoom_meeting->createMeeting($data);
    dump($response);
} catch (Exception $ex) {
    echo $ex;
}
