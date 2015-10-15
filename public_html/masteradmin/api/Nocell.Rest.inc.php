<?php
	/* File : Nocell.Rest.inc.php
	 * Author : CSS
	*/
	class NOCELLREST {
		
		public $_allow = array();
		public $_content_type = "application/json";
		public $_request = array();
		
		private $_method = "";		
		private $_code = 200;
		
		public function __construct(){
			$this->apiinputs();
		}
		
		public function get_api_referer(){
			return $_SERVER['HTTP_REFERER'];
		}
		
		public function api_response($data,$status){
			$this->_code = ($status)?$status:200;
			
			$this->set_api_headers();
			echo $data;
			exit;
		}
		
		private function get_api_status_message(){
			$status = array(
						100 => 'Continue',  
						101 => 'Switching Protocols',  
						200 => 'OK',
						201 => 'Created',  
						202 => 'Accepted',  
						203 => 'Non-Authoritative Information',  
						204 => 'No Content',  
						205 => 'Reset Content',  
						206 => 'Partial Content',  
						300 => 'Multiple Choices',  
						301 => 'Moved Permanently',  
						302 => 'Found',  
						303 => 'See Other',  
						304 => 'Not Modified',  
						305 => 'Use Proxy',  
						306 => '(Unused)',  
						307 => 'Temporary Redirect',  
						400 => 'Bad Request',  
						401 => 'Unauthorized',  
						402 => 'Payment Required',  
						403 => 'Forbidden',  
						404 => 'Not Found',  
						405 => 'Method Not Allowed',  
						406 => 'Not Acceptable',  
						407 => 'Proxy Authentication Required',  
						408 => 'Request Timeout',  
						409 => 'Conflict',  
						410 => 'Gone',  
						411 => 'Length Required',  
						412 => 'Precondition Failed',  
						413 => 'Request Entity Too Large',  
						414 => 'Request-URI Too Long',  
						415 => 'Unsupported Media Type',  
						416 => 'Requested Range Not Satisfiable',  
						417 => 'Expectation Failed',  
						500 => 'Internal Server Error',  
						501 => 'Not Implemented',  
						502 => 'Bad Gateway',  
						503 => 'Service Unavailable',  
						504 => 'Gateway Timeout',  
						505 => 'HTTP Version Not Supported');
			return ($status[$this->_code])?$status[$this->_code]:$status[500];
		}
		
		public function get_api_request_method(){
			return $_SERVER['REQUEST_METHOD'];
		}
		
		private function apiinputs(){
			switch($this->get_api_request_method()){
				case "POST":
					$this->_request = $this->cleanApiInputs($_POST);
					break;
				case "GET":
				case "DELETE":
					$this->_request = $this->cleanApiInputs($_GET);
					break;
				case "PUT":
					parse_str(file_get_contents("php://input"),$this->_request);
					$this->_request = $this->cleanApiInputs($this->_request);
					break;
				default:
					$this->api_response('',406);
					break;
			}
		}		
		
		private function cleanApiInputs($data){
			$clean_input = array();
			if(is_array($data)){
				foreach($data as $k => $v){
					$clean_input[$k] = $this->cleanApiInputs($v);
				}
			}else{
				if(get_magic_quotes_gpc()){
					$data = trim(stripslashes($data));
				}
				$data = strip_tags($data);
				$clean_input = trim($data);
			}
			return $clean_input;
		}		
		
		private function set_api_headers(){
		//echo "AAA".$this->get_api_status_message();
			header("HTTP/1.1 ".$this->_code." ".$this->get_api_status_message());
			header("Content-Type:".$this->_content_type);
		}
	}	
?>