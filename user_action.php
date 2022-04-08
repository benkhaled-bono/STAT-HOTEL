<?php
include('stathotel.php');
$arrive = new stathotel();
if(isset($_POST["action"]))
{
	if($_POST["action"] == 'fetch')
	{
		$order_column = array('admin_table.admin_name', 'wilaya.nom_wilaya');
		$output = array();
		$main_query = "
		SELECT * FROM admin_table
		LEFT JOIN wilaya ON admin_table.wilaya_ID = wilaya.wilaya_id
		LEFT JOIN etab_hebergement ON admin_table.etab_ID = etab_hebergement.etab_id
		";
		if ($arrive->is_master_user()) {
            $main_query .= "
		
			WHERE admin_table.admin_type = 'Dta' ";
        }
		if ($arrive->is_dta_user()) {
		    
            $main_query .= "
							WHERE admin_table.wilaya_ID =  '" . $_SESSION["wilaya_id"] . "'
							";
        }
		$search_query = '';
		if(isset($_POST["search"]["value"]))
		{

			if ($arrive->is_dta_user()) {
				$search_query .= 'AND (admin_table.admin_name LIKE "%'.$_POST["search"]["value"].'%" )';
			


			}

			// $search_query .= 'AND (admin_table.admin_name LIKE "%'.$_POST["search"]["value"].'%" ';
			
			if ($arrive->is_master_user()) {
				 $search_query .= 'AND (admin_table.admin_name LIKE "%'.$_POST["search"]["value"].'%" ';
				$search_query .= 'OR wilaya.nom_wilaya LIKE "%'.$_POST["search"]["value"].'%" )';


			}
       
		}

		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY admin_table.admin_id DESC ';
		}

		$limit_query = '';

		if($_POST["length"] != -1)
		{
			$limit_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}
		$arrive->query = $main_query . $search_query . $order_query;
		$arrive->execute();
		$filtered_rows = $arrive->row_count();
		$arrive->query .= $limit_query;
		$result = $arrive->get_result();
		$arrive->query = $main_query;
		$arrive->execute();
		$total_rows = $arrive->row_count();
		$data = array();
		foreach($result as $row)
		{
			$sub_array = array();
			$sub_array[] = $row["admin_id"];
			$sub_array[] = '<img src="'.$row["admin_profile"].'" class="img-thumbnail" width="40" height="40" />';
			$sub_array[] = html_entity_decode($row["admin_name"]);
			$sub_array[] = $row["admin_contact_no"];
			$sub_array[] = $row["admin_email"];
			$sub_array[] = $row["admin_created_on"];
			$sub_array[] = $row["admin_type"];
			$sub_array[] = $row["denomination_ar"];
				if ($arrive->is_master_user()) {
            $sub_array[] = $row["nom_wilaya"];
			}
			$delete_button = '';
			if($row["admin_status"] == 'Enable')
			{
				$delete_button = '<button type="button" name="delete_button" class="btn btn-primary btn-sm delete_button" data-id="'.$row["admin_id"].'" data-status="'.$row["admin_status"].'">'.$row["admin_status"].'</button>';
			}
			else
			{
				$delete_button = '<button type="button" name="delete_button" class="btn btn-danger btn-sm delete_button" data-id="'.$row["admin_id"].'" data-status="'.$row["admin_status"].'">'.$row["admin_status"].'</button>';
			}
			$sub_array[] = $delete_button;
		
			
			$sub_array[] = '
			<div align="center">
			<button type="button" name="edit_button" class="btn btn-warning btn-sm edit_button" data-id="'.$row["admin_id"].'"><i class="fas fa-edit"></i></button>
			</div>';
			$data[] = $sub_array;
		}

		$output = array(
			"draw"    			=> 	intval($_POST["draw"]),
			"recordsTotal"  	=>  $total_rows,
			"recordsFiltered" 	=> 	$filtered_rows,
			"data"    			=> 	$data
		);
		echo json_encode($output);
	}
// ************************************************************* ADD **************************
	if($_POST["action"] == 'Add')
	{
		$data = array(
			':admin_email'	=>	$_POST["admin_email"]
		);
		$arrive->query = "
		SELECT * FROM admin_table 
		WHERE admin_email = :admin_email
		";
		$arrive->execute($data);

		if($arrive->row_count() > 0)
		{
			echo '<div class="alert alert-danger">هذا البريد الإلكتروني موجود بالفعل</div>';
		}
		else
		{
			$user_image = '';
			
			if($_FILES["user_image"]["name"] != '')
			{
				$user_image = upload_image();
			}
			else
			{
				$user_image = make_avatar(strtoupper($_POST["admin_name"][0]));
			}	


		    $etab_ID = $_POST["etab"] ;
		    
		    	if ($arrive->is_dta_user()) 
			{
				if ( $etab_ID != '') {
				    
				     $etab_ID = $_POST["etab"];
				} else {
				    
				     $etab_ID = NULL;
				}
			}	
		    
		 else {
				$etab_ID = $_SESSION['etab_id'];
			}
		// ************ ADD WILAYA 
		$wilaya = "" ; 
		if ($arrive->is_master_user()) {
			$wilaya = $_POST["wilaya"];
		} else {
			$wilaya = $_SESSION['wilaya_id'] ;
		
		}
			$data = array(
			
				':admin_name'		=>	$arrive->clean_input(strtoupper($_POST["admin_name"])),
				':admin_email'		=>	$_POST["admin_email"],
				':admin_password'	=>	password_hash($_POST["admin_password"], PASSWORD_DEFAULT),
				':admin_contact_no'	=>	$_POST["admin_contact_no"],
				':admin_profile'	=>	$user_image,
			    ':admin_type'		=>	$_POST["admin_type"],
			    ':wilaya_ID'		=>	$wilaya,
			 	':etab_ID'			=>	$etab_ID
			);
			$arrive->query = "
			INSERT INTO admin_table 
			(admin_name, admin_email, admin_password, admin_contact_no, admin_profile, admin_type, admin_created_on, wilaya_ID, etab_ID) 
			VALUES 
			(:admin_name, :admin_email, :admin_password, :admin_contact_no, :admin_profile, :admin_type, now(), :wilaya_ID, :etab_ID)
			";
			$arrive->execute($data);
				echo '<div class="alert alert-success">تم اضافة المستخدم بنجاح</div>';
		}	
	}

	// ****************************************EDIT 
	if($_POST["action"] == 'fetch_single')
	{
		$arrive->query = "
		SELECT * FROM admin_table 
		WHERE admin_id = '".$_POST["admin_id"]."'
		";
		$result = $arrive->get_result();
		$data = array();
		foreach($result as $row)
		{
			$data['admin_name'] = $row['admin_name'];
			$data['admin_contact_no'] = $row['admin_contact_no'];
			$data['admin_email'] = $row['admin_email'];
			$data['admin_profile'] = $row['admin_profile'];
			$data['wilaya'] = $row['wilaya_ID'];
			
		}
		echo json_encode($data);
	}

	if($_POST["action"] == 'Edit')
	{
		$data = array(
		':admin_email'	=>	$_POST["admin_email"],
		':admin_id'		=>	$_POST['hidden_id']
		);
		$arrive->query = "
		SELECT * FROM admin_table 
		WHERE admin_email = :admin_email 
		AND admin_id != :admin_id
		";
		$arrive->execute($data);

		if($arrive->row_count() > 0)
		{
			echo '<div class="alert alert-danger">البريد الإلكتروني للمستخدم موجود بالفعل !</div>';
		}
		else
		{
			$user_image = $_POST["hidden_user_image"];
			if($_FILES["user_image"]["name"] != '')
			{
				$user_image = upload_image();
			}

			$data[':admin_name'] = $arrive->clean_input($_POST["admin_name"]);
			$data[':admin_contact_no'] = $_POST["admin_contact_no"];
			$data[':admin_email'] = $_POST["admin_email"];
		
			if($_POST["admin_password"] != '')
			{
				$data[':admin_password'] = password_hash($_POST["admin_password"], PASSWORD_DEFAULT);
			}
			$data[':admin_profile'] = $user_image;
			$data[':admin_type'] =	$_POST["admin_type"];


			
			if ($arrive->is_master_user()) {
				$data[':wilaya'] =	$_POST["wilaya"];
			}
		

			if($_POST["admin_password"] != '')
			{
				$wilaya = "";
                if ($arrive->is_master_user()) {
					 $wilaya =  $_POST["wilaya"] ;
                }
			else {
				$wilaya = $_SESSION['wilaya_id'] ;
			
			}

				$data = array(
					':admin_name'	=>	$arrive->clean_input($_POST["admin_name"]),
					':admin_contact_no'	=>	$_POST["admin_contact_no"],
					':admin_email'	=>	$_POST["admin_email"],
					':admin_password'	=>	password_hash($_POST["admin_password"], PASSWORD_DEFAULT),
					':admin_profile'	=>	$user_image,
					':admin_type'	=>	$_POST["admin_type"],
					':wilaya'	=>	$wilaya



				);
				$arrive->query = "
				UPDATE admin_table 
				SET admin_name = :admin_name, 
				admin_contact_no = :admin_contact_no, 
				admin_email = :admin_email, 
				admin_password = :admin_password, 
				admin_profile = :admin_profile,
				admin_type 	= 	:admin_type, 
				wilaya_ID = :wilaya


				WHERE admin_id = '".$_POST['hidden_id']."'
				";

				$arrive->execute($data);
			}
			else
			{
				$wilaya = "";
                if ($arrive->is_master_user()) {
					 $wilaya =  $_POST["wilaya"] ;
                }
			else {
				$wilaya = $_SESSION['wilaya_id'] ;
			
			}
				$data = array(
					':admin_name'	=>	$arrive->clean_input($_POST["admin_name"]),
					':admin_contact_no'	=>	$_POST["admin_contact_no"],
					':admin_email'	=>	$_POST["admin_email"],
					':admin_profile'	=>	$user_image,
					':admin_type' =>	$_POST["admin_type"],
					':wilaya'	=>	$wilaya
				);

				$arrive->query = "
				UPDATE admin_table 
				SET admin_name = :admin_name, 
				admin_contact_no = :admin_contact_no, 
				admin_email = :admin_email,  
				admin_profile = :admin_profile, 
				admin_type =	:admin_type,
				wilaya_ID = :wilaya
				WHERE admin_id = '".$_POST['hidden_id']."'
				";

				$arrive->execute($data);
			}

			echo '<div class="alert alert-success">تم تحديث تفاصيل المستخدم !</div>';
		}
	}
	if($_POST["action"] == 'delete')
	{
		$data = array(
			':admin_status'		=>	$_POST['next_status']
		);
		$arrive->query = "
		UPDATE admin_table 
		SET admin_status = :admin_status 
		WHERE admin_id = '".$_POST["id"]."'
		";
		$arrive->execute($data);
		echo '<div class="alert alert-success">تغيير حالة المستخدم إلى '.$_POST['next_status'].'</div>';
	}
// ------------------------------------------- PROFILE EDIT -----------------------------
	if($_POST["action"] == 'profile')
	{
		sleep(1);
		$error = '';
		$success = '';
		$admin_name = '';
		$admin_contact_no = '';
		$admin_email = '';
		$admin_profile = '';
		$data = array(
			':admin_email'	=>	$_POST["admin_email"],
			':admin_id'		=>	$_POST['hidden_id']
		);

		$arrive->query = "
		SELECT * FROM admin_table 
		WHERE admin_email = :admin_email 
		AND admin_id != :admin_id
		";
		$arrive->execute($data);
		if($arrive->row_count() > 0)
		{
			$error = '<div class="alert alert-danger">البريد الإلكتروني للمستخدم موجود بالفعل</div>';
		}
		else
		{
			$user_image = $_POST["hidden_user_image"];
			if($_FILES["user_image"]["name"] != '')
			{
				$user_image = upload_image();
			}
			$admin_name = $arrive->clean_input($_POST["admin_name"]);
			$admin_contact_no = $_POST["admin_contact_no"];
			$admin_email = $_POST["admin_email"];
			$admin_profile = $user_image;
			$data = array(
				':admin_name'	=>	$admin_name,
				':admin_contact_no'	=>	$admin_contact_no,
				':admin_email'	=>	$admin_email,
				':admin_profile'	=>	$admin_profile
			);

			$arrive->query = "
			UPDATE admin_table 
			SET admin_name = :admin_name, 
			admin_contact_no = :admin_contact_no, 
			admin_email = :admin_email,  
			admin_profile = :admin_profile 
			WHERE admin_id = '".$_POST['hidden_id']."'
			";
			$arrive->execute($data);
			$success = '<div class="alert alert-success">تم تحديث تفاصيل المستخدم</div>';
		}
		$output = array(
			'error'		=>	$error,
			'success'	=>	$success,
			'admin_name'	=>	$admin_name,
			'admin_contact_no'	=>	$admin_contact_no,
			'admin_email'	=>	$admin_email,
			'admin_profile'	=>	$admin_profile
		);
		echo json_encode($output);
	}
// ---------------------------------------------------- PASSWORD CHANGE -------------------------------
	if($_POST["action"] == 'change_password')
	{
		sleep(1);
		$error = '';
		$success = '';
		$arrive->query = "
		SELECT admin_password FROM admin_table 
		WHERE admin_id = '".$_SESSION["admin_id"]."'
		";
		$result = $arrive->get_result();
		foreach($result as $row)
		{
			if(password_verify($_POST["current_password"], $row["admin_password"]))
			{
				$data = array(
					':admin_password'	=>	password_hash($_POST["new_password"], PASSWORD_DEFAULT)
				);
				$arrive->query = "
				UPDATE admin_table 
				SET admin_password = :admin_password 
				WHERE admin_id = '".$_SESSION["admin_id"]."'
				";

				$arrive->execute($data);

				$success = '<div class="alert alert-success">تم تغيير كلمة المرور بنجاح</div>';
			}
			else
			{
				$error = '<div class="alert alert-danger">لقد أدخلت كلمة مرور حالية خاطئة</div>';
			}
		}
		$output = array(
			'error'		=>	$error,
			'success'	=>	$success
		);
		echo json_encode($output);
	}
}
function upload_image()
{
	if(isset($_FILES["user_image"]))
	{
		$extension = explode('.', $_FILES['user_image']['name']);
		$new_name = rand() . '.' . $extension[1];
		$destination = 'images/' . $new_name;
		move_uploaded_file($_FILES['user_image']['tmp_name'], $destination);
		return $destination;
	}
}
function make_avatar($character)
{
    $path = "images/". time() . ".png";
	$image = imagecreate(200, 200);
	$red = rand(0, 255);
	$green = rand(0, 255);
	$blue = rand(0, 255);
    imagecolorallocate($image, $red, $green, $blue);  
    $textcolor = imagecolorallocate($image, 255,255,255);  
    imagettftext($image, 100, 0, 55, 150, $textcolor,'font/arial.ttf', $character);
    imagepng($image, $path);
    imagedestroy($image);
    return $path;
}

?>