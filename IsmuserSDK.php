<?PHP
require_once 'API_Config.php';
require_once 'IsmuserRoom.php';

class IsmuserException extends Exception { };
class AuthException extends IsmuserException { };
class RequestException extends IsmuserException { };

class IsmuserSDK {

    private $api_key;
    private $api_secret;
    private $server_url;

    public function __construct($api_key = API_Config::API_KEY, $api_secret = API_Config::API_SECRET) {
        $this->api_key = $api_key;
        $this->api_secret = $api_secret;
        $this->server_url= API_Config::API_SERVER;
    }
    
    public function createRoom($location='', $properties=array()) {
        $properties["location"] = $location;
        $properties["api_key"] = $this->api_key;

        $createRoomResult = $this->_do_request("/room/create", $properties);

        return new IsmuserRoom($createRoomResult);
    }

    protected function _do_request($url, $data) {
        $url = $this->server_url . $url;

        $dataString = "";
        foreach($data as $key => $value){
            $value = urlencode($value);
            $dataString .= "$key=$value&";
        }

        $dataString = rtrim($dataString,"&");
        $authString = "ism_sdk_auth: $this->api_key:$this->api_secret";

        //Use file_get_contents if curl is not available for PHP
        if(function_exists("curl_init")) {            
            $ch = curl_init();

            $api_key = $this->api_key;
            $api_secret = $this->api_secret;

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, Array('Content-type: application/x-www-form-urlencoded'));
            curl_setopt($ch, CURLOPT_HTTPHEADER, Array($authString));   
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

            $res = curl_exec($ch);
            if(curl_errno($ch)) {
                throw new RequestException('Request error: ' . curl_error($ch));
            }

            curl_close($ch);
        }
        else {        
            if (function_exists("file_get_contents")) {
                $context_source = array ('http' => array (
                                        'method' => 'POST',
                                        'header'=> Array("Content-type: application/x-www-form-urlencoded", $authString, "Content-Length: " . strlen($dataString), 'content' => $dataString)
                                        )
                                    );
                $context = stream_context_create($context_source);
                $res = @file_get_contents( $url ,false, $context);                
            }
            else{
                throw new RequestException("Your PHP installion neither supports the file_get_contents method nor cURL. Please enable one of these functions so that you can make API calls.");
            }        
        }        
        return $res;
    }
    
}
