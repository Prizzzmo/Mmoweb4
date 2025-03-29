<?php
defined('ROOT_DIR') OR exit('No direct script access allowed');

class Send {
    private static $instance = null;

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function request($method, $data = []) {
        $data['secret_key'] = API_KEY;

        // Локальная обработка запросов
        $api = new Api();
        if(method_exists($api, $method)) {
            return $api->$method($data);
        }

        return ['status' => 'error', 'message' => 'Method not found'];
    }
}

class Api {
    public function sendServer($data) {
        // Implement local processing for sendServer
        return ['status' => 'success', 'data' => $data];
    }

    public function send_curl($data) {
        // Implement local processing for send_curl
        return ['status' => 'success', 'data' => $data];
    }

    public function showSever($data) {
        // Implement local processing for showSever
        return $data;
    }
}


/********************************
 * Dev and Code by MmoWeb
 * Date: 06.10.2015
 ********************************/

class SendOld { //Adding old class to keep original functionality

    private $curl;
    public $url;
    public $key;
    public $debug;
    public $core;
    public $sid_send;
    public $gzcompress = false;

    public function __construct($api_url = null, $api_key = null){
        $this->debug = DEBUG;
        $this->core = &get_instance();
    }

    public function sendServer($Params, $test = false, $msg_time_out = 'echo', $timeout = true){
        // Локальная обработка запросов
        if (!$this->core->session->getSpam() AND $timeout) {
            if($msg_time_out == 'echo') {
                echo $this->core->ajaxmsg->text("Server timeout 2 seconds")->warning();
                exit;
            }elseif($msg_time_out == 'return')
                return array("type"=>"msg","text"=>"Server timeout 2 seconds","status"=>"warning","time"=>2500);
        }

        // Базовые параметры
        $Params['ip'] = ip_address();
        $Params['lang'] = select_lang();
        $Params['pid'] = $this->core->config["global"]["project_id"];
        $Params['user'] = $this->getBrowser();

        if ($this->core->session->isLogin()) {
            $Params['session'] = $this->core->session->get("session_id");
            $Params['sid'] = select_server();
        }

        $this->core->session->addSpam();

        // Здесь можно добавить локальную обработку запросов
        return $this->processLocalRequest($Params);
    }

    private function processLocalRequest($params) {
        // Implement local request processing here
        return array(
            'status' => 'success',
            'data' => $params
        );
    }

    public function getBrowser() {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = 'Unknown';
        $platform = 'Unknown';

        // Platform detection
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'Linux';
        } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'Mac';
        } elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'Windows';
        }

        // Browser detection
        if (preg_match('/MSIE/i',$u_agent)) {
            $bname = 'Internet Explorer';
        } elseif (preg_match('/Firefox/i',$u_agent)) {
            $bname = 'Mozilla Firefox';
        } elseif (preg_match('/Chrome/i',$u_agent)) {
            $bname = 'Google Chrome';
        } elseif (preg_match('/Safari/i',$u_agent)) {
            $bname = 'Apple Safari';
        }

        return array(
            'name' => $bname,
            'platform' => $platform
        );
    }

    public function send_curl( $url, $Params , $debug = false ){

        if( !$this->core->session->getSpam()) {
            echo $this->core->ajaxmsg->text("Server timeout 2 seconds")->warning();
            exit;
        }

        if( $this->core->session->isLogin() )
            $Params = array_merge(array("ip" => ip_address() , "lang" => select_lang() , "session" => $this->core->session->get( "session_id" ) , 'sid' => select_server() , 'secret_key' => $this->core->config["global"]["secret_key"]), $Params);
        else
            $Params = array_merge(array("ip" => ip_address() , "lang" => select_lang(), 'secret_key' => $this->core->config["global"]["secret_key"] ), $Params);

        ksort($Params);

        # Формируем параметры и создаем секретный ключ
        //$Params = array_merge(array("api_key" => hash("sha512", multi_implode("|", $Params) . "|" . $this->key)), $Params);
        //$Params = array("POST" => json_encode($Params));

        $this->core->session->addSpam();
        //Local processing would go here.

        return $this->processLocalRequest($Params);

    }

    public function showSever($Params)
    {

        ksort($Params);

        # Формируем параметры и создаем секретный ключ
        //$Params = array_merge(array("api_key" => hash("sha512", multi_implode("|", $Params) . "|" . $this->key)), $Params);


        echo json_encode($Params);
    }
}