<?php
	ob_start(); 
	require_once("Nocell.Rest.inc.php");	
	function checkEmail($email)
		{
			$result = TRUE;
			if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email))
			{
				$result = FALSE;
			}
			return $result;
		}

	class API extends NOCELLREST {
	
		public $data = "";
		
		const DB_SERVER = "localhost";
		const DB_USER = "50_nocell";
		const DB_PASSWORD = "nocell1245";
		const DB = "50_nocell";
		
		private $db = NULL;
	
		public function __construct(){
			parent::__construct();				// Init parent contructor
			$this->dbConnect();					// Initiate Database connection
		}
		
		/*
		 *  Database connection 
		*/
		private function dbConnect(){
			$this->db = mysql_connect(self::DB_SERVER,self::DB_USER,self::DB_PASSWORD);
			if($this->db)
				mysql_select_db(self::DB,$this->db);
		}
		
		/*
		 * Public method for access api.
		 * This method dynmically call the method based on the query string
		 *
		 */
		public function processApi(){
			$func = strtolower(trim(str_replace("/","",$_REQUEST['rquest'])));
			
			if((int)method_exists($this,$func) > 0)
			{
			
				$this->$func();
				}
				
			else
			{
				$this->api_response('',404);				// If the method not exist with in this class, api_response would be "Page not found".
				}
		}
		
		
		public function checkEmail($email)
		{
			$result = TRUE;
			if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email))
			{
				$result = FALSE;
			}
			return $result;
		}
				

		
		
		
		/* 
		 *	Log  API
		 *  mid : <Member ID>
		 *  logtype : <Log Type>
		 *  fromloguser : <From Log User>
		 *  logdt : <Lod Date>
		 *  API URL  : http://nocell.be/masteradmin/api/loginsert/
		 */
		
		private function loginsert()
		{
			$arr = array();
			
			$mid = $_REQUEST['mid'];	
			if($mid=="")
			{
				array_push($arr,"Please Enter Member ID.");
			}
			$logtype = $_REQUEST['logtype'];	
			if($logtype=="")
			{
				array_push($arr,"Please Enter Log Type.");
			}
			$fromloguser = $_REQUEST['fromloguser'];	
			if($fromloguser=="")
			{
				array_push($arr,"Please Enter From Log User.");
			}
			$logdt = $_REQUEST['logdt'];	
			if($logdt=="")
			{
				array_push($arr,"Please Enter Log Date.");
			}
			$error = array("status" => "false", "msg" => "Message delivery failed...");
			
			if(count($arr)==0)
			{
					
				$insert_sql = "insert into tbl_logs (mid, logtype, fromloguser, logdt) values ('".$mid."', '".$logtype."', '".$fromloguser."', '".$logdt."')";
				$sql = mysql_query($insert_sql, $this->db);
				$insert_id=mysql_insert_id();
								
				$sql_res = mysql_query("SELECT * FROM tbl_logs WHERE lid = '$insert_id'", $this->db);
				$result_res = mysql_fetch_array($sql_res,MYSQL_ASSOC);	
				$res[]=$result_res;
				// If success everythig is good send header as "OK" and user details	
				$success = array("status" => "true", "items" => $res);
					
				//$success = array("status" => "Success", "msg" => "Passenger Registered Successfully.");
				$this->api_response($this->json($success), 200);								
				exit;
			}
			else
			{
				for ($i=0;$i<count($arr);$i++)
				{
					$msg .= $arr[$i]."<br>";
				}				
				// If invalid inputs "Bad Request" status message and reason
				$error = array("status" => "false", "msg" => $msg );
				$this->api_response($this->json($error), 400);
				exit;
			}
		}


		/* 
		 *	Preferances  API
		 *  mid : <Member ID>
		 *  lid : <Log ID>
		 *  logtype : <Log Type>
		 *  responsetext : <Response Text>
		 *  preferancedt : <Preferance Date>
		 *  API URL  : http://nocell.be/masteradmin/api/preferancesinsert/
		 */
		
		private function preferancesinsert()
		{
			$arr = array();
			
			$mid = $_REQUEST['mid'];	
			if($mid=="")
			{
				array_push($arr,"Please Enter Member ID.");
			}
			$lid = $_REQUEST['lid'];	
			if($lid=="")
			{
				array_push($arr,"Please Enter Log ID.");
			}
			$logtype = $_REQUEST['logtype'];	
			if($logtype=="")
			{
				array_push($arr,"Please Enter Log Type.");
			}
			$responsetext = $_REQUEST['responsetext'];	
			if($responsetext=="")
			{
				array_push($arr,"Please Enter Response Text.");
			}
			$preferancedt = $_REQUEST['preferancedt'];	
			if($preferancedt=="")
			{
				array_push($arr,"Please Enter Preferance Date.");
			}
			$error = array("status" => "false", "msg" => "Message delivery failed...");
			
			// Input validations
			if(count($arr)==0)
			{
					
				$insert_sql = "insert into tbl_preferances (mid, lid, logtype, responsetext, preferancedt) values ('".$mid."', '".$lid."', '".$logtype."', '".$responsetext."', '".$preferancedt."')";
				$sql = mysql_query($insert_sql, $this->db);
				$insert_id=mysql_insert_id();
								
				$sql_res = mysql_query("SELECT * FROM tbl_preferances WHERE pid = '$insert_id'", $this->db);
				$result_res = mysql_fetch_array($sql_res,MYSQL_ASSOC);	
				$res[]=$result_res;
				// If success everythig is good send header as "OK" and user details	
				$success = array("status" => "true", "items" => $res);
					
				//$success = array("status" => "Success", "msg" => "Passenger Registered Successfully.");
				$this->api_response($this->json($success), 200);								
				exit;
			}
			else
			{
				for ($i=0;$i<count($arr);$i++)
				{
					$msg .= $arr[$i]."<br>";
				}				
				// If invalid inputs "Bad Request" status message and reason
				$error = array("status" => "false", "msg" => $msg );
				$this->api_response($this->json($error), 400);
				exit;
			}
		}


		/* 
		 *	Preferances  API
		 *	pid : <Preferance ID>
		 *  mid : <Member ID>
		 *  lid : <Log ID>
		 *  logtype : <Log Type>
		 *  responsetext : <Response Text>
		 *  preferancedt : <Preferance Date>
		 *  API URL  : http://nocell.be/masteradmin/api/preferancesupdate/
		 */
		
		private function preferancesupdate()
		{
			$arr = array();
			$pid = $_REQUEST['pid'];	
			if($pid=="")
			{
				array_push($arr,"Please Enter Preferance ID.");
			}
			$mid = $_REQUEST['mid'];	
			if($mid=="")
			{
				array_push($arr,"Please Enter Member ID.");
			}
			$lid = $_REQUEST['lid'];	
			if($lid=="")
			{
				array_push($arr,"Please Enter Log ID.");
			}
			$logtype = $_REQUEST['logtype'];	
			if($logtype=="")
			{
				array_push($arr,"Please Enter Log Type.");
			}
			$responsetext = $_REQUEST['responsetext'];	
			if($responsetext=="")
			{
				array_push($arr,"Please Enter Response Text.");
			}
			$preferancedt = $_REQUEST['preferancedt'];	
			if($preferancedt=="")
			{
				array_push($arr,"Please Enter Preferance Date.");
			}
			$error = array("status" => "false", "msg" => "Message delivery failed...");
			
			// Input validations
			if(count($arr)==0)
			{
				$update_sql = "update tbl_preferances set mid='".$mid."',  lid='".$lid."', logtype='".$logtype."', responsetext='".$responsetext."', preferancedt='".$preferancedt."' where pid='".$pid."'";
				
				$sql = mysql_query($update_sql, $this->db);
				
								
				$sql_res = mysql_query("SELECT * FROM tbl_preferances WHERE pid = '$pid'", $this->db);
				$result_res = mysql_fetch_array($sql_res,MYSQL_ASSOC);	
				$res[]=$result_res;
				// If success everythig is good send header as "OK" and user details	
				$success = array("status" => "true", "items" => $res);
					
				//$success = array("status" => "Success", "msg" => "Passenger Registered Successfully.");
				$this->api_response($this->json($success), 200);								
				exit;
			}
			else
			{
				for ($i=0;$i<count($arr);$i++)
				{
					$msg .= $arr[$i]."<br>";
				}				
				// If invalid inputs "Bad Request" status message and reason
				$error = array("status" => "false", "msg" => $msg );
				$this->api_response($this->json($error), 400);
				exit;
			}
		}

		/* 
		 *	Login  API
		 *  emailid : <Emailid>
		 *  password : <Password>
		 *  API URL  : http://nocell.be/masteradmin/api/loginnocell/
		 */
		
		private function loginnocell()
		{
			$arr = array();
			
			$uname = $_REQUEST['emailid'];	
			if($uname=="")
			{
				array_push($arr,"Please Enter Username.");
			}
			$pwd = $_REQUEST['password'];	
			if($pwd=="")
			{
				array_push($arr,"Please Enter Password.");
			}
			
			$error = array("status" => "false", "msg" => "Message delivery failed...");
			
			// Input validations
			if(count($arr)==0)
			{
				$qsql = mysql_query("select * from tbl_member_master where emailid='".$uname."' and password='".$pwd."'");
				
				if (mysql_num_rows($qsql)==1) 
				{
					$result_res_lid = mysql_fetch_array($qsql,MYSQL_ASSOC);
					$res['member'][]=$result_res_lid;
					
					
					$sql_res_pref = mysql_query("SELECT * FROM tbl_preferances WHERE mid = '".$result_res_lid['mid']."'", $this->db);
					
					if (mysql_num_rows($sql_res_pref)>0) 
					{
						$result_res_pref = mysql_fetch_array($sql_res_pref,MYSQL_ASSOC);
						$res['pref'][]=$result_res_pref;
					}
					else
					{
						$res['pref'][]='';
					}
					
					
					
					

					$sql_res_log = mysql_query("SELECT * FROM tbl_logs WHERE mid = '".$result_res_lid['mid']."'", $this->db);
					if (mysql_num_rows($sql_res_log)>0) 
					{
						$result_res_log = mysql_fetch_array($sql_res_log,MYSQL_ASSOC);	
						$res['log'][]=$result_res_log;
					}
					else
					{
						$res['log'][]='';
					}

				
					

					
					$success = array("status" => "true", "msg" => "Loggedin successfully", "items" => $res);
					
					
					$this->api_response($this->json($success), 200);								
					exit;
				}
				else
				{
					array_push($arr,"Incorrect Username and Password.");
				}
				
				for ($i=0;$i<count($arr);$i++)
				{
					$msg .= $arr[$i]."<br>";
				}
				$error = array("status" => "false", "msg" => $msg );
				$this->api_response($this->json($error), 400);
				exit;
			}
			else
			{
				for ($i=0;$i<count($arr);$i++)
				{
					$msg .= $arr[$i]."<br>";
				}				
				// If invalid inputs "Bad Request" status message and reason
				$error = array("status" => "false", "msg" => $msg );
				$this->api_response($this->json($error), 400);
				exit;
			}
		}
		

		/* 
		 *	Registration  API
		 *  fname : <First Name>
		 *  lname : <Last Name>
		 *  dob : <Date of Birth>
		 *  street : <Street>
		 *  near : <Near>
		 *  zipcode : <Zip Code>
		 *  city : <City>
		 *  country : <Country>
		 *  emailid : <Email ID>
		 *  password : <Password>
		 *  mobile : <Mobile>
		 *  mstatus : <Status>
		 *  API URL  : http://nocell.be/masteradmin/api/registrationnocell/
		 */
		
		private function registrationnocell()
		{
			$arr = array();
			//$mob="/^[123456789][0-9]{9}$/";
			
			$fname = $_REQUEST['fname'];
			if($fname=='')
			{
				array_push($arr,"Please Enter First Name");
			}
			$lname = $_REQUEST['lname'];
			if($lname=='')
			{
				array_push($arr,"Please Enter Last Name");
			}
			$dob = $_REQUEST['dob'];
			if($dob=='')
			{
				array_push($arr,"Please Enter Date of Birth");
			}
			$street = $_REQUEST['street'];

			$near = $_REQUEST['near'];

			$zipcode = $_REQUEST['zipcode'];

			$city = $_REQUEST['city'];

			$country = $_REQUEST['country'];
			if($country=='')
			{
				array_push($arr,"Please Select Country");
			}

			$emailid = $_REQUEST['emailid'];
			if($emailid=='')
			{
				array_push($arr,"Please Enter Emailid");
			}
			
			if (!checkEmail($emailid))
			{
				array_push($arr,"Enter Valid Email Address");
			}

			$password = $_REQUEST['password'];
			if($password=='')
			{
				array_push($arr,"Please Enter Password");
			}
			else
			{
				if (strlen($password) < '10') 
				{
					array_push($arr,"Your Password Must Contain At Least 10 Characters, 1 Number, 1 Capital Letter, 1 Lowercase Letter!");
				}
				elseif(!preg_match("#[0-9]+#",$password)) 
				{
					array_push($arr,"Your Password Must Contain At Least 10 Characters, 1 Number, 1 Capital Letter, 1 Lowercase Letter!");
				}
				elseif(!preg_match("#[A-Z]+#",$password)) 
				{
					array_push($arr,"Your Password Must Contain At Least 10 Characters, 1 Number, 1 Capital Letter, 1 Lowercase Letter!");
				}
				elseif(!preg_match("#[a-z]+#",$password)) 
				{
					array_push($arr,"Your Password Must Contain At Least 10 Characters, 1 Number, 1 Capital Letter, 1 Lowercase Letter!");
				}
			}
			$mobile = $_REQUEST['mobile'];
			if($mobile=='')
			{
				array_push($arr,"Please Enter Mobile");
			}
			//else
			//{
				//if(!preg_match($mob, $mobile))
				//{ 
					//array_push($arr,"check your Mobile number");
				//}
			//}
	
			$status = $_REQUEST['mstatus'];
			
			
			$uniqueuserquery=mysql_query("select emailid from tbl_member_master where emailid='$emailid'");
			if(mysql_num_rows($uniqueuserquery)>0)
			{
				array_push($arr,"Email Already Exists");
			}

			
			$error = array("status" => "false", "msg" => "Message delivery failed...");
			
			// Input validations
			if(count($arr)==0)
			{
				$is_delete=0;
				$newdob = date("Y-m-d", strtotime($dob));
				mysql_query("insert into tbl_member_master (fname, lname, dob, street, nr, zipcode, city, country, emailid, password, mobno, deviceid, downloadst, activatedt, deactivatedt, isactive, isdelete) values ('".$fname."','".$lname."','".$newdob."','".$street."','".$near."','".$zipcode."','".$city."','".$country."','".$emailid."','".$password."','".$mobile."','','','','','".$status."','".$is_delete."')");
				
				$success = array("status" => "true", "msg" => "Registration Done Successfully");
				$this->api_response($this->json($success), 200);								
				exit;
			}
			else
			{
				for ($i=0;$i<count($arr);$i++)
				{
					$msg .= $arr[$i]."<br>";
				}				
				// If invalid inputs "Bad Request" status message and reason
				$error = array("status" => "false", "msg" => $msg );
				$this->api_response($this->json($error), 400);
				exit;
			}
		}
		
		
		/* 
		 *	Emergency  API
		 *  mid : <Member ID>
		 *  mobno : <Mobile No>
		 *  API URL  : http://nocell.be/masteradmin/api/addemgno/
		 */
		
		private function addemgno()
		{
			$arr = array();
			
			$mid = $_REQUEST['mid'];	
			if($mid=="")
			{
				array_push($arr,"Please Enter Member ID.");
			}
			$mobno = $_REQUEST['mobno'];	
			if($mobno=="")
			{
				array_push($arr,"Please Enter Mobile no.");
			}
			$error = array("status" => "false", "msg" => "Message delivery failed...");
			
			// Input validations
			if(count($arr)==0)
			{
					
				$insert_sql = "insert into tbl_emergency (mid, mobno) values ('".$mid."', '".$mobno."')";
				$sql = mysql_query($insert_sql, $this->db);
				$insert_id=mysql_insert_id();
								
				$sql_res = mysql_query("SELECT * FROM tbl_emergency WHERE eid = '$insert_id'", $this->db);
				$result_res = mysql_fetch_array($sql_res,MYSQL_ASSOC);	
				$res[]=$result_res;
				// If success everythig is good send header as "OK" and user details	
				$success = array("status" => "true", "items" => $res);
					
				//$success = array("status" => "Success", "msg" => "Passenger Registered Successfully.");
				$this->api_response($this->json($success), 200);								
				exit;
			}
			else
			{
				for ($i=0;$i<count($arr);$i++)
				{
					$msg .= $arr[$i]."<br>";
				}				
				// If invalid inputs "Bad Request" status message and reason
				$error = array("status" => "false", "msg" => $msg );
				$this->api_response($this->json($error), 400);
				exit;
			}
		}
		
		/* 
		 *	Emergency  API
		 *  mid : <Member ID>
		 *  API URL  : http://nocell.be/masteradmin/api/getemgnos/
		 */
		
		private function getemgnos()
		{
			$arr = array();
			
			$mid = $_REQUEST['mid'];	
			if($mid=="")
			{
				array_push($arr,"Please Enter Member ID.");
			}
			$error = array("status" => "false", "msg" => "Message delivery failed...");
			
			// Input validations
			if(count($arr)==0)
			{
					
				$fetch_sql = "select mobno from tbl_emergency where mid='".$mid."'";
				$sql = mysql_query($fetch_sql, $this->db);
				while($result_res = mysql_fetch_array($sql,MYSQL_ASSOC))
				{				
					$res[]=$result_res;
				}
				// If success everythig is good send header as "OK" and user details	
				$success = array("status" => "true", "items" => $res);
					
				//$success = array("status" => "Success", "msg" => "Passenger Registered Successfully.");
				$this->api_response($this->json($success), 200);								
				exit;
			}
			else
			{
				for ($i=0;$i<count($arr);$i++)
				{
					$msg .= $arr[$i]."<br>";
				}				
				// If invalid inputs "Bad Request" status message and reason
				$error = array("status" => "false", "msg" => $msg );
				$this->api_response($this->json($error), 400);
				exit;
			}
		}
		
		
		/*
		 *	Encode array into JSON
		*/
		private function json($data){
			if(is_array($data)){
				return json_encode($data);
			}
		}
		

	}	
	$api = new API;
	$api->processApi();
?>