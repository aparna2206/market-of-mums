<?php
chdir(dirname(__FILE__));
include_once('User.class.php');
class Admin extends User{

    public function __construct($user_id){
        parent::__construct($user_id);
        if(!$this->isAdmin()){ 
			// Specialst extends Resident (has more privileges)
            $this->_loginRedirect();
	//log failure
            $log = debug_backtrace();
	    throw new Exception('No privileges');
        }
		
    }
	
                
         //function getFrAdmin($admin_id){
         function getAdmins($admin_type, $p = 1){
			$per_page=10;
			$offset = ($p - 1) * $per_page;
			$select = "SELECT * ,users.id as userId FROM users 
			LEFT JOIN user_types ON users.type = user_types.id
			WHERE user_types.type = '$admin_type'
            AND users.org_id = $this->org_id
			LIMIT $offset, $per_page";
			global $pdo;
			$res = $pdo->query($select);
			return $res->fetchAll(PDO::FETCH_ASSOC);
		}
	
	function getUserTypeCount($type){
		$select = "SELECT count(*) AS cnt FROM users 
		LEFT JOIN user_types ON users.type = user_types.id
		WHERE user_types.type='$type'
		AND org_id = $this->org_id";
		global $pdo;
		$res = $pdo->query($select);
		$row = $res->fetch(PDO::FETCH_ASSOC);
		return $row['cnt'];
	}
		
	

	// till here the last work done for PDO
	function searchUsers($details){
		global $pdo;
		$app_config = $this->app_config;
                $per_page = empty($details['limit']) ? $app_config['cases_per_page'] : $details['limit'];
                $offset = !empty($details['offset']) ? $details['offset'] : ($details['p']-1)*$per_page;
                $select = "SELECT DISTINCT(users.id) AS userId, users.*,user_types.type as user_type FROM users 
                        LEFT JOIN user_profile_values ON user_profile_values.user_id=users.id
                        LEFT JOIN user_types ON user_types.id = users.type
                        LEFT JOIN user_profile_fields ON user_profile_fields.id = user_profile_values.profile_field_id
                        WHERE (users.id = ? OR user_profile_values.value like ?)      
                        AND user_profile_fields.fieldname IN('first_name','last_name') 
                        AND users.org_id = ?
			            AND user_types.type IN ('PCPAdmin','DermAdmin','Admin','Coordinator')
			            LIMIT $offset, $per_page";
            try{
    			$select = $pdo->prepare($select);
                $keyword_string = '%'.$details['keywords'].'%';
			    $select->execute(array($details['keywords'], $keyword_string, $this->org_id));
            }
            catch(PDOException $e){
                $this->setError($e->getMessage());
                return false;
            }
				
            return $select->fetchAll(PDO::FETCH_ASSOC);
        }

	function searchUsersCount($criteria){
				global $pdo;
                $select = "SELECT COUNT(DISTINCT(users.id)) AS cnt FROM users 
                        EFT JOIN user_profile_values ON user_profile_values.user_id=users.id
                        LEFT JOIN user_types ON user_types.id = users.type
                        LEFT JOIN user_profile_fields ON user_profile_fields.id = user_profile_values.profile_field_id
                        WHERE (users.id = ? OR user_profile_values.value like '%?%')      
                        AND users.org_id = ?
                        AND user_profile_fields.fieldname IN('first_name','last_name')";
//      echo $select;
				$select = $pdo->prepare($select);
				$select->execute(array($criteria[keywords], $criteria[keywords], $this->org_id));
                if(!($res = $pdo->query($select))){
                        $this->setError($select);
                        return false;
                }
                $row = $res->fetch(PDO::FETCH_ASSOC);
                return $row['cnt'];
        }

public function removeUser($user_id){
		global $pdo;
	try{
		$update = $pdo->prepare("DELETE FROM users WHERE `id` = ?");
		$update->execute(array($user_id));
	}
	catch(PDOException $e){
		$this->setError($e->getMessage());
		return false;
	}
	return true;
}



public function removeCategory($id){
		global $pdo;
	try{
		$update = $pdo->prepare("DELETE FROM categories WHERE `id` = ?");
		$update->execute(array($id));
	}
	catch(PDOException $e){
		$this->setError($e->getMessage());
		return false;
	}
	return true;
}

public function uploadRecipeImage($recipe_id,$file,$tmp_filename,$type=0){

    //filename mangling
        $file = $recipe_id.'_'.$file;
        $file_location=$_SERVER['DOCUMENT_ROOT']."/images/category_banners/$file"; // create a directory for every user_id
        $resized_img_path=$_SERVER['DOCUMENT_ROOT']."/images/category_banners/th_$file"; // create a directory for every user_id
        $new_size = getNewDimensions($tmp_filename);
        if(move_uploaded_file($tmp_filename,$file_location)){
                createthumb($file_location,$resized_img_path,$new_size['new_width'],$new_size['new_height']);
                if($this->addRecipeImage($recipe_id,$file)){
                        return true;
                }else{
                        return false;
                }
        }
}

public function addRecipeImage($recipe_id,$file){
        global $pdo;
        try{
                $stmt = "UPDATE categories SET `photo`=? WHERE `id` = ?";
                $stmt = $pdo->prepare($stmt);
                $stmt->execute(array($file,$recipe_id));
        }catch(PDOException $e){
                $this->setError($e->getMessage());
	 	return false;
        }
	return true;
}

public function deleteRecipeImage($id){
	$recipe_details=$this->getRecipeDetails($_POST['id']);
	if( $recipe_details['photo'] !=''){
		$file=$_SERVER['DOCUMENT_ROOT']."/../files/recipe_images/".$recipe_details['photo'];
		unlink($file);
	}
	return true;
}
public function updateCoupon($data){
        global $pdo;
        try{
                $stmt = "UPDATE coupons_discount SET `code`=? , `discount_amount` = ?, `discount_per` = ?,
			`from_date` = ?, `to_date` = ? WHERE `id` = ?";
                $stmt = $pdo->prepare($stmt);
                $stmt->execute(array($data['code'], $data['discount_amount'],$data['discount_per'],$data['from_date'],$data['to_date'],$data['id']));
        }catch(PDOException $e){
                $this->setError($e->getMessage());
	 	return false;
        }
	return true;
}
public function addCouponCode($data){
        global $pdo;
        try{
                $stmt = "INSERT INTO coupons_discount (`code`,`discount_amount`,`discount_per`,`from_date`,`to_date`) VALUES (?,?,?,?,?)";
                $stmt = $pdo->prepare($stmt);
                $stmt->execute(array($data['code'], $data['discount_amount'],$data['discount_per'],$data['from_date'],$data['to_date']));
        }catch(PDOException $e){
		
		//echo $e->getMessage();
                $this->setError($e->getMessage());
	 	return false;
        }
	return true;
}
public function removeCoupon($id){
		global $pdo;
	try{
		$update = $pdo->prepare("DELETE FROM coupons_discount WHERE `id` = ?");
		$update->execute(array($id));
	}
	catch(PDOException $e){
		$this->setError($e->getMessage());
		return false;
	}
	return true;
}


// for sub category add and delete
public function addSubCat($data){
        global $pdo;
        try{

                $stmt = "INSERT INTO categories (`category`,`parent`,`priority`,`photo`,`desc`,`short_desc`) VALUES (?,?,0,?,?,?)";
                $stmt = $pdo->prepare($stmt);
                $stmt->execute(array($data['title'],$data['parent'],$data['logo'],$data['description'],$data['shortdescription']));
		$cat_id=$pdo->lastInsertId('id');
 		
		

        }catch(PDOException $e){
                echo $e->getMessage();
                $this->setError($e->getMessage());
                return false;
        }
//$last_id = $pdo->insert_id;
//echo $last_id;
//end;
//printf("Last inserted record has id %d\n", mysql_insert_id());

	 return $cat_id;
}
public function addCategoryImage($cat_id,$file){
        global $pdo;
        try{
                $stmt = "UPDATE categories SET `photo`=? WHERE `id` = ?";
                $stmt = $pdo->prepare($stmt);
                $stmt->execute(array($file,$cat_id));
        }catch(PDOException $e){
                $this->setError($e->getMessage());
                return false;
        }
        return true;
}

public function uploadShopImage($shop_id,$file,$tmp_filename){
    //filename mangling
        $file = $shop_id.'_'.$file;
        $file_location=$_SERVER['DOCUMENT_ROOT']."/images/shop_images/$file"; // create a directory for every user_id
        $new_size = getNewDimensions($tmp_filename);
        if(move_uploaded_file($tmp_filename,$file_location)){
                if($this->addShopImage($shop_id,$file)){
                        return true;
                }else{
                        return false;
                }
        }
}

public function addShopImage($shop_id,$file){
        global $pdo;
        try{
                $stmt = "UPDATE shops SET `logo`=? WHERE `id` = ?";
                $stmt = $pdo->prepare($stmt);
                $stmt->execute(array($file,$shop_id));
        }catch(PDOException $e){
                $this->setError($e->getMessage());
                return false;
        }
        return true;
}

public function uploadCategoryImage($cat_id,$file,$tmp_filename){

    //filename mangling
        $file = $cat_id.'_'.$file;
        $file_location=$_SERVER['DOCUMENT_ROOT']."/images/category_banners/$file"; // create a directory for every user_id
        $new_size = getNewDimensions($tmp_filename);
        if(move_uploaded_file($tmp_filename,$file_location)){
                if($this->addCategoryImage($cat_id,$file)){
                        return true;
                }else{
                        return false;
                }
        }
}
public function updatesubCategory($data){


        global $pdo;
        try{
                $stmt = "UPDATE categories SET `category`=?,`priority`=?,`photo`=?,`desc`=?,`short_desc`=? WHERE `id` = ?";
                $stmt = $pdo->prepare($stmt);
                $stmt->execute(array($data['title'],$data['priority'],$data['logo'],$data['description'],$data['shortdescription'],$data['id']));

        }catch(PDOException $e){

                echo $e->getMessage();
                $this->setError($e->getMessage());
                return false;
        }
        return true;
}

// update sub category srbh
public function updatesubCat($data){


        global $pdo;
        try{
                $stmt = "UPDATE categories SET `category`=?,`parent`=?,`photo`=?,`desc`=?,`short_desc`=? WHERE `id` = ?";
                $stmt = $pdo->prepare($stmt);
                $stmt->execute(array($data['title'],$data['parent'],$data['logo'],$data['description'],$data['shortdescription'],$data['id']));

        }catch(PDOException $e){

                echo $e->getMessage();
                $this->setError($e->getMessage());
                return false;
        }
        return true;
}


//get last insert id 

function getlastid() {

         $select = "SELECT MAX(id) AS cnt from categories";
	global $pdo;
        $stmt = $pdo->query($select);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return $row['cnt'];



}


// for shop
public function addShop($data){
        global $pdo;
        try{

              $stmt = "INSERT INTO shops (`name`,`url`,`logo`,`description`,`category`,`country`) VALUES (?,?,?,?,?,?)";
              $stmt = $pdo->prepare($stmt);
            $stmt->execute(array($data['name'],$data['url'],$data['logo'],$data['description'],$data['category'],$data['country']));
		$shop_id=$pdo->lastInsertId('id');

        }catch(PDOException $e){
                $this->setError($e->getMessage());
                return false;
        }
//$last_id = $pdo->insert_id;
//echo $last_id;
//end;
//printf("Last inserted record has id %d\n", mysql_insert_id());


        return $shop_id;
}


# update shops by admin
public function updateShop($data){


        global $pdo;
        try{
                $stmt = "UPDATE shops SET `name`=?,`url`=?,`country`=?,`description`=?,category=? WHERE `id` = ?";
                $stmt = $pdo->prepare($stmt);
                $stmt->execute(array($data['name'],$data['url'],$data['country'],$data['description'],$data['category'],$data['id']));

        }catch(PDOException $e){

                echo $e->getMessage();
                $this->setError($e->getMessage());
                return false;
        }
        return true;
}

public function removeShop($id){
                global $pdo;
        try{
                $update = $pdo->prepare("DELETE FROM shops WHERE `id` = ?");
                $update->execute(array($id));
        }
        catch(PDOException $e){
                $this->setError($e->getMessage());
                return false;
        }
        return true;
}

// manage users
public function addUsers($data){
    
        $pwd= md5($data['conpassword']);

                global $pdo;
        try{
        $stmt = "INSERT INTO users
            (`name`,`type`,`email`, `username`, `password`,`status`,`actionby`,`creation_date`)
            VALUES(?,?,?,?,?,?,?,NOW())";
            $stmt = $pdo->prepare($stmt);
            $stmt->execute(array($data['name'],$data['usertype'],$data['email'],$data['username'],$pwd,$data['status'],$data['actid']));
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


// update users
public function updateUser($data){


        global $pdo;
        try{
                $stmt = "UPDATE users SET `name_title`=?,`first_name`=?,`last_name`=?,`email`=?,`password`=?,`mobile`=?,`address_1`=?,`city`=?,`state`=?,`country`=? WHERE `id` = ?";
                $stmt = $pdo->prepare($stmt);
                $stmt->execute(array($data['title'],$data['fname'],$data['lname'],$data['email'],$data['password'],$data['contact'],
		$data['address1'],$data['city'],$data['state'],$data['country'],$data['id']));

        }catch(PDOException $e){

                echo $e->getMessage();
                $this->setError($e->getMessage());
                return false;
        }
        return true;
}


public function removeUserfromid($id){
                global $pdo;
        try{
                $update = $pdo->prepare("DELETE FROM users WHERE `id` = ?");
                $update->execute(array($id));
        }
        catch(PDOException $e){
                $this->setError($e->getMessage());
                return false;
        }
        return true;
}

// add new content
public function addContent($data){
        global $pdo;
        try{
                $stmt = "INSERT INTO content (`title`,`desc`,`isactive`,`content`) VALUES (?,?,?,?)";
                $stmt = $pdo->prepare($stmt);
                $stmt->execute(array($data['title'],$data['description'],$data['status'],$data['content']));
        }catch(PDOException $e){
                echo $e->getMessage();
                $this->setError($e->getMessage());
                return false;
        }
        return true;
}



// update content
public function updateContent($data){
        global $pdo;
        try{
                $stmt = "UPDATE content SET `title`=?,`isactive`=?,`content`=? WHERE `id` = ?";
                $stmt = $pdo->prepare($stmt);
                $stmt->execute(array($data['title'],$data['status'],$data['content'],$data['id']));

        }catch(PDOException $e){

                echo $e->getMessage();
                $this->setError($e->getMessage());
                return false;
        }
        return true;
}

public function removeContent($id){
                global $pdo;
        try{
                $update = $pdo->prepare("DELETE FROM content WHERE `id` = ?");
                $update->execute(array($id));
        }
        catch(PDOException $e){
                $this->setError($e->getMessage());
                return false;
        }
        return true;
}

// add banner to 
public function addbanner($data){
        global $pdo;
        try{

                $stmt = "INSERT INTO banner (`title`,`desc`,`isactive`,`photo`) VALUES (?,?,?,?)";
                $stmt = $pdo->prepare($stmt);
                $stmt->execute(array($data['title'],$data['description'],$data['isactive'],$data['logo']));
                $ban_id=$pdo->lastInsertId('id');



        }catch(PDOException $e){
                echo $e->getMessage();
                $this->setError($e->getMessage());
                return false;
        }

         return $ban_id;
}


public function uploadBannerImage($ban_id,$file,$tmp_filename){

    //filename mangling
        $file = $ban_id.'_'.$file;
        $file_location=$_SERVER['DOCUMENT_ROOT']."/images/simple_banners/$file"; // create a directory for every user_id
        $new_size = getNewDimensions($tmp_filename);
        if(move_uploaded_file($tmp_filename,$file_location)){
                if($this->addBannerImage($ban_id,$file)){
                        return true;
                }else{
                        return false;
                }
        }

}



public function addBannerImage($ban_id,$file){
        global $pdo;
        try{
                $stmt = "UPDATE banner SET `photo`=? WHERE `id` = ?";
                $stmt = $pdo->prepare($stmt);
                $stmt->execute(array($file,$ban_id));
        }catch(PDOException $e){
                $this->setError($e->getMessage());
                return false;
        }
        return true;
}

// update banner srbh
public function updatebanner($data){


        global $pdo;
        try{
                $stmt = "UPDATE banner SET `title`=?,`desc`=?,`isactive`=? WHERE `id` = ?";
                $stmt = $pdo->prepare($stmt);
                $stmt->execute(array($data['title'],$data['description'],$data['isactive'],$data['id']));

        }catch(PDOException $e){

                echo $e->getMessage();
                $this->setError($e->getMessage());
                return false;
        }
        return true;
}

public function removeBanner($id){
                global $pdo;
        try{
                $update = $pdo->prepare("DELETE FROM banner WHERE `id` = ?");
                $update->execute(array($id));
        }
        catch(PDOException $e){
                $this->setError($e->getMessage());
                return false;
        }
        return true;
}

// add banner to 
public function addpromobanner($data){
        global $pdo;
        try{

                $stmt = "INSERT INTO promobanner (`title`,`desc`,`isactive`,`photo`) VALUES (?,?,?,?)";
                $stmt = $pdo->prepare($stmt);
                $stmt->execute(array($data['title'],$data['description'],$data['isactive'],$data['logo']));
                $ban_id=$pdo->lastInsertId('id');



        }catch(PDOException $e){
                echo $e->getMessage();
                $this->setError($e->getMessage());
                return false;
        }

         return $ban_id;
}


public function uploadPromoBannerImage($ban_id,$file,$tmp_filename){

    //filename mangling
        $file = $ban_id.'_'.$file;
        $file_location=$_SERVER['DOCUMENT_ROOT']."/images/promo_banners/$file"; // create a directory for every user_id
        $new_size = getNewDimensions($tmp_filename);

        if(move_uploaded_file($tmp_filename,$file_location)){

                if($this->addPromoBannerImage($ban_id,$file)){
                        return true;
                }else{
                        return false;
                }
        }

}

public function addPromoBannerImage($ban_id,$file){

        global $pdo;
        try{
                $stmt = "UPDATE promobanner SET `photo`=? WHERE `id` = ?";
                $stmt = $pdo->prepare($stmt);
                $stmt->execute(array($file,$ban_id));
        }catch(PDOException $e){
                $this->setError($e->getMessage());
                return false;
        }
        return true;
}

// update promobanner srbh
public function updatepromobanner($data){


        global $pdo;
        try{
                $stmt = "UPDATE promobanner SET `title`=?,`desc`=?,`isactive`=? WHERE `id` = ?";
                $stmt = $pdo->prepare($stmt);
                $stmt->execute(array($data['title'],$data['description'],$data['isactive'],$data['id']));

        }catch(PDOException $e){

                echo $e->getMessage();
                $this->setError($e->getMessage());
                return false;
        }
        return true;
}


// delete promo banner
public function removePromoBanner($id){
                global $pdo;
        try{
                $update = $pdo->prepare("DELETE FROM promobanner WHERE `id` = ?");
                $update->execute(array($id));
        }
        catch(PDOException $e){
                $this->setError($e->getMessage());
                return false;
        }
        return true;
}


// add new video
public function addVideo($data){
        global $pdo;
        try{
                $stmt = "INSERT INTO videos (`title`,`desc`,`isactive`,`url`) VALUES (?,?,?,?)";
                $stmt = $pdo->prepare($stmt);
                $stmt->execute(array($data['title'],$data['description'],$data['status'],$data['url']));
        }catch(PDOException $e){
                echo $e->getMessage();
                $this->setError($e->getMessage());
                return false;
        }
        return true;
}


// update content
public function updateVideos($data){


        global $pdo;
        try{
                $stmt = "UPDATE videos SET `title`=?,`desc`=?,`isactive`=?,`url`=? WHERE `id` = ?";
                $stmt = $pdo->prepare($stmt);
                $stmt->execute(array($data['title'],$data['description'],$data['status'],$data['url'],$data['id']));

        }catch(PDOException $e){

                echo $e->getMessage();
                $this->setError($e->getMessage());
                return false;
        }
        return true;
}


public function removeVideo($id){
                global $pdo;
        try{
                $update = $pdo->prepare("DELETE FROM videos WHERE `id` = ?");
                $update->execute(array($id));
        }
        catch(PDOException $e){
                $this->setError($e->getMessage());
                return false;
        }
        return true;
}



// add company logo  
public function addlogo($data){
        global $pdo;
        try{

                $stmt = "INSERT INTO logos (`title`,`desc`,`isactive`,`photo`) VALUES (?,?,?,?)";
                $stmt = $pdo->prepare($stmt);
                $stmt->execute(array($data['title'],$data['description'],$data['isactive'],$data['logo']));
                $ban_id=$pdo->lastInsertId('id');



        }catch(PDOException $e){
                echo $e->getMessage();
                $this->setError($e->getMessage());
                return false;
        }

         return $ban_id;
}




public function uploadLogoImage($ban_id,$file,$tmp_filename){

    //filename mangling
        $file = $ban_id.'_'.$file;
        $file_location=$_SERVER['DOCUMENT_ROOT']."/images/company_logos/$file"; // create a directory for every user_id
        $new_size = getNewDimensions($tmp_filename);
        if(move_uploaded_file($tmp_filename,$file_location)){
                if($this->addLogosImage($ban_id,$file)){
                        return true;
                }else{
                        return false;
                }
        }

}

public function addLogosImage($ban_id,$file){
        global $pdo;
        try{
                $stmt = "UPDATE logos SET `photo`=? WHERE `id` = ?";
                $stmt = $pdo->prepare($stmt);
                $stmt->execute(array($file,$ban_id));
        }catch(PDOException $e){
                $this->setError($e->getMessage());
                return false;
        }
        return true;
}



// update logos
public function updatelogo($data){


        global $pdo;
        try{
                $stmt = "UPDATE logos SET `title`=?,`desc`=?,`isactive`=? WHERE `id` = ?";
                $stmt = $pdo->prepare($stmt);
                $stmt->execute(array($data['title'],$data['description'],$data['isactive'],$data['id']));

        }catch(PDOException $e){

                echo $e->getMessage();
                $this->setError($e->getMessage());
                return false;
        }
        return true;
}

public function removeLogo($id){
                global $pdo;
        try{
                $update = $pdo->prepare("DELETE FROM logos WHERE `id` = ?");
                $update->execute(array($id));
        }
        catch(PDOException $e){
                $this->setError($e->getMessage());
                return false;
        }
        return true;
}


public function addCurrency($data){
        global $pdo;
        try{
                $stmt = "INSERT INTO currency (`usa`,`uk`) VALUES (?,?)";
                $stmt = $pdo->prepare($stmt);
                $stmt->execute(array($data['usa'],$data['uk']));
        }catch(PDOException $e){
                echo $e->getMessage();
                $this->setError($e->getMessage());
                return false;
        }
        return true;
}


// update currency
public function updateCurrency($data){
        global $pdo;
        try{
                $stmt = "UPDATE currency SET `usa`=?,`uk`=?  WHERE `id` = ?";
                $stmt = $pdo->prepare($stmt);
                $stmt->execute(array($data['usa'],$data['uk'],$data['id']));

        }catch(PDOException $e){

                echo $e->getMessage();
                $this->setError($e->getMessage());
                return false;
        }
        return true;
}


public function removeCurrency($id){
                global $pdo;
        try{
                $update = $pdo->prepare("DELETE FROM currency WHERE `id` = ?");
                $update->execute(array($id));
        }
        catch(PDOException $e){
                $this->setError($e->getMessage());
                return false;
        }
        return true;
}


//update order status
public function updateOrderStatus($data){
        global $pdo;
        try{
                $stmt = "UPDATE orders SET `status`=?,`delivery_status`=? WHERE `id` = ?";
                $stmt = $pdo->prepare($stmt);
                $stmt->execute(array($data['payment_sts'],$data['delivery_sts'],$data['id']));

        }catch(PDOException $e){

                echo $e->getMessage();
                $this->setError($e->getMessage());
                return false;
        }

        return true;
}

public function updateCategory($data){
	global $pdo;
	try{
	    $stmt = "UPDATE categories SET `category`=?,`description`=?,`is_active`=? WHERE id=?";
        $stmt = $pdo->prepare($stmt);
        $stmt->execute(array($data['category'],$data['details'],$data['lstatus'],$data['id'])); 
	}catch(PDOException $e){
		$this->setError($e->getMessage());
		return false;
	}
	return true;
}

public function addCategory($data){
	global $pdo;
	try{
	    $stmt = "INSERT INTO categories(`category`,`description`,`created_date`,`is_active`,`is_deleted`) VALUES(?,?,NOW(),?,?)";
        $stmt = $pdo->prepare($stmt);
        $stmt->execute(array($data['category'],$data['Details'],$data['lstatus'],0)); 
	}catch(PDOException $e){
		$this->setError($e->getMessage());
		return false;
	}
	return true;
}

public function updateSubCate($data){
	global $pdo;
	try{
	    $stmt = "UPDATE sub_categories SET `category`=?,`sub_category`=?,`description`=?,`is_active`=? WHERE id=?";
        $stmt = $pdo->prepare($stmt);
        $stmt->execute(array($data['category'],$data['sub_category'],$data['Details'],$data['lstatus'],$data['id'])); 
	}catch(PDOException $e){
		$this->setError($e->getMessage());
		return false;
	}
	return true;
}
public function addSubCategory($data){
	global $pdo;
	try{
	    $stmt = "INSERT INTO sub_categories(`category`,`sub_category`,`description`,`created_date`,`is_active`,`is_deleted`) VALUES(?,?,?,NOW(),?,?)";
        $stmt = $pdo->prepare($stmt);
        $stmt->execute(array($data['category'],$data['sub_category'],$data['Details'],$data['lstatus'],0)); 
	}catch(PDOException $e){
		$this->setError($e->getMessage());
		return false;
	}
	return true;
}

public function addCharity($data){
	global $pdo;
	try{
	    $stmt = "INSERT INTO charity_master(`name`,`description`,`created_date`,`is_active`,`is_deleted`) VALUES(?,?,NOW(),?,?)";
        $stmt = $pdo->prepare($stmt);
        $stmt->execute(array($data['charity'],$data['Details'],$data['lstatus'],0)); 
	}catch(PDOException $e){
		$this->setError($e->getMessage());
		return false;
	}
	return true;
}

public function updatecharity($data){
	global $pdo;
	try{
	    $stmt = "UPDATE charity_master SET `name`=?,`description`=?,`is_active`=? WHERE id=?";
        $stmt = $pdo->prepare($stmt);
        $stmt->execute(array($data['charity'],$data['details'],$data['lstatus'],$data['id'])); 
	}catch(PDOException $e){
            echo $e->getMessage();
		$this->setError($e->getMessage());
		return false;
	}
	return true;
}


} // class ends here
