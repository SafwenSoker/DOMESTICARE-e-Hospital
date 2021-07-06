<?php

namespace App\Service;

use App\Service\Zoom_Api;
use PharException;


class MeetingGenerator
{
    public function generateMeeting(): object
    {
        $zoom_meeting = new Zoom_Api();
        $data['topic'] = !empty($data['topic']) ? $data['topic'] : 'Zoom Meeting';
        $data['start_date'] = !empty($data['start_date']) ? $data['start_date'] : date("Y-m-d h:i:s", strtotime('tomorrow'));
        $data['duration'] = !empty($data['duration']) ? $data['duration'] : 30;
        $data['type'] = 2;
        $data['password'] = "12345";
        $data['email'] = !empty($data['email']) ? $data['email'] : "safwensoker1@gmail.com";
        try {
            $response = $zoom_meeting->createMeeting($data);
            return ($response);
            echo "Meeting ID: " . $response->id;
            echo "<br>";
            echo "Topic: "    . $response->topic;
            echo "<br>";
            echo "Join URL: " . $response->join_url . "<a href='" . $response->join_url . "'>Open URL</a>";
            echo "<br>";
            echo "Meeting Password: " . $response->password;
        } catch (PharException $ex) {
            echo $ex;
        }
    }
}
