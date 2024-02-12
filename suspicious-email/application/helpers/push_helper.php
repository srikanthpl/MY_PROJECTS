<?php

function sendAndroidPush($deviceToken, $message, $badge = 0, $check = 0, $type = "") {
   //echo $deviceToken; //   die;
    $registrationIDs = array($deviceToken);
    if (is_array($deviceToken)) {
        $registrationIDs = $deviceToken;
    } else {
        $registrationIDs = array($deviceToken);
    }
    $url = 'https://android.googleapis.com/gcm/send';
    $fields = array(
        'registration_ids' => $registrationIDs,
        'data' => array(
            'body' => $message,
            'title' => $message['message']
        ) 
    );

    $headers = array(
        'Authorization: key=AIzaSyB6goYhZpn-lrXHNAFI9EGoO2iqeX_s4YQ',
        'Content-Type: application/json'
    );
    $ch = curl_init();
    //Set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    //Execute post
    $result = curl_exec($ch);
    curl_close($ch);
    //echo $result;
    //pre($fields); die;
    $log = "Time: " . date('Y-m-d, H:i s') . PHP_EOL;
    $log = $log . "Responce " . $result . PHP_EOL . PHP_EOL;
    file_put_contents('logs/push.txt', $log, FILE_APPEND);
}

function sendIphonePush($deviceToken, $msg, $badge = 0, $check = 0, $version = 1) {
    //echo $deviceToken;pre($msg);
    if (!isset($msg['pushMessage'])) {
        $msg['pushMessage'] = "You got a poolingo notification";
    }
    $apnsHost = 'gateway.sandbox.push.apple.com';    //development phase
    //$apnsHost 		= 'gateway.push.apple.com';            //distribution phase
    $apnsPort = '2195';                                //.pem file ko project root per paste karna hai
    $apnsCert = 'ckDev.pem';                            //certificate pem file
    //$apnsCert 	    = 'ckNew.pem';
    $passPhrase = '12345648';                            //cetificate password
    $streamContext = stream_context_create();
    stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);
    $apnsConnection = stream_socket_client('ssl://' . $apnsHost . ':' . $apnsPort, $error, $errorString, 60, STREAM_CLIENT_CONNECT, $streamContext);
    if ($apnsConnection == false) {
        return;
    } else {
        
    }
    $message = json_encode($msg);
    $payload['aps'] = array(
        'alert' => array(
            'body' => $msg['pushMessage'],
            'action-loc-key' => 'Pooligos',
        ),
        'json' => $msg,
        'badge' => 1,
        'sound' => 'oven.caf',
    );

    $payload = json_encode($payload);
    try {
        if ($message != "") {
            $apnsMessage = chr(0) . pack("n", 32) . pack('H*', str_replace(' ', '', $deviceToken)) . pack("n", strlen($payload)) . $payload;
            $fwrite = fwrite($apnsConnection, $apnsMessage);
            //if ($fwrite) {} else { }
        }
    } catch (Exception $e) {
        
    }
}

function generatePush($deviceType, $deviceToken, $message) {

    if ($deviceType == '1') {

        sendAndroidPush($deviceToken, $message);
    } else if ($deviceType == '2') {

        sendIphonePush($deviceToken, $message);
    } else {

        /*
         * do nothing
         */
    }
}

function sendIphonePushld($deviceToken, $msg, $badge = 0, $check = 0, $version = "") {

    //echo $deviceToken;  die;                              //Noted by vivek
    //$apnsHost = 'gateway.sandbox.push.apple.com';	   //development phase
    $apnsHost = 'gateway.push.apple.com';            //distribution phase
    $apnsPort = '2195';                                //.pem file ko project root per paste karna hai
    $apnsCert = 'ck.pem';                            //certificate pem file
    //$apnsCert = 'ck1.pem';
    $passPhrase = '123456789';                            //cetificate password
    $streamContext = stream_context_create();
    stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);
    $apnsConnection = stream_socket_client('ssl://' . $apnsHost . ':' . $apnsPort, $error, $errorString, 60, STREAM_CLIENT_CONNECT, $streamContext);
    if ($apnsConnection == false) {
        //echo "Failed to connect {$error} {$errorString}\n";
        //print "Failed to connect {$error} {$errorString}\n";
        //error_log($error.chr(13), 3, "/mnt/srv/MOOVWORKER/push-errors.log");
        return;
    } else {
        ///echo "Connection successful";	
        //error_log('Connection successful', 3, "/mnt/srv/MOOVWORKER/push-errors.log");
    }
    $message = $msg;

    //$payload['aps'] = array('alert' => $message, 'sound' => 'default','challengeId'=>$badge,'pushType'=>$check);
    /* $payload['aps'] = array('alert' => $message,
      'sound' => 'default',
      'badge' => 1,
      'bundleVersion' => $version
      );
     */

    $payload['aps'] = array(
        'alert' => array(
            'body' => 'Notification from Kwikard',
            'action-loc-key' => 'Kwikard',
        ),
        'json' => $message,
        'badge' => 1,
        'sound' => 'oven.caf',
    );

    $payload = json_encode($payload);
    //print_r($payload);
    //$deviceToken = "dfe587d02a99d57fa7d785c1901409d408dfa920fa90890fbe3fed1fc090c7ee";
    //$deviceToken = $deviceToken;//"dfe587d02a99d57fa7d785c1901409d408dfa920fa90890fbe3fed1fc090c7ee";

    try {

        if ($message != "") {
            //echo $deviceToken;
            //echo $message;
            //$apnsMessage = chr(0) . pack("n", 32) . pack('H*', str_replace(' ', '', $deviceToken)) . pack("n", strlen($payload)) . $payload;
            $apnsMessage = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
            $fwrite = fwrite($apnsConnection, $apnsMessage);
            if ($fwrite) {
                //echo "true";
                //error_log($fwrite.chr(13), 3, "/mnt/srv/MOOVWORKER/push-errors.log");
            } else {
                //echo "false";
            }
        }
    } catch (Exception $e) {
        file_put_contents('logs/push-errors.txt', $e, FILE_APPEND);
        //echo 'Caught exception: '.  $e->getMessage(). "\n";
        //error_log($e->getMessage().chr(13), 3, "/mnt/srv/MOOVWORKER/push-errors.log");
    }
}

function sendDriverPush($deviceToken, $msg) {
    //echo $deviceToken;
    //$apnsHost = 'gateway.sandbox.push.apple.com';	
    $apnsHost = 'gateway.push.apple.com';
    $apnsPort = '2195';
    $apnsCert = 'driver_dis.pem';
    $passPhrase = '';
    $streamContext = stream_context_create();
    stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);
    $apnsConnection = stream_socket_client('ssl://' . $apnsHost . ':' . $apnsPort, $error, $errorString, 60, STREAM_CLIENT_CONNECT, $streamContext);
    if ($apnsConnection == false) {
        //echo "Failed to connect {$error} {$errorString}\n";
        //print "Failed to connect {$error} {$errorString}\n";
        error_log($error . chr(13), 3, "/mnt/srv/MOOVWORKER/push-errors.log");
        return;
    } else {
        //	echo "Connection successful";	
        error_log('Connection successful', 3, "/mnt/srv/MOOVWORKER/push-errors.log");
    }
    $message = $msg;
    $payload['aps'] = array('alert' => $message, 'sound' => 'default');
    $payload = json_encode($payload);
    //$deviceToken = "dfe587d02a99d57fa7d785c1901409d408dfa920fa90890fbe3fed1fc090c7ee";
    //$deviceToken = $deviceToken;//"dfe587d02a99d57fa7d785c1901409d408dfa920fa90890fbe3fed1fc090c7ee";

    try {

        if ($message != "") {
            //echo $deviceToken;
            //echo $message;
            $apnsMessage = chr(0) . pack("n", 32) . pack('H*', str_replace(' ', '', $deviceToken)) . pack("n", strlen($payload)) . $payload;
            $fwrite = fwrite($apnsConnection, $apnsMessage);
            if ($fwrite) {
                //echo "true";
                error_log($fwrite . chr(13), 3, "/mnt/srv/MOOVWORKER/push-errors.log");
            } else {
                //echo "false";
            }
        }
    } catch (Exception $e) {
        //echo 'Caught exception: '.  $e->getMessage(). "\n";
        error_log($e->getMessage() . chr(13), 3, "/mnt/srv/MOOVWORKER/push-errors.log");
    }
}

?>
