<?php

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

if (!function_exists('send_mail_smtp')) {

    function send_mail_smtp($details) {
        //pre($details['message']);die;
        $ci = get_instance();
        $ci->load->library('email');
        $config['protocol'] = "smtp";
        //$config['smtp_host'] = "ssl://smtp.gmail.com";
        $config['smtp_host'] = "ssl://smtpout.secureserver.net";
        $config['smtp_port'] = "465";
        $config['smtp_user'] = "admin@anywhereadvisory.com";
        $config['smtp_pass'] = "India@1947";
        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";

        $ci->email->initialize($config);

        $ci->email->from('admin@anywhereadvisory.com', 'Sender');
        if (!is_array($details['to_mail'])) {
            $list = array($details['to_mail']);
        }else{
            $list = $details['to_mail'];
        }
        $ci->email->to($list);
        $ci->email->reply_to('admin@anywhereadvisory.com', 'Sender reply');
        $ci->email->subject($details['subject']);
        $ci->email->message($details['message']);
        $ci->email->send();
    }

}
