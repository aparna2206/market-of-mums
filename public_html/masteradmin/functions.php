<?php
//db functions
  function wds_sanitize_string($string) {
    $string = ereg_replace(' +', ' ', trim($string));
    return preg_replace("/[<>]/", '_', $string);
  }
  
    function wdi($string) {
	global $con;
    if (function_exists('mysqli_real_escape_string')) {
      return mysqli_real_escape_string($con,$string);
    } elseif (function_exists('mysqli_real_escape_string')) {
      return mysqli_real_escape_string($con,$string);
    }
    return addslashes($string);
  }

	function wdpi($string) 
	{
		global $con;
		if (is_string($string)) 
		{
			return addslashes(trim(wds_sanitize_string(stripslashes($string))));
		}
		elseif (is_array($string)) 
		{
			reset($string);
			while (list($key, $value) = each($string)) 
			{
				$string[$key] = wds_db_prepare_input($value);
			}
			return addslashes($string);
		}
		else
		{
			return addslashes($string);
		}
	}
  
  
  
  function wfi($string)
  {
	global $con;
  	return trim(mysqli_real_escape_string($con,$_REQUEST[$string]));
  }
  
  function sl($string)
  {
  	return stripslashes(trim($string));
  }

function check_eachchr($name)
{
	$ret = array();
	$len = strlen(trim($name));
	for ($z=0;$z<$len;$z++)
	{
	array_push($ret,substr($name,$z,1));
	}
return $ret;
}
  
function alpha_ar()
{
 return array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","'","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"," ");
}

function user_ar()
{
 return array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","0","1","2","3","4","5","6","7","8","9");
}

function num_ar()
{
 return array("0","1","2","3","4","5","6","7","8","9");
}

function check_num($name)
{
	$name = stripslashes($name);
	$libar = num_ar();
	$argar = check_eachchr($name);
	$e ="";
	foreach ($argar as $k=>$v)
	{
		if (!in_array($v,$libar))
		{
		$e = $e."1";
		}
	}
	if ($e=="")
	{
	return true;
	}
	else
	{
	return false;
	}
}

function check_name($name)
{
	$name = stripslashes($name);
	$libar = alpha_ar();
	$argar = check_eachchr($name);
	$e ="";
	foreach ($argar as $k=>$v)
	{
		if (!in_array($v,$libar))
		{
		$e = $e."1";
		}
	}
	if ($e=="")
	{
	return true;
	}
	else
	{
	return false;
	}
}

function check_username($name)
{
	$name = stripslashes($name);
	$libar = user_ar();
	$argar = check_eachchr($name);
	$e ="";
	foreach ($argar as $k=>$v)
	{
		if (!in_array($v,$libar))
		{
		$e = $e."1";
		}
	}
	if ($e=="")
	{
	return true;
	}
	else
	{
	return false;
	}
}

function CheckPasswordStrength($password)
{
    
    $strength = 0;
    $patterns = array('#[a-z]#','#[A-Z]#','#[0-9]#','/[¬!"£$%^&*()`{}\[\]:@~;\'#<>?,.\/\\-=_+\|]/');
    foreach($patterns as $pattern)
    {
        if(preg_match($pattern,$password,$matches))
        {
            $strength++;
        }
    }
    return $strength;
    
    // 1 - weak
    // 2 - not weak
    // 3 - acceptable
    // 4 - strong
}


function validate_email($email){

   $exp = "^[a-z\'0-9]+([._-][a-z\'0-9]+)*@([a-z0-9]+([._-][a-z0-9]+))+$";

   if(eregi($exp,$email))
   {
	return true;
   }else{

      return false;

   }   
}

function SentenceCase($str) {
	$str = strtolower($str);
    $sentences = explode(" ",$str);
    for($i=0;$i<count($sentences);$i++) {
        $sentences[$i][0] = ucfirst($sentences[$i][0]);
    }

    return implode(" ",$sentences);
}


function stripjavascript($string)
{
	$search = array ("'<script[^>]*?>.*?</script>'si");
	$replace = array ("");
	$string = preg_replace($search, $replace, $string);
	return $string;
}

	function createthumb($name,$filename,$new_w,$new_h)
	{
		$system=explode(".",$name);
		if (preg_match("/jpg|jpeg/",$system[1])){$src_img=imagecreatefromjpeg($name);}
		if (preg_match("/png/",$system[1])){$src_img=imagecreatefrompng($name);}
		if (preg_match("/gif/",$system[1])){$src_img=imagecreatefromgif($name);}
		$old_x=imageSX($src_img);
		$old_y=imageSY($src_img);
		if ($old_x > $old_y) 
		{
			$thumb_w=$new_w;
			$thumb_h=$old_y*($new_h/$old_x);
		}
		if ($old_x < $old_y) 
		{
			$thumb_w=$old_x*($new_w/$old_y);
			$thumb_h=$new_h;
		}
		if ($old_x == $old_y) 
		{
			$thumb_w=$new_w;
			$thumb_h=$new_h;
		}
		$dst_img=ImageCreateTrueColor($thumb_w,$thumb_h);
		imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 
		if (preg_match("/png/",$system[1]))
		{
			imagepng($dst_img,$filename); 
		} elseif (preg_match("/jpg|jpeg/",$system[1])) {
			imagejpeg($dst_img,$filename); 
		}
		  else
		{
			imagegif($dst_img,$filename); 
		}
		imagedestroy($dst_img); 
		imagedestroy($src_img); 
	}
	
	function rn_sqli_qry($sql)
	{	
		global $con;
		mysqli_query($con,$sql) or die("all:".mysql_error());
	
	}

?>