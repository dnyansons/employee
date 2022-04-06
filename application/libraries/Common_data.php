<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Common_data {

    private $CI;
    public function __construct() {
        $this->CI = get_instance();
        $this->CI->load->model('Common_model');
        $this->CI->load->library('email');
    }

    function get_notification_data(){
        $this->CI->db->select('title,message,created_at');
        $this->CI->db->from('notification');
        $this->CI->db->where('status','Unread');
        $this->CI->db->where('notification_to','admin');
        $this->CI->db->order_by('noti_id','desc');
        $this->CI->db->limit(5);

        return $this->CI->db->get()->result();
    }

    function get_inplay_score($event_id=0){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.b365api.com/v2/events/upcoming?sport_id=3&token=".BETS_API_KEY);
        curl_setopt($ch, CURLOPT_URL, "https://api.b365api.com/v1/event/view?token=".BETS_API_KEY."&event_id=".$event_id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        $response = json_decode(curl_exec($ch), TRUE);
        curl_close($ch);

        $res_data = $response['results'];
        if(isset($res_data)){

            if ($res_data['time_status'] == 1) {
                $up['m_status'] = 'Active';

                if($res_data['ss']!=''){
                    $score=$res_data['ss'];
                    $split=explode(',',$score);
                    if(isset($split[0])){
                        $up['home_score']=$split[0];
                    }
                    if(isset($split[1])){
                        $up['away_score']=$split[1];
                    }
                }elseif($res_data['time_status'] == 3){
                    $up['m_status'] = 'End';
                }
            }
            if(isset($up)){
             $this->CI->Common_model->update('market', $up, array('match_id' => $event_id));

         }


     }

 }


 function email_template($to,$message)
 {
    $data['title']='Betting07 Email Verification';
    $data['message']=$message;
    $config = array(
        'protocol'  => 'smtp',
        'smtp_host' => 'ssl://smtp.googlemail.com',
        'smtp_port' => 465,
        'smtp_user' => 'support@betting07.com',
        'smtp_pass' => 'asdfghjklQWE123@',
        'mailtype'  => 'html',
        'charset'   => 'utf-8',
        'crlf' => "\r\n",
        'newline' => "\r\n"
    );

    $this->CI->email->initialize($config);
    $this->CI->email->set_mailtype("html");
    $this->CI->email->set_newline("\r\n");
    $this->CI->email->to($to);
    $this->CI->email->from($this->CI->config->item("default_email_from"), "Betting07");
    $this->CI->email->subject('Email For Password Verification');
    $body = $this->CI->load->view('front/emailtemplates/verify_email',$data,TRUE);
    $this->CI->email->message($body);
    if ($this->CI->email->send()) {
        return true;
    } else {
        return false;
    }
}

function send_sms($mob,$message){

    if(strlen($mob)==10){
        $msg =urlencode($message);
        $url = "http://45.114.143.11/api.php?username=minazcri&password=744754&sender=SBUZZL&sendto=".$mob."&message=".$msg."&PEID=1201161580730507147";
        //file_get_contents($url);
        // $url = "http://sms.smslab.in/api/sendhttp.php?authkey=351399ACOxIQH35ff89c05P1&sender=SPORTB&route=4&mobiles=91".$mob."&message=".$msg;
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
        $contents = curl_exec($ch);
        if (curl_errno($ch)) {

        } else {
          curl_close($ch);
          $msg = 'success';
          return $msg;
      }    
  }
  return 1;

}

function send_sms_all($mob,$message){


    $msg =urlencode($message);
    $url = "http://45.114.143.11/api.php?username=minazcri&password=744754&sender=playce&sendto=".$mob."&message=".$msg;
        //$dat=file_get_contents($url);

    $ch = curl_init();
    curl_setopt ($ch, CURLOPT_URL, $url);
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
    $contents = curl_exec($ch);
    if (curl_errno($ch)) {

    } else {
      curl_close($ch);
  }    

  return $dat;

}


function sendallnew($title,$message,$firebaseid)
{
        //SERVER KEY TOOK FROM FIREBASE CONSOLE
    $server_key = "AAAAY6TkvwA:APA91bEm5ICex4oIGuUgiLXm_oy0KjO-qhKSqCdcoxA3jCkw1PHVxOh7sGrl2TQRKHtjYwIqp49_-LKsKvP4WRurkPbdKayNO4xsFItQd5NG4JR6s0AwzoCtvsQXiY-fuxaESfaHSBWg";
        //FIREBASE URL
    $url = "https://fcm.googleapis.com/fcm/send";
        //DEVICE ID
    $headers = array('Content-Type: application/json','Authorization: key=' . $server_key);
    $fields = array('registration_ids' =>$firebaseid,'data' => array('title'=>$title,"body"=>$message));
    $payload = json_encode($fields);
        // Open connection
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    $result = curl_exec($ch);
    if ($result === FALSE){ die('Curl failed: ' . curl_error($ch)); }
        // Close connection
    curl_close($ch);
    return $result;
}

function sendallnewWeb($title,$message,$firebaseid)
{
        //SERVER KEY TOOK FROM FIREBASE CONSOLE
    $server_key = "AAAAD7pYnZA:APA91bFy3L2Dgl8c9Wg2Fy3u1QCsI6KrRYSOj8jLCAHzZUQceQhxsgS1ij7LORe4j259NmWfQA9ejoIYBtoqq0SJfMvMS2UU2PPOVGOosoqYKfcrf6BDVlRa4SyoTFsyDcBdz6NwCBuB";
        //FIREBASE URL
    $url = "https://fcm.googleapis.com/fcm/send";
        //DEVICE ID
    $headers = array('Content-Type: application/json','Authorization: key=' . $server_key);
    $fields = array('registration_ids' =>$firebaseid,'data' => array('title'=>$title,"body"=>$message));
    $payload = json_encode($fields);
        // Open connection
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    $result = curl_exec($ch);
    if ($result === FALSE){ die('Curl failed: ' . curl_error($ch)); }
        // Close connection
    curl_close($ch);
    return $result;
}

function send($title,$message,$firebaseid)
{
        //SERVER KEY TOOK FROM FIREBASE CONSOLE
    $server_key = "AAAAY6TkvwA:APA91bEm5ICex4oIGuUgiLXm_oy0KjO-qhKSqCdcoxA3jCkw1PHVxOh7sGrl2TQRKHtjYwIqp49_-LKsKvP4WRurkPbdKayNO4xsFItQd5NG4JR6s0AwzoCtvsQXiY-fuxaESfaHSBWg";
        //FIREBASE URL
    $url = "https://fcm.googleapis.com/fcm/send";
        //DEVICE ID
    $headers = array('Content-Type: application/json','Authorization: key=' . $server_key);
    $fields = array('to' => $firebaseid,'data' => array('title'=>$title,"body"=>$message));
    $payload = json_encode($fields);
        // Open connection
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    $result = curl_exec($ch);
    if ($result === FALSE){ die('Curl failed: ' . curl_error($ch)); }
        // Close connection
    curl_close($ch);
    return $result;
}

}
