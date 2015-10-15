<?php
ini_set('display_errors',0);
chdir(dirname(__FILE__));
include_once 'lib.php';
include_once 'db_connect.php';
class User{
	//class variables
	var $user_id = null;
	var $org_id = null;
    	var $org_id_str = null;
	var $user_type = null;
	var $ua = null; //user agent
	var $ua_long = null; // full user agent string
	var $remote_ip = null;
	var $error = null;
	var $error_code = null;
	var $user_profile = null;
	var $app_config = null;
	var $timezone_offset = null;
    	var $pu; // patient user object

    public function __construct($user_id=null){
        $this->user_id = $user_id;
		if(!empty($user_id)){
			$this->user_type = $this->getUserType();
			//$this->user_profile = $this->getUserDetails($user_id);
			$this->_setUserProfile();
		
		}
		//some initialization stuff here
		$this->app_config = getConfig();
		//$this->setTimezoneOffset();
    }

	function __call($functionName, $argumentsArray ){
		$log = debug_backtrace();
		$this->setError('undefined_function');
	}
	/* set user's timezone offset
	*/

	function setTimezoneOffset($offset=null){
		if(!empty($offset)){
			$this->timezone_offset = $offset;
		}
		else if(!empty($_SESSION['timezone_offset'])){
			$this->timezone_offset = $_SESSION['timezone_offset'];
		}
		else{
			// don't set any offset 
			// default is server time
		}
	}
	/* set session timeout error for mobile client */
	function sessionTimeoutError(){
		echo "<ResponseHeader>
		<ResponseCode>1000</ResponseCode>
		<ResponseMessage>Session timeout</ResponseMessage>
		</ResponseHeader>";
		session_destroy();
		exit;
	}

// get config version used by a device
/*
function setError() 
	assign error to the class variable $error.
*/
    function setError($error){
            $this->error = $error;
    }

/* 
	The following function sets the error_code
*/
	function setErrorCode($error_code){
		$this->error_code = $error_code;
	}


/*
function getError() 
	return true if class varible has some error value else return false. 
*/
	function hasError(){
		if(empty($this->error)){
			return false;
		}
		return true;
	}

public	function authenticate($username, $password){
		global $pdo;
	try{
		$select = $pdo->prepare("SELECT id FROM users WHERE username = ? AND Password = ? AND status = 1");
		$select->execute(array($username, md5($password)));
	}
	catch(PDOException $e){
		$this->setError($e->getMessage());
		return false;
	}
	$row = $select->fetch(PDO::FETCH_ASSOC);
	if($row['id']){
		$this->user_id = $row['id'];
		$this->user_type = $this->getUserType();
		return true;
	}
	$this->setError("Invalid username or password.");
	return false;
	}


/*
	Get user id from username
*/
public function getUserIdFromEmail($email){
	global $pdo;
	try{
	$select = $pdo->prepare("SELECT id FROM users WHERE email = ?");
	$select->execute(array($email));
	}
	catch(PDOException $e){
	$this->setError($e->getMessage());
	return false;
	}
	$row = $select->fetch(PDO::FETCH_ASSOC);
	return $row['id'];
}

/*
Log authentication attempts
*/
public function logAuthenticationAttempt($data){
	global $pdo;
	try{
	$insert = $pdo->prepare("INSERT INTO `authentication_log`
		(`user_id`, `result`, `attempted`)
		VALUES(?, ?, NOW())");
	$insert->execute(array($data['user_id'], $data['result']));
	}
	catch(PDOException $e){
		$this->setError($e->getMessage());
		return false;
	}
	return true;
	
}


/* function logout
	added for activity logging purpose
*/
	function logout(){
		$action_details=array();
		$action_details['table_name']='users';
		$action_details['row_id']=$this->user_id;
		$action_details['operation']='Logged Out';
		$this->createActionLog($action_details);
		//$_SESSION['user_id'] = null;
		return true;
	}

/*
function authenticateMD5() 
	function written for authentication of mobile device users.
OBSOLETE NOW
NOT TO BE USED
*/
public function authenticateDevice($username, $password, $app_token=null){
		if(($this->ua == 'mobile') && (!$this->isValidToken($app_token))){
			$this->setError('invalid_app_token');
			return false;
		}
        global $pdo;
	if($this->authenticate($username, $password)){
	//update device determined by app_token
		if($this->ua == 'mobile')
		$this->updateMyDevice($app_token);

		$this->user_type = $this->getUserType();
		$this->_setUserProfile();

		$log = debug_backtrace();
		$this->createActionLog($log);
            return true;
        }
        else{
            $this->setError("auth_failure");
            return false;
        }
}

	function _setUserProfile(){
		$this->user_profile = $this->getUserDetails($this->user_id);
	}

/*
function isAdmin() 
	return true if logged in user type is Admin other wise return false with error message.
*/
	function isAdmin(){
		if($this->user_type == 'Admin'){
			return true;
		}
		return false;
	}
/* Added by Rupali*/
function isSpecial(){
		if($this->user_type == 'Special'){
			return true;
		}
		return false;
	}
/*
    Check if the logged-in user is SuperAdmin
*/

public function isSuperAdmin(){
    if($this->user_type == 'SuperAdmin'){
        return true;
    }
    return false;
}


/*
function getUserType() 
	return user type of logged in user.
*/
	function getUserType(){
		$select = "SELECT user_types.type FROM user_types 
			LEFT JOIN users ON user_types.id = users.type
			WHERE users.id = $this->user_id";

        global $pdo;
        $stmt = $pdo->query($select);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row['type'];
	}

/*
function _loginRedirect() 
	function redirect user to the index page. 
*/
    function _loginRedirect(){
        	// send user to the login page
        	header("Location:/index.php");
    }
    
/*
function getUserDetails($user_id) 
	function accept the user id as parameter and return the users details of that user id. 
*/
    function getUserDetails($user_id){
	
		$select = "SELECT users.*, user_types.type as user_type, users.type as type_id from users 
			LEFT JOIN user_types ON user_types.id = users.type
			WHERE users.id = ?";
        global $pdo;
		$stmt = $pdo->prepare($select);
		$stmt->execute(array($user_id));
		$result_array = $stmt->fetch(PDO::FETCH_ASSOC);
		return $result_array;
	}
	

/*
function getUsers($user_type) 
	function accept the user type as parameter and return the all user details of that user type. 
*/
         function getUsers($user_type){
            global $pdo;
			$select = $pdo->prepare("SELECT * ,users.id AS userId 
            FROM users 
			LEFT JOIN user_types ON users.user_type = user_types.id
			WHERE user_types.type = ?");
			//$res = mysql_query($select);
            $select->execute(array($user_type));
		    return $select->fetchAll(PDO::FETCH_ASSOC);
		}

/*
function updateUser($data) 
	function accept the data array as parameter and update user info.
	return true if user info is updated successfully else return false with error message. 
*/
	function updateUser($data){
                global $pdo;
	//	$b_date = date("Y-m-d", strtotime($data['birth_date']));
		try {
		if($data['password']!=''){
		$pwd= md5($data['password']);
		$update = $pdo->prepare("UPDATE users 
                SET `first_name`= ?,`last_name`=?,`email`= ?, `password`= ?, 
                    `mobile`= ?,  `correspondence_address`=?, `user_type`= ?, `city`= ? ,
		     `state`=?, `other_contact_no`=?,`pin_code`=?,`delivery_address`=?,
			`delivery_city`=?, `delivery_state`=?, `delivery_pin_code`=?,`status`=?,
			`office_name`=?,`prefered_payment_method`=?,`lunch_slot`=?,`special_diet`=?,
			`special_dietary_requirements`=?,`birth_date`=?, `name_title` = ?
                    WHERE id= ?");
                $update->execute(array($data['first_name'],$data['last_name'], $data['email'], $pwd, 
                $data['mobile'], $data['address'],$data['user_type'], $data['city'], $data['state'],
		$data['other_contact'],$data['pin'],$data['delivery_address'], $data['delivery_city'],
		$data['delivery_state'],$data['delivery_pin'], $data['sts'],$data['office_name'],
		$data['prefered_payment_method'],$data['lunch_slot'],$data['special_diet'],
		$data['special_dietary_requirements'],$b_date,$data['name_title'],$data['user_id']));

                //update the password log

                }else{
		$update = $pdo->prepare("UPDATE users 
                SET `first_name`= ?,`last_name`=?,`email`= ?,  
                    `mobile`= ?,  `correspondence_address`=?, `user_type`= ?, `city`= ? ,
		     `state`=?, `other_contact_no`=?,`pin_code`=?,`delivery_address`=?,
			`delivery_city`=?, `delivery_state`=?, `delivery_pin_code`=?,`status`=?,
			`office_name`=?,`prefered_payment_method`=?,`lunch_slot`=?,`special_diet`=?,
                        `special_dietary_requirements`=?,`birth_date`=?	, `name_title` = ?
                    WHERE id= ?");
                $update->execute(array($data['first_name'],$data['last_name'], $data['email'], 
                $data['mobile'], $data['address'],$data['user_type'], $data['city'], $data['state'],
		$data['other_contact'],$data['pin'],$data['delivery_address'], $data['delivery_city'],
		$data['delivery_state'],$data['delivery_pin'], $data['sts'],$data['office_name'],
                $data['prefered_payment_method'],$data['lunch_slot'],$data['special_diet'],
                $data['special_dietary_requirements'],$b_date,$data['name_title'], $data['user_id']));
                }
             }
        catch(PDOException $e){
            // check if username already exists in the system
            $this->setError($e->getCode());
	}
		return true;
	}
	
/*
function updateMyProfile($data) 
	function accept the data array as parameter and update the logged in user information
	with data in parameter array and return true if update user information successfully else return false with error message. 
*/
		function updateMyProfile($data){
        global $pdo;
		$update = $pdo->prepare("UPDATE users SET `email`= ? WHERE id= ?");
        $update->execute(array($data['email'], $this->user_id));
		$preparedProfileParam = prepareProfileParams($data);
		updateProfileParameters($this->user_id,$preparedProfileParam);
		$log = debug_backtrace();
		$this->createActionLog($log);
		return true;
	}

/*
function resetPassword($username,$userEmail)
	function accept three parameters username password and email address
	and reset the user password and return true after successfully password reset other wise retun false 
	with error message.
*/
public function resetPassword($userEmail){
    global $pdo;
    $code = generatePassword(64);
	$select = $pdo->prepare("SELECT * FROM users 
        WHERE email = ?");
    $select->execute(array($userEmail));
    $row = $select->fetch(PDO::FETCH_ASSOC);
		if(count($row)!= 0){
		   $update=$pdo->prepare("UPDATE users 
                   SET `password`=?  
                   WHERE  email = ?");
        	        if($update->execute(array(md5($code),  $userEmail))){
                        $userid = $this->getUserIdFromEmail($userEmail);
                        $user_details = $this->getUserDetails($userid);
                        $data = array(
                                'email'=>$userName,
                                'pwd'=>$code,
                                'name'=> $user_details['first_name'],
                                'last_name'=> $user_details['last_name']
                            );
		
			$body ="<html><body>Dear ".$data['name']." ".$data['last_name']."<br><br>";
			$body .="Please login in to simplynutrilicious.co.uk with new password given below <br>";
			$body .= $code ."<br>";
			$body .="<br><img src=\"http://simplynutrilicious.co.uk/images/footer_logo.png\"><br><br>
Email:info@simplynutrilicious.co.uk<br>
Telephone:07414629159<br></body></html>";
			sendmail($userEmail, 'Simply Nutrilicious : -New password ', $body,0);
               	        return true;
	                }else{
                        $this->setError($update);
               	         return false;
	                }
		 }# if of not empty array check
	         else{
        	       $this->setError("reset_password_error");
                       return false;
	        }
    }

/*
	To enforce stronger passwords, we use this function
	isPasswordStrong($password)
*/

	function isPasswordStrong($password){
		if(strlen($password) < 8)
		return false;
		if(!preg_match("#[0-9]+#",$password))
		return false;
		if(!preg_match("#[A-Z]+#",$password))
		return false;
		if(!preg_match("#[a-z]+#",$password))
		return false;
		if(!preg_match("#[\W_]+#",$password))
		return false;

		return true;
	}



	function createActionLog($details){
            global $pdo;
		$insert = "INSERT INTO action_log 
				(`table_name`,`row_id`,`operation`,`created_on`,`created_by`)
				VALUES(?,?,?,NOW(),?)";
		$insert_args = array($details['table_name'],$details['row_id'],$details['operation'],$this->user_id);
        try{
		    $stmt=$pdo->prepare($insert);		
		    $stmt->execute($insert_args);
        }
        catch(PDOException $e){
				$this->setError($e->getMessage());
				return false;
			}	
			return true;
	}

	// auxiliary function
// return user's local time
function getUserLocalTime($datetime, $format='M d g:i a'){
    $server_dt = new DateTime($datetime, new DateTimeZone($this->app_config['server_timezone_offset']));
	// if timezone is not set
	// return server time
	if(empty($this->timezone_offset)){
		$local_dt_string = $server_dt->format($format);
		return $local_dt_string;
	}

	// example value ot $this->timezone_offset
    //$this->timezone_offset = '+0800';
    $user_offset = $this->timezone_offset;

    $offset_hr = intval($user_offset/100);
    $offset_min = $user_offset%100;
    $offset_sec = $offset_hr * 3600 + $offset_min * 60;

    //get offset
    $gmt_offset = $server_dt->getOffset();
    //modify time to first get GMT
    $server_dt->modify("-$gmt_offset second");

    // now modify time again to get local time 

    $server_dt->modify("$offset_sec second");

    //formatted string
    $local_dt_string = $server_dt->format($format);
    return $local_dt_string;
}

function getAllUsers(){
	/*$app_config = $this->app_config;
        $per_page = empty($details['limit']) ? $app_config['per_page'] : $details['limit'];
        $offset = !empty($details['offset']) ? $details['offset'] : ($details['p']-1)*$per_page;*/
	$select = "SELECT * ,users.id as user_id, user_types.type AS utype, status_master.status as sts FROM users 
		LEFT JOIN user_types ON user_types.id=users.user_type  
		LEFT JOIN status_master ON users.status=status_master.id
		ORDER BY users.id ASC";
		//LIMIT $offset, $per_page";
		global $pdo;
		$res = $pdo->query($select);
		return $res->fetchAll(PDO::FETCH_ASSOC);
}


function getStatusMasters(){
	$select = "SELECT * FROM status_master";
                global $pdo;
                $res = $pdo->query($select);
                return $res->fetchAll(PDO::FETCH_ASSOC);
}
function getUserTypes(){
	$select = "SELECT * ,user_types.id as type_id, user_types.type AS user_type FROM user_types";
                global $pdo;
                $res = $pdo->query($select);
                return $res->fetchAll(PDO::FETCH_ASSOC);
}

/* function get get send notification time and autounlock time depending on severity of case */ 
	function getTimer(){
        global $pdo;
		$select = $pdo->prepare("SELECT * FROM manage_timers");
		if(!($res = $select->execute())){
			$this->setError($select);
			return false;
		}
		$time_config = array();
		while($row = $select->fetch(PDO::FETCH_ASSOC)){
			$time_config[$row['urgency']] = $row;
		}
		return $time_config;
	}

function sendTemplateEmail($to,$subject_path,$body_path,$template_vars){
//$app_config = getConfig();
$app_config = $this->app_config;
$email_from_address='no-reply@aad.org';
//include 'config.php';
$subject_path = $app_config['document_root']."/../".$subject_path;
$body_path = $app_config['document_root']."/../".$body_path;
//$headers = "From:$email_from_address\n";
$headers = "From:$email_from_address\n";
$email_subject_body = getEmailTemplateBody($subject_path);
$email_template_body = getEmailTemplateBody($body_path);
$email_body = $this->getEmailBody($email_template_body,$template_vars);
$email_subject = $this->getEmailBody($email_subject_body,$template_vars);
$this->sendSMTPEmail($to, $email_subject, $email_body);
}

public function getEmailBody($template_body,$arr_of_variable){
$body = $template_body;
//$subdomain = $this->getMySubdomain().'.'.$this->app_config['http_host'];
#$http_host = empty($_SERVER['HTTP_HOST'] || preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z/', $_SERVER['HTTP_HOST']))?$subdomain:$_SERVER['HTTP_HOST'];
//$http_host = !empty($this->getMySubdomain())?$subdomain:$_SERVER['HTTP_HOST'];

foreach($arr_of_variable as $k => $v){
        $pattern[$k]="/\[\[$k\]\]/";
        $replacement[$k] = str_replace('$', '\$', $v);
        $body = preg_replace($pattern,$replacement,$body);
}
$pattern= '/\[\[server\]\]/';
$body = preg_replace($pattern,$http_host,$body);
return $body;
}


/*
Inform user that their password has been updated
*/
public function notifyPasswordUpdate($data){
	$this->sendTemplateEmail($data['email'], $this->app_config['password_reset_notification_subject'], $this->app_config['password_reset_notification_body'], $data);
}


function getMemberTypes(){
	$select = "SELECT * FROM membership";
	global $pdo;
	$res = $pdo->query($select);
	return $res->fetchAll(PDO::FETCH_ASSOC);
}


function UserCount(){
	$select = "SELECT count(*) AS cnt FROM users where user_type!=1";
                global $pdo;
                $res = $pdo->query($select);
                $row = $res->fetch(PDO::FETCH_ASSOC);
                return $row['cnt'];
}
function getCategoryDetails($id){
	$select = "SELECT * FROM categories WHERE id=$id";
                global $pdo;
                $res = $pdo->query($select);
                $row = $res->fetch(PDO::FETCH_ASSOC);
                return $row;
}
public function addUser($data){

	//$b_date = date("d-m-Y", strtotime($data['birth_date']));
	//	$b_date = date("Y-m-d", strtotime($data['birth_date']));
	$pwd= md5($data['password']);
//	$data['special_diet']='';
		global $pdo;
        try{
	$stmt = "INSERT INTO users
            (`name_title`,`first_name`,`last_name`, `email`, `password`,`mobile`,`address_1`,`city`,`state`, `country`, `delivery_address`,`delivery_city`,`delivery_state`,`delivery_country`,`user_type`,`delivery_contact`,`created_date`)
            VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,2,?,NOW())";
	    $stmt = $pdo->prepare($stmt);
            $stmt->execute(array($data['title'],$data['fname'],$data['lname'],$data['cemail'],$pwd,$data['contact'],$data['address1'],$data['city'],$data['state'],
	    $data['country'],$data['saddress1'],$data['scity'],$data['sstate'],$data['scountry'],$data['scontact']));
        }
	
        catch(PDOException $e){
            // check if username already exists in the system
            //$this->setError($e->getCode());
            if($e->getCode() == 23000){
		//echo "BAC error is=".$e->getMessage();
                $this->setError('User Already registered with us try different Email');
            }
            else{
		echo "error is=".$e->getMessage();
                $this->setError($e->getMessage());
                //$this->setError('user_not_created');
            }
            return false;
        }
	return true;
}

function updateShoppingCart($get, $details){
	$item_id = $details['code']?$details['code']:$get['code'];
	if($details['type'] =='meal'){
		$cart_key = 'meal';
	}
	if($details['type'] == 'lunch'){
		$cart_key = 'lunch';
	}
	if($details['type'] == 'munch'){
		$cart_key = 'munch';
	}
	if($details['type'] == 'recipe'){
		$cart_key = $details['type'].''.$item_id;
	}
	switch($get["action"]) {
	case "add":
		$date = date('Ymd',strtotime($details['date']));
		if(!empty($details["quantity"])) {
			if($details['type'] =='meal'){
				$itemArray = array("$cart_key" => array( $date =>
					array('name'=>'Meal', 'code'=>'meal', 'quantity'=> $details["quantity"], 'base_price'=>$details['base_price'], 'discount'=>$details['discount'], 'price'=>$details['base_price'] - $details['discount'], 'date' => $details['date'], 'type'=> $details['type'])));
			}

			if($details['type']=='lunch'){
				$itemArray = array("$cart_key" => array ( $date =>
					array('name'=>'Lunch', 'code'=>'lunch', 'quantity'=> $details["quantity"], 'base_price'=>$details['base_price'], 'discount'=>$details['discount'], 'price'=>$details['base_price'] - $details['discount'], 'date' => $details['date'], 'type'=> $details['type'])));
			}

			if($details['type']=='munch'){
				$itemArray = array("$cart_key" => array ( $date =>
					array('name'=>'Munch', 'code'=>'munch', 'quantity'=> $details["quantity"], 'base_price'=>$details['base_price'], 'discount'=>$details['discount'], 'price'=>$details['base_price'] - $details['discount'], 'date' => $details['date'], 'type' => $details['type'])));
			}

			if($details['type']=='recipe'){
				$recipe = $this->getRecipeDetails($item_id);
				$itemArray = array("$cart_key" => array( $date => 
					array('name'=>$recipe["rec_name"], 'code'=>$recipe["rec_id"], 
					'quantity'=> $details["quantity"],'base_price'=> $recipe['base_price'], 'discount'=> $recipe['discount'], 'price'=>$recipe["base_price"] - $recipe['discount'], 'date' => $details['date'], 'type' => $details['type'],'available_qnt' => $details['available_qnt'])));
			}
		if(!empty($_SESSION["cart_item"])) {
			if(in_array($cart_key,array_keys($_SESSION["cart_item"]))) {
				foreach($_SESSION["cart_item"] as $key => $value) {
				if($cart_key == $key){
					foreach($value as $k => $v){
						if(in_array($date,array_keys($value))){
							$_SESSION["cart_item"][$key][$date]["quantity"] = $details["quantity"];
							$_SESSION["cart_item"][$key][$date]["available_qnt"] = $details["available_qnt"];
						}else{
							$_SESSION["cart_item"][$key][$date] = $itemArray[$key][$date];
						}
					}
				}
				}
			} else {
				$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
			}
		} else {
			$_SESSION["cart_item"] = $itemArray;
		}
		}
	break;
	case "remove":
		if(!empty($_SESSION["cart_item"])) {
			if(in_array($item_id,array('meal','lunch','munch'))){
				$cart_key = $item_id;
			}else{
				$cart_key = 'recipe'.$item_id;
			}
			$date = date('Ymd',strtotime($get['date']));
			foreach($_SESSION["cart_item"] as $key => $value){
				if($cart_key == $key){
					foreach($value as $k => $v){
						if($k == $date){
							unset($_SESSION["cart_item"][$key][$k]);
						if(empty($_SESSION['cart_item'][$key])){
							unset($_SESSION["cart_item"][$key]);
						}
						}
					}
				}
				if(empty($_SESSION["cart_item"])){
					unset($_SESSION["cart_item"]);
				}
			}
		}
	break;
	case "empty":
		unset($_SESSION["cart_item"]);
		break;
	}
}

function addOrder($details){
	global $pdo;
	$coupon_code ='';
	$coupon_amount = 0;
	if(isset($_SESSION["coupon_code"])){
		$coupon_code = $_SESSION["coupon_code"];
		$coupon_amount = $_SESSION["coup_disc"];
	}
	try{
		$stmt = "INSERT INTO orders(`user_id`,`customer_name`,`customer_email`,`customer_contact`,
			`order_date`,`delivery_address`,`delivery_city`,`delivery_state`,`delivery_pin_code`,
			`total_amount`,`discount`,`final_amount`,`status`,`special_notes`,`payment_method`,`discount_coupon`,`coupons_discount`,`delivery_type`)
			VALUES (?, ?, ?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?)";
		$stmt = $pdo->prepare($stmt);
		$stmt->execute(array($this->user_id, $details['name'], $details['email'], $details['contact'], 
		$details['delivery_address'], $details['delivery_city'], $details['delivery_state'], 
		$details['delivery_pin'],$details['base_price'], $details['discount'], $details['final_amount'], 
		'0', $details['special_notes'], $details['payment_method'],$coupon_code,$coupon_amount,$_POST['delivery_type']));

	}
        catch(PDOException $e){
                $this->setError($e->getMessage());
            	return false;
        }
	$order_id = $pdo->lastInsertId();
	return $order_id;
}

function addOrderDetails($order_id,$cart_items){
	global $pdo;
	try{
		$stmt = "INSERT INTO order_details(`order_id`,`delivery_date`,`recipe_ids`,
			`status`,`delivery_status`,`meal_qnt`,
			`lunch_box_qnt`,`munch_box_qnt`)
			VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt = $pdo->prepare($stmt);
		foreach($cart_items as $date => $item){
			$recipe_ids = rtrim($item['recipe_ids'],',');
		$stmt->execute(
			array($order_id,$item['delivery_date'], $recipe_ids, $item['status'],$item['delivery_status'],
			$item['meal_qnt'], $item['lunch_box_qnt'], $item['munch_box_qnt'])
		);
		}
	}
        catch(PDOException $e){
                $this->setError($e->getMessage());
            	return false;
        }
	return true;
}


function addOrderBasics($order_details){
	global $pdo;
	try{
		$stmt = "INSERT INTO orders(`user_id`,`order_date`,`status`,
			`delivery_status`,`discount`,`type`,`payment_method`,`payable_amount`)
			VALUES (?, NOW(), ?, ?, ?, ?,?,?)";
		$stmt = $pdo->prepare($stmt);
		$stmt->execute(
			array($order_details['user_id'],'Pending','Pending',$order_details['discount'],$order_details['type'],$order_details['payment_method'],$order_details['payable_amount'])
		);
		$order_id=$pdo->lastInsertId('id');
	}
        catch(PDOException $e){
                $this->setError($e->getMessage());
            	return false;
        }
	return $order_id;
}
function addOrderDetailsByUser($cart_items,$order_id,$currency){
	global $pdo;
	try{
		$stmt = "INSERT INTO order_details(`order_id`,`website_name`,`product_name`,
			`product_code`,`url`,`size`,
			`color`,`quantity`,`price`,`currency`)
			VALUES (?, ?, ?, ?, ?, ?, ?, ?,?,?)";
		$stmt = $pdo->prepare($stmt);
		$stmt->execute(
			array($order_id,$cart_items['product_website'], $cart_items['product_name'],$cart_items['product_code'],$cart_items['product_link'], $cart_items['product_size'], $cart_items['product_color'],$cart_items['product_quantity'],$cart_items['product_price'],$currency)
		);
		$order_id=$pdo->lastInsertId('id');
	}
        catch(PDOException $e){
                $this->setError($e->getMessage());
            	return false;
        }
	return $order_id;
}

function addOrderDetailsByUserCOD($cart_items){
	global $pdo;
	try{
		$stmt = "INSERT INTO orders(`user_id`,`website_name`,`product_name`,
			`product_code`,`url`,`size`,
			`color`,`quantity`,`price`,`status`,`payment_status`,`delivery_status`)
			VALUES (?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?)";
		$stmt = $pdo->prepare($stmt);
		$stmt->execute(
			array($cart_items['user_id'],$cart_items['product_website'], $cart_items['product_name'],$cart_items['product_code'],$cart_items['product_link'], $cart_items['product_size'], $cart_items['product_color'],$cart_items['product_quantity'],$cart_items['product_price'],'Pending','cashOnDeliver','Pending')
		);
	}
        catch(PDOException $e){
                $this->setError($e->getMessage());
            	return false;
        }
	return true;
}

function addOrderDetailsByUserInterswitch($cart_items){
	global $pdo;
	try{
		$stmt = "INSERT INTO orders(`user_id`,`website_name`,`product_name`,
			`product_code`,`url`,`size`,
			`color`,`quantity`,`price`,`status`,`payment_status`,`delivery_status`)
			VALUES (?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?)";
		$stmt = $pdo->prepare($stmt);
		$stmt->execute(
			array($cart_items['user_id'],$cart_items['product_website'], $cart_items['product_name'],$cart_items['product_code'],$cart_items['product_link'], $cart_items['product_size'], $cart_items['product_color'],$cart_items['product_quantity'],$cart_items['product_price'],'Pending','Pending','Pending')
		);
	}
        catch(PDOException $e){
                $this->setError($e->getMessage());
            	return false;
        }
	return true;
}





function payForOrderId($order_id){
	global $pdo;
	$order = $this->getOrderFromId($order_id);
	if($order['payment_method']=='Wallet'){
		return $this->payFromWallet($order);
	}
        if($order['payment_method']=='COD'){
                return $this->payWithCOD($order);
        }
        if($order['payment_method']=='COC'){
                return $this->payWithCOD($order);
        }
        if($order['payment_method']=='CC'){
                return $this->payWithCC($order);
        }
}

function getOrderFromId($order_id){
	global $pdo;
	$select = "SELECT * FROM orders WHERE id= $order_id";
		$res = $pdo->query($select);
		$order = $res->fetch(PDO::FETCH_ASSOC);
	return $order;
}


function generateBillDetails($order_id,$status='Pending',$paid_date=null,$transaction_id=null){
	global $pdo;
	try{
	$insert = "INSERT INTO bill_details (`order_id`,`paid_date`,`transaction_id`,`status`)
		VALUES(?, ?, ?, ?)";
		$stmt = $pdo->prepare($insert);
		$stmt->execute(array($order_id,$paid_date,$transaction_id,$status));
	}
        catch(PDOException $e){
                $this->setError($e->getMessage());
                return false;
        }
	return true;
}

function payFromWallet($order){
	global $pdo;
	$this->_setUserProfile();
	if($order['final_amount'] <= $this->user_profile['balance']){
	try{
	$remaining_balance = $this->user_profile['balance'] - $order['final_amount']; 
	$update = $pdo->prepare("UPDATE users SET `balance`= ? WHERE id= ?");
        $update->execute(array($remaining_balance, $this->user_id));
	$this->_setUserProfile();
	}catch(PDOException $e){
                $this->setError($e->getMessage());
                return false;
        }
		$this->generateBillDetails($order['id'],'Paid',$order['order_date']);
		return true;
	}else{
                $this->setError("Wallet does not have sufficient balance.");
                return false;
	}
}

function payWithCOD($order){
        return $this->generateBillDetails($order['id'],'Pending',$order['order_date']);
}

function payWithCC($order){
                //$this->setError('CC payment is not working yet.');
        	$this->generateBillDetails($order['id'],'Pending',$order['order_date']);
		$_SESSION['order_id'] = $order['id'];
                $_SESSION['final_amount'] = $order['final_amount'];
                header('Location:/confirm_order.php');
                exit;

//                return false;
}

function getOrderDetails($order_id){
        global $pdo;
        $select = "SELECT order_details.* FROM orders 
                        LEFT JOIN order_details ON order_details.order_id = orders.id 
                        WHERE orders.id= ?";
        try{
        $stmt = $pdo->prepare($select);
        $stmt->execute(array($order_id));
        $result_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result_array;
        }
        catch(PDOException $e){
                $this->setError($e->getMessage());
                return false;
        }
}

function getBillDetailsFromOrderId($order_id){
        global $pdo;
        $select = "SELECT bill_details.* FROM orders 
                        LEFT JOIN bill_details ON bill_details.order_id = orders.id 
                        WHERE orders.id= ?";
        try{
        $stmt = $pdo->prepare($select);
        $stmt->execute(array($order_id));
        $result_array = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result_array;
        }
        catch(PDOException $e){
                $this->setError($e->getMessage());
                return false;
        }
}

function getOrdersforDelivery($date){
        global $pdo;
        $select = "select *, orders.total_amount as amount, orders.discount as disc, orders.final_amount as pay_amt,
		bill_details.status as payment_status from orders left join order_details on orders.id=order_details.order_id 
	left join bill_details on orders.id=bill_details.order_id where date(delivery_date)=?";
        try{
        $stmt = $pdo->prepare($select);
        $stmt->execute(array($date));
        $result_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result_array;
        }
        catch(PDOException $e){
                $this->setError($e->getMessage());
                return false;
        }
}
function getDeliveryDetails($id){
        global $pdo;
        $select = "SELECT *, orders.id as id, orders.total_amount as total_amount, 
		orders.final_amount as final_amount, orders.discount as discount  FROM orders 
                        LEFT JOIN order_details ON order_details.order_id = orders.id 
                        WHERE order_details.id= ?";
        try{
        $stmt = $pdo->prepare($select);
        $stmt->execute(array($id));
        $result_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result_array;
        }
        catch(PDOException $e){
                $this->setError($e->getMessage());
                return false;
        }
}
function getDeliveryStatus(){
        global $pdo;
        $select = "SELECT * from delivery_status"; 
        try{
        $stmt = $pdo->prepare($select);
        $stmt->execute();
        $result_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result_array;
        }
        catch(PDOException $e){
                $this->setError($e->getMessage());
                return false;
        }
}
function updatePaymentStatus($status,$id){
        global $pdo;
	try{
	$update = $pdo->prepare("UPDATE bill_details SET `status`= ? , paid_date = NOW() WHERE id= ?");
        $update->execute(array($status, $id));
	}catch(PDOException $e){
                $this->setError($e->getMessage());
                return false;
        }
		return true;
}
function updateDeliveryStatus($status,$id){
        global $pdo;
	try{
	$update = $pdo->prepare("UPDATE order_details SET `delivery_status`= ? WHERE id= ?");
        $update->execute(array($status, $id));
	}catch(PDOException $e){
                $this->setError($e->getMessage());
                return false;
        }
		return true;
}

function getMyOrders(){
        global $pdo;
        $select = "select *, orders.total_amount as amount, orders.discount as disc,orders.id as order_id, 
		orders.final_amount as pay_amt,date(order_date) as order_date,
		bill_details.status as payment_status from orders 
	left join bill_details on orders.id=bill_details.order_id where orders.user_id= $this->user_id";
        try{
        $stmt = $pdo->prepare($select);
        $stmt->execute(array($date));
        $result_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result_array;
        }
        catch(PDOException $e){
                $this->setError($e->getMessage());
                return false;
        }
}

function getAllDeliveryStatusById(){
	$select = "SELECT * FROM delivery_status";
		global $pdo;
		$res = $pdo->query($select);
		$status = array();
		while($row = $res->fetch(PDO::FETCH_ASSOC)){
			$status[$row['id']] = $row['status'];
		}
		return $status;
}
/*
* get minumum detail of all pending or canceled deliveries
*/
function getMinOrderDetails($id){
        global $pdo;
        $select = "SELECT * FROM order_details  WHERE id= ? AND delivery_status IN (1,4)";
        try{
        $stmt = $pdo->prepare($select);
        $stmt->execute(array($id));
        $result_array = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result_array;
        }
        catch(PDOException $e){
                $this->setError($e->getMessage());
                return false;
        }
}
public function updateUserBalance($amount,$user_id,$operation){
        global $pdo;
        try{
		if($operation ==1){
                	$stmt = "UPDATE users SET `balance`=balance + $amount WHERE `id` = ?";
		}else{
                	$stmt = "UPDATE users SET `balance`=balance - $amount WHERE `id` = ?";
		}
                $stmt = $pdo->prepare($stmt);
                $stmt->execute(array($user_id));
        }catch(PDOException $e){
                $this->setError($e->getMessage());
	 	return false;
        }
	return true;
}

public function getDiscountCoupons($date){
	$select = "SELECT * from coupons_discount WHERE '$date' >=from_date AND '$date'<= to_date ";
		global $pdo;
		$res = $pdo->query($select);
		$status = array();
		$row = $res->fetch(PDO::FETCH_ASSOC);
		return $row;
}
public function changePassword($old_pwd, $new_pwd,$email){
    global $pdo;
	$pwd = md5($old_pwd);	
	$n_pwd = md5($new_pwd);
	$select = $pdo->prepare("SELECT * FROM users 
        WHERE email = ? AND password =?");
    $select->execute(array($email, $pwd));
    $row = $select->fetch(PDO::FETCH_ASSOC);
		if(count($row)!= 0){
		   $update=$pdo->prepare("UPDATE users 
                   SET `password`=?  
                   WHERE  email = ?");
        	        if($update->execute(array($n_pwd,  $email))){
                        $userid = $this->getUserIdFromEmail($email);
                        $user_details = $this->getUserDetails($userid);
                        $data = array(
                                'email'=>$userName,
                                'pwd'=>$n_pwd,
                                'name'=> $user_details['first_name'],
                                'last_name'=> $user_details['last_name']
                            );
		
			$body ="Dear ".$data['name']." ".$data['last_name']."\r\n";
			$body .="Your password has been changed successfully. your new password is  \r\n";
			$body .= $new_pwd;
			sendmail($email, 'Simply Nutrilicious : Password changed.', $body,0);
               	        return true;
	                }else{
                        $this->setError($update);
               	         return false;
	                }
		 }# if of not empty array check
	         else{
        	       $this->setError("You have entered wrong old password");
                       return false;
	        }
    }
public function getDiscountCouponsDetails($id){
	$select = "SELECT * from coupons_discount WHERE id =$id ";
		global $pdo;
		$res = $pdo->query($select);
		$status = array();
		$row = $res->fetch(PDO::FETCH_ASSOC);
		return $row;
}
public function getActiveDiscountCouponsByCode($code){
	$select = "SELECT * from coupons_discount WHERE NOW() >=from_date AND NOW()<= to_date AND code = '$code'";
		global $pdo;
		$res = $pdo->query($select);
		$status = array();
		$row = $res->fetch(PDO::FETCH_ASSOC);
		return $row;
}
public function getAllDiscountCoupons(){
	$select = "SELECT * from coupons_discount ";
		global $pdo;
		$res = $pdo->query($select);
		$status = array();
		$row = $res->fetchAll(PDO::FETCH_ASSOC);
		return $row;
}
function getRecipeDetailsByRecIds($rec_ids){
	$select = "SELECT id,name FROM recipe WHERE id IN ($rec_ids)"; 
		global $pdo;
		$res = $pdo->query($select);
		$tmp_details = array();
		while($row = $res->fetch(PDO::FETCH_ASSOC)){
			$tmp_details[$row['id']] = $row['name'];
		}
		return $tmp_details;
}

function MarkCCOrderPaid($status,$trans_id,$id){
        global $pdo;
	try{
	$update = $pdo->prepare("UPDATE bill_details SET `transaction_id`=?, `status`= ? , paid_date = NOW() WHERE id= ?");
        $update->execute(array($trans_id,$status, $id));
	}catch(PDOException $e){
                $this->setError($e->getMessage());
                return false;
        }
		return true;
}
// get all main categories srbh

function getMainCategories() {

	$select = "SELECT * from categories WHERE priority!=0 ";
                global $pdo;
                $res = $pdo->query($select);
                $status = array();
                $row = $res->fetchAll(PDO::FETCH_ASSOC);
                return $row;

        }

// get category detail by id
function getCategoriesbyId($id){

 $select = "SELECT * from categories WHERE id = '$id'";
                global $pdo;
                $res = $pdo->query($select);
                $status = array();
                $row = $res->fetch(PDO::FETCH_ASSOC);
                return $row;

}

// upload image of category
function uploadimage($company_id,$file,$tmp_filename,$type=0){

    //filename mangling
	 $file = date('U').'_'.$file; 
	$file_location=$_SERVER['DOCUMENT_ROOT']."/../files/company_logos/$company_id/$file"; // create a directory for every user_id
	$resized_img_path=$_SERVER['DOCUMENT_ROOT']."/../files/company_logos/$company_id/th_$file"; // create a directory for every user_id
	$new_size = getNewDimensions($tmp_filename);
//	$this->_createUserFilesFolder($type);
	$this->_createCompanyFilesFolder($company_id);

        // move the file and link it to the artifact
    if(move_uploaded_file($tmp_filename,$file_location)){
    		createthumb($file_location,$resized_img_path,$new_size['new_width'],$new_size['new_height']);
                if($this->addCompanyLogo($company_id,$file,$type)){
                        return true;
                }else{
                        return false;
                }
        }
}


// get 
function getshops() {

        $select = "SELECT * from shops";
                global $pdo;
                $res = $pdo->query($select);
                $status = array();
                $row = $res->fetchAll(PDO::FETCH_ASSOC);
                return $row;

        }
# to get shop by id
function getShopsbyId($id){

 $select = "SELECT * from shops WHERE id = '$id'";
                global $pdo;
                $res = $pdo->query($select);
                $status = array();
                $row = $res->fetch(PDO::FETCH_ASSOC);
                return $row;

}

// manage users
function getUsersAll(){
        
        $select = "SELECT * from users";
               
                global $pdo;
                $res = $pdo->query($select);
                return $res->fetchAll(PDO::FETCH_ASSOC);
}



// get users detail by id
function getUserbyId($id){

 $select = "SELECT * from users WHERE id = '$id'";
                global $pdo;
                $res = $pdo->query($select);
                $status = array();
                $row = $res->fetch(PDO::FETCH_ASSOC);
                return $row;

}

function getSubCat() {

        $select = "SELECT * from categories WHERE parent!=0";
                global $pdo;
                $res = $pdo->query($select);
                $status = array();
                $row = $res->fetchAll(PDO::FETCH_ASSOC);
                return $row;

        }


function getContent() {

        $select = "SELECT * from content";
                global $pdo;
                $res = $pdo->query($select);
                $status = array();
                $row = $res->fetch(PDO::FETCH_ASSOC);
                return $row;

        }

// get content by id
function getContentbyId($id){

 $select = "SELECT * from content WHERE id = '$id'";
                global $pdo;
                $res = $pdo->query($select);
                $status = array();
                $row = $res->fetch(PDO::FETCH_ASSOC);
                return $row;

}

// get banner info
function getbannerinfo() {

        $select = "SELECT * from banner";
                global $pdo;
                $res = $pdo->query($select);
                $status = array();
                $row = $res->fetchAll(PDO::FETCH_ASSOC);
                return $row;

        }


// get banner detail by id
function getBannerbyId($id){

 $select = "SELECT * from banner WHERE id = '$id'";
                global $pdo;
                $res = $pdo->query($select);
                $status = array();
                $row = $res->fetch(PDO::FETCH_ASSOC);
                return $row;

}


// getpromo banner info
function getpromobannerinfo() {

        $select = "SELECT * from promobanner";
                global $pdo;
                $res = $pdo->query($select);
                $status = array();
                $row = $res->fetchAll(PDO::FETCH_ASSOC);
                return $row;

        }

// get banner detail by id
function getPromoBannerbyId($id){

 $select = "SELECT * from promobanner WHERE id = '$id'";
                global $pdo;
                $res = $pdo->query($select);
                $status = array();
                $row = $res->fetch(PDO::FETCH_ASSOC);
                return $row;

}


function getAllShops() {

        $select = "SELECT * from shops";
                global $pdo;
                $res = $pdo->query($select);
                $status = array();
                $row = $res->fetchAll(PDO::FETCH_ASSOC);
                return $row;

        }
// changed for test sub categories
function getParentcategories() {

        $select = "SELECT * from categories where parent =='0'";
                global $pdo;
                $res = $pdo->query($select);
                $status = array();
                $row = $res->fetchAll(PDO::FETCH_ASSOC);
                return $row;

        }

function getShopById($id) {

        $select = "SELECT * from shops WHERE category = '$id'";

                global $pdo;
                $res = $pdo->query($select);
                $status = array();
                $row = $res->fetchAll(PDO::FETCH_ASSOC);
                return $row;

        }


function getCategoriesAll(){

        $select = "SELECT * from categories";

                global $pdo;
                $res = $pdo->query($select);
                return $res->fetchAll(PDO::FETCH_ASSOC);
}

function getPromoBannersAll(){

        $select = "SELECT * from promobanner where isactive='1' ";

                global $pdo;
                $res = $pdo->query($select);
                return $res->fetchAll(PDO::FETCH_ASSOC);
}

function getSimpleBannersAll(){

        $select = "SELECT * from banner where isactive='1'";

                global $pdo;
                $res = $pdo->query($select);
                return $res->fetchAll(PDO::FETCH_ASSOC);
}

function getContentbyTitle(){

 $select = "SELECT * from content WHERE title = 'whyuk2me'";
                global $pdo;
                $res = $pdo->query($select);
                $status = array();
                $row = $res->fetch(PDO::FETCH_ASSOC);
                return $row;

}


function getVideos() {

        $select = "SELECT * from videos where isactive='1'";
                global $pdo;
                $res = $pdo->query($select);
                $status = array();
                $row = $res->fetchAll(PDO::FETCH_ASSOC);
                return $row;

        }



// get video details by id
function getVideobyId($id){

 $select = "SELECT * from videos WHERE id = '$id'";
                global $pdo;
                $res = $pdo->query($select);
                $status = array();
                $row = $res->fetch(PDO::FETCH_ASSOC);
                return $row;

}

function getvideobyTitle(){

 $select = "SELECT * from videos WHERE title = 'title'";
                global $pdo;
                $res = $pdo->query($select);
                $status = array();
                $row = $res->fetch(PDO::FETCH_ASSOC);
                return $row;

}

// get logos info
function getlogosinfo() {

        $select = "SELECT * from logos";
                global $pdo;
                $res = $pdo->query($select);
                $status = array();
                $row = $res->fetchAll(PDO::FETCH_ASSOC);
                return $row;

        }

// get company  logo detail by id
function getLogobyId($id){

 $select = "SELECT * from logos WHERE id = '$id'";
                global $pdo;
                $res = $pdo->query($select);
                $status = array();
                $row = $res->fetch(PDO::FETCH_ASSOC);
                return $row;

}


function getlogos() {

        $select = "SELECT * from logos where isactive='1'";
                global $pdo;
                $res = $pdo->query($select);
                $status = array();
                $row = $res->fetchAll(PDO::FETCH_ASSOC);
                return $row;

        }

function getCategoriesGpParent() {

        $select = "SELECT * from categories where parent !=0";
                global $pdo;
                $res = $pdo->query($select);
                $cat = array();
		while($row = $res->fetch(PDO::FETCH_ASSOC)){
			$cat[$row['parent']][] = $row;
		}
                return $cat;

        }
function getParentsCategories() {
        $select = "SELECT * from categories where parent='0'";
                global $pdo;
                $res = $pdo->query($select);
                $cat = array();
		while($row = $res->fetch(PDO::FETCH_ASSOC)){
			$cat[$row['id']] = $row;
		}
                return $cat;

        }

function getCurrency() {

        $select = "SELECT * from currency";
                global $pdo;
                $res = $pdo->query($select);
                $status = array();
                $row = $res->fetch(PDO::FETCH_ASSOC);
                return $row;

        }

//check user 

        function isUser(){
                if($this->user_type == 'User'){
                        return true;
                }
                return false;
        }



//get all orders
function getAllOrders($date){
        global $pdo;
        $select = "select orders.order_date,orders.payable_amount,orders.status,orders.discount,orders.id as order_id,order_details.price, order_details.quantity,users.first_name as fname,users.last_name as lname,order_details.price as amount
            from orders left join order_details on orders.id=order_details.order_id 
        left join users on orders.user_id=users.id";
        try{
        $stmt = $pdo->prepare($select);
        $stmt->execute(array($date));
	$orders = array();
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		$orders[$row['order_id']][] = $row;
	}
        return $orders;
        }
        catch(PDOException $e){
                $this->setError($e->getMessage());
                return false;
        }
}

// todays sell

function TodaysSell(){
        $select = "select orders.id,orders.order_date,order_details.order_id,SUM(order_details.price) AS cnt FROM orders LEFT JOIN order_details ON orders.id=order_details.order_id where orders.order_date=CURDATE()";
                global $pdo;
                $res = $pdo->query($select);
                $row = $res->fetch(PDO::FETCH_ASSOC);
                return $row['cnt'];
}


function PendingOrders(){
        $select = "SELECT count(*) AS cnt FROM orders where status='Pending'";
                global $pdo;
                $res = $pdo->query($select);
                $row = $res->fetch(PDO::FETCH_ASSOC);
                return $row['cnt'];
}
// COUNT TODAYS DELIVERY
function counttodaysdelivery(){
        $select = "select count(*) AS cnt from orders where delivery_status='delivered' AND order_date=CURDATE()";
                global $pdo;
                $res = $pdo->query($select);
                $row = $res->fetch(PDO::FETCH_ASSOC);
                return $row['cnt'];
}


//get delivery details
function getDeliveryDetailsAll($id){
        global $pdo;
        $select = "SELECT *, orders.id as id,orders.discount as discount,order_details.price FROM orders 
                        LEFT JOIN order_details ON order_details.order_id = orders.id 
                        WHERE order_details.id= ?";
        try{
        $stmt = $pdo->prepare($select);
        $stmt->execute(array($id));
        $result_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result_array;
        }
        catch(PDOException $e){
                $this->setError($e->getMessage());
                return false;
        }
}

function getMyOrdersById(){
        global $pdo;
        $select = "select *,orders.discount as disc,orders.id as order_id,date(order_date) as order_date,bill_details.status as payment_status from orders left join bill_details on orders.id=bill_details.order_id where orders.user_id=$this->user_id";
        try{
        $stmt = $pdo->prepare($select);
        $stmt->execute(array($date));
        $result_array = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result_array;
        }
        catch(PDOException $e){
                $this->setError($e->getMessage());
                return false;
        }
}


function getActiveCategories() {
        $select = "SELECT * from categories WHERE is_active =1 AND is_deleted=0";

                global $pdo;
                $res = $pdo->query($select);
                $cat = array();
		$cat =$res->fetchAll(PDO::FETCH_ASSOC);
		return $cat;

        }
function getSubCategories() {
        $select = "SELECT * from sub_categories ";

                global $pdo;
                $res = $pdo->query($select);
                $cat = array();
		$cat =$res->fetchAll(PDO::FETCH_ASSOC);
		return $cat;

        }
function getCategories() {
        $select = "SELECT * from categories ";

                global $pdo;
                $res = $pdo->query($select);
                $cat = array();
		$cat =$res->fetchAll(PDO::FETCH_ASSOC);
		return $cat;

        }

function getSubCategoryDetails($id){
	$select = "SELECT * FROM sub_categories WHERE id=$id";
                global $pdo;
                $res = $pdo->query($select);
                $row = $res->fetch(PDO::FETCH_ASSOC);
                return $row;
}
    function getUsersByCriteria($details){
	$app_config = $this->app_config;
        $per_page = empty($details['limit']) ? $app_config['per_page'] : $details['limit'];
        $offset = !empty($details['offset']) ? $details['offset'] : ($details['p']-1)*$per_page;
		$select = "SELECT users.*, user_types.type as user_type from users 
			LEFT JOIN user_types ON user_types.id = users.user_type
			WHERE 1";
		if($details['type'] !=''){
			$select .=" AND user_types.type='$details[type]'";
		}
}

//
function getCharities() {
        $select = "SELECT * from charity_master";

                global $pdo;
                $res = $pdo->query($select);
                $cat = array();
		$cat =$res->fetchAll(PDO::FETCH_ASSOC);
		return $cat;

        }
        
        function getCharityDetails($id){
	$select = "SELECT * FROM charity_master WHERE id=$id";
                global $pdo;
                $res = $pdo->query($select);
                $row = $res->fetch(PDO::FETCH_ASSOC);
                return $row;
}

function getAdminusers() {
        $select = "SELECT * from users";

                global $pdo;
                $res = $pdo->query($select);
                $cat = array();
		$cat =$res->fetchAll(PDO::FETCH_ASSOC);
		return $cat;

        }
        
         function getUserDetail($id){
	$select = "SELECT * FROM users WHERE id=$id";
                global $pdo;
                $res = $pdo->query($select);
                $row = $res->fetch(PDO::FETCH_ASSOC);
                return $row;
}

	function updateAdmin($data){
                global $pdo;
	//	$b_date = date("Y-m-d", strtotime($data['birth_date']));
		try {
		if($data['conpassword']!=''){
		$pwd= md5($data['conpassword']);
		$update = $pdo->prepare("UPDATE users 
                SET `name`=?,`type`= ?, `email`= ?,`username`=?,`password` = ?,`status` = ?
                    WHERE id= ?");
                $update->execute(array($data['name'],$data['usertype'], $data['email'],
		$data['username'],$pwd,$data['status'],$data['uid']));

                //update the password log

                }else{
                    $update = $pdo->prepare("UPDATE users 
                SET `name`=?,`type`= ?, `email`= ?,`username`=?,`status` = ?
                    WHERE id= ?");
                $update->execute(array($data['name'],$data['usertype'], $data['email'],
		$data['username'],$data['status'],$data['uid']));
		
                }
             }
        catch(PDOException $e){
            // check if username already exists in the system
            $this->setError($e->getCode());
	}
		return true;
	}

}//User class ends here
?>
