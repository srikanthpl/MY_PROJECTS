<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('pre')) {

    function pre($array) {
        echo "<pre>";
        print_r($array);
        echo "</pre>";
    }

}

function sorting_with_multi_array($a, $b) {
    return strcmp($a["discount"], $b["discount"]);
}

if (!function_exists('is_json')) {

    function is_json($string, $return_data = false) {
        $data = json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE) ? ($return_data ? $data : TRUE) : FALSE;
    }

}


if (!function_exists('send_sms')) {

    function send_sms($data) { //mobile and message. 
        //echo "working"; die; 
        return true;
        /*
          $mobile = $data['mobile'];
          $message = $data['message'];
          require_once(APPPATH . 'third_party/twilio-php/Services/Twilio.php');
          $account_sid = 'ACa7cc64d4263494e79217bf0b65427092';
          $auth_token = '262b0bf82523d785055239f9b7c5d252';
          $client = new Services_Twilio($account_sid, $auth_token); //echo  $mobile;
          $message = $client->account->messages->create(array(
          'To' => $mobile,
          'From' => "+18583338842",
          'Body' => $message));
          if ($message->sid != '') {
          return true;
          } else {
          return false;
          }
         */
    }

}

if (!function_exists('send_sms')) {

function send_sms($data) { //mobile and message. 
//echo "working"; die; 
if ($data['c_code'] == +91) {
$mobile = $data['mobile'];
$message = $data['message'];
$curl = curl_init();
$view = curl_setopt_array($curl, array(
CURLOPT_URL => "http://api.msg91.com/api/sendhttp.php?country=91&sender=Anywhereaccounting&route=4&mobiles=$mobile&authkey=266097AYOC5DjXv15c7f7bb6&encrypt=&message=$message",
CURLOPT_RETURNTRANSFER => true,
CURLOPT_ENCODING => "",
CURLOPT_MAXREDIRS => 10,
CURLOPT_TIMEOUT => 30,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
CURLOPT_CUSTOMREQUEST => "GET",
CURLOPT_SSL_VERIFYHOST => 0,
CURLOPT_SSL_VERIFYPEER => 0,
));
$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

if ($err) {
return false;
} else {
return true;
}
} else {
// echo('international');
// $mobile = "+".$data['c_code'] . $data['mobile'];
// $message = $data['message'];
// require_once(APPPATH . 'third_party/twilio-php/Services/Twilio.php');
// $account_sid = 'ACd315d0688552a5827ddc9385f4e5abd9';
// $auth_token = '6d1d9b4b8a0b8371f843b1acf4a978a2';
// $client = new Services_Twilio($account_sid, $auth_token); //echo $mobile;
// $message = $client->account->messages->create(array(
// 'To' => $mobile,
// 'From' => "+18507902596",
// 'Body' => $message));
// if ($message->sid != '') {
// return true;
// } else {
// return false;
// }
}
}

}

if (!function_exists('check_inputs')) {

    function check_inputs() {
        //pre($this->input->post());
        $json = file_get_contents('php://input');
        if ($json) {
            return ((array) json_decode($json));
        } else if ($_POST) {
            //echo'dddd'.pre($_POST);
            return $_POST;
        } else {
            //pre($_POST);
            echo json_encode(array("status" => false, "message" => "Invalid Input", "Result" => array()));
        }
    }

}

if (!function_exists('create_log_file')) {

    function create_log_file($data) { //mobile and message.  
        $log = "Time: " . date('Y-m-d, H:i:s') . PHP_EOL;
        $log = $log . "url: " . base_url($data['url']) . PHP_EOL;
        $log = $log . "Request " . json_encode($data['request']) . PHP_EOL;
        $log = $log . "Responce " . json_encode(array("Result" => $data['response'])) . PHP_EOL . PHP_EOL;
        file_put_contents('logs/' . $data['url'] . '.txt', $log, FILE_APPEND);
    }

}

if (!function_exists('return_data')) {

    function return_data($status = false, $mesage = "", $result = array()) { //mobile and message.         
        echo json_encode(array("status" => $status, "message" => $mesage, "Result" => $result));
        die;
    }

}


if (!function_exists('file_curl_contents')) {

    function file_curl_contents($document) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $document['file_url']);
        curl_setopt($ch, CURLOPT_POST, 1);
        unset($document['file_url']);
        //pre($document); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $document);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        //pre($server_output); 
        curl_close($ch);
        $data = json_decode($server_output, true);
        //pre($data); 
        return $data;
    }

}


if (!function_exists('detect_country')) {

    function detect_country() {
        return "IN";
        $region = "";
        $server_keys = [
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR'
        ];

        foreach ($server_keys as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
                        $region = $ip;
                    }
                }
            }
        }
        $json = file_get_contents('http://ipinfo.io/' . $region);
        $data = json_decode($json);
        return $data->country;
    }

}

if (!function_exists('send_mail')) {

    function send_mail($details) {

        $to_email = $details['mail'];
        $subject = 'Activate Account';
        $message = 'You are successfully registered.. Now you can activate your account ' . $details['link'];
        $headers = 'From: noreply@accounting_anywhere.com';
        mail($to_email, $subject, $message, $headers);
        return true;
    }

}


if (!function_exists('parse_formdata')) {

    function parse_formdata($inputdata) {
        $arr_key = key($inputdata);
        if (!empty($arr_key)) {
            $data = $inputdata[$arr_key];
            $formdata = explode("&", $data);
            foreach ($formdata as $each) {
                $combined = explode("=", $each);
                $inputs[$combined[0]] = str_replace("+", " ", $combined[1]);
                ;
            }
            return $inputs;
        } else {
            return false;
        }
    }

}

if (!function_exists('youtube_id')) {

    function fetch_youtube_id($inputdata) {
        $y_id = "";
        $y_em_url = "";
        $url_parts = parse_url($inputdata);
        if (isset($url_parts['query']) && !empty($url_parts['query'])) {
            $y_em_url = "https://www.youtube.com/embed/";
            parse_str($url_parts['query'], $query);
            $y_id = $query['v'];
        }

        return $youtube_link = $y_em_url . $y_id;
    }

}