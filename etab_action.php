<?php
include('stathotel.php');
$arrive = new stathotel();
if(isset($_POST["action"]))
{
	if($_POST["action"] == 'fetch')
	{
		$order_column = array('etab_hebergement.etab_id', 'etab_hebergement.denomination_ar', 'wilaya.nom_wilaya');

		$output = array();

		$main_query = "
		SELECT * FROM etab_hebergement
        INNER JOIN categorie_etab ON etab_hebergement.cat_etab_ID = categorie_etab.cat_etab_id
        INNER JOIN secteur_etab ON etab_hebergement.secteur_ID  = secteur_etab.secteur_etab_id
        INNER JOIN type_etab ON etab_hebergement.type_etab_ID = type_etab.type_etab_id
        INNER JOIN vocation_etab ON etab_hebergement.vocation_ID = vocation_etab.vocation_id  
        INNER JOIN wilaya ON etab_hebergement.wilaya_ID = wilaya.wilaya_id 
        ";
		if ($arrive->is_dta_user()) {
            $main_query .= "
							WHERE etab_hebergement.wilaya_ID =  '" . $_SESSION["wilaya_id"] . "' ";
        }
       
		$search_query = '';
		if(isset($_POST["search"]["value"]))
		{
			$search_query .= 'AND (etab_hebergement.etab_id LIKE "%'.$_POST["search"]["value"].'%" ';
			 $search_query .= 'OR etab_hebergement.denomination_ar LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR wilaya.nom_wilaya LIKE "%'.$_POST["search"]["value"].'%" ';
			// $search_query .= 'OR admin_created_on LIKE "%'.$_POST["search"]["value"].'%" ) ';
		}

       
        $search_query .= ') ';

        if (isset($_POST["order"])) {
        $order_query = 'ORDER BY ' . $order_column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
        }
        else {
            $order_query = 'ORDER BY etab_hebergement.etab_id DESC ';
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
		{	$sub_array = array();
            $sub_array[] = $row["etab_id"];
			$Status_button = '';
			if($row["statut_service"] == 'Active')
			{
				$Status_button = '<button type="button" name="delete_button" class="btn btn-primary btn-sm delete_button" data-id="'.$row["etab_id"].'" data-status="'.$row["statut_service"].'">'.$row["statut_service"].'</button>';
			}
			else
			{
				$Status_button = '<button type="button" name="delete_button" class="btn btn-danger btn-sm delete_button" data-id="'.$row["etab_id"].'" data-status="'.$row["statut_service"].'">'.$row["statut_service"].'</button>';
			}
			$sub_array[] = '
			<div align="center">
			'.$Status_button.'
			</div>';
            $sub_array[] = $row["denomination_ar"];
			$sub_array[] = $row["denomination_fr"];
			$sub_array[] = $row["num_agrement"];
			$sub_array[] = $row["date_attribution"];
            $sub_array[] = $row["adresse"];
            $sub_array[] = $row["tel_fax"];
            $sub_array[] = $row["email"];
            $sub_array[] = $row["site_web"];
			$sub_array[] = $row["chambre_total"];
            $sub_array[] = $row["nombre_chambre_double"];
            $sub_array[] = $row["nombre_chambre_triple"];
            $sub_array[] = $row["capacite_lits"];
            $sub_array[] = $row["prix_moyen_chambre"];
            $sub_array[] = $row["capacite_couvert"];
            $sub_array[] = $row["nombre_couvert_vendu"];
            $sub_array[] = $row["taux_couvert_vendu"];
            $sub_array[] = $row["coordonnees_GPS_x"];
            $sub_array[] = $row["coordonnees_GPS_y"];
            $sub_array[] = $row["nom_proprietaire"];
            $sub_array[] = $row["prenom_proprietaire"];
            $sub_array[] = $row["date_naiss_proprietaire"];
            $sub_array[] = $row["lieu_naiss_proprietaire"];
            $sub_array[] = $row["prenom_pere_proprietaire"];
            $sub_array[] = $row["nom_mere_proprietaire"];
            $sub_array[] = $row["prenom_mere_proprietaire"];
            $sub_array[] = $row["adresse_proprietaire"];
            $sub_array[] = $row["tel_mobile_proprietaire"];
            $sub_array[] = $row["email_proprietaire"];
            $sub_array[] = $row["created_at"];
            $sub_array[] = $row["cat_etab"];
            $sub_array[] = $row["nom_secteur"];
            $sub_array[] = $row["nom_vocation"];
            $sub_array[] = $row["nom_type_etab"];
            $sub_array[] = $row["nom_wilaya"];
            $delete_button = '';
			$sub_array[] = '
			<div align="center">
			<button type="button" name="edit_button" class="btn btn-warning btn-sm edit_button" data-id="'.$row["etab_id"].'"><i class="fas fa-edit"></i></button>
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
			':nom_etab_ar'					=>	$arrive->clean_input($_POST["nom_etab_ar"]),
			':nom_etab_fr'					=>	$arrive->clean_input($_POST["nom_etab_fr"]),
			':num_agrement'					=>	$_POST["num_agrement"],
			':date_agrement'				=>	$_POST["date_agrement"],
			':adresse'						=>	$_POST["adresse"],
			':tel_fax'						=>	$_POST["tel_fax"],
			':etab_email'					=>	$_POST["etab_email"],
			':site_web'						=>	$_POST["site_web"],
			':nbr_ch_s'						=>	$_POST["nbr_ch_s"],
			':nbr_ch_d'						=>	$_POST["nbr_ch_d"],
			':nbr_ch_t'						=>	$_POST["nbr_ch_t"],
			':nbr_lits'						=>	$_POST["nbr_lits"],
			':prix_chambre'					=>	$_POST["prix_chambre"],
			':capacite_couvert'				=>	$_POST["capacite_couvert"],
			':capacite_couvert_vendu'		=>	$_POST["capacite_couvert_vendu"],
			':Coordonnees_GPS_X'			=>	$_POST["Coordonnees_GPS_X"],
			':Coordonnees_GPS_Y'			=>	$_POST["Coordonnees_GPS_Y"],
			':nom_prop'						=>	$_POST["nom_prop"],
			':prenom_prop'					=>	$_POST["prenom_prop"],
			':date_naiss_prop'				=>	$_POST["date_naiss_prop"],
			':lieu_naiss_prop'				=>	$_POST["lieu_naiss_prop"],
			':prenom_pere_prop'				=>	$_POST["prenom_pere_prop"],
			':nom_mere_prop'				=>	$_POST["nom_mere_prop"],
			':prenom_mere_prop'				=>	$_POST["prenom_mere_prop"],
			':adresse_prop'					=>	$_POST["adresse_prop"],
			':mobile_prop'					=>	$_POST["mobile_prop"],
			':prop_email'					=>	$_POST["prop_email"],
			':cat_etab'						=>	$_POST["cat_etab"],
			':secteur_etab'					=>	$_POST["secteur_etab"],
			':vocation_etab'				=>	$_POST["vocation_etab"],
			':type_etab'					=>	$_POST["type_etab"],
			':wilaya'						=>	$_SESSION['wilaya_id']
			);
			$arrive->query = "
			INSERT INTO etab_hebergement
			(denomination_ar,denomination_fr,num_agrement,
			date_attribution,
			adresse,tel_fax,email,site_web,
			chambre_total, 	
			nombre_chambre_double, 		
			nombre_chambre_triple, 		
			capacite_lits,
			prix_moyen_chambre, 			
			capacite_couvert,   			
			nombre_couvert_vendu,	 	
			coordonnees_GPS_x,			
			coordonnees_GPS_y,			
			nom_proprietaire,			
			prenom_proprietaire,		
			date_naiss_proprietaire,
			lieu_naiss_proprietaire,
			prenom_pere_proprietaire,
			nom_mere_proprietaire, 
			prenom_mere_proprietaire,
			adresse_proprietaire, 
			tel_mobile_proprietaire,
			email_proprietaire,
			cat_etab_ID, 
			secteur_ID, 
			vocation_ID,
			type_etab_ID,
			wilaya_ID
			)
			VALUES 
			(:nom_etab_ar,:nom_etab_fr,:num_agrement,
			:date_agrement,
			:adresse,:tel_fax,:etab_email,:site_web,
			:nbr_ch_s,
			:nbr_ch_d,
			:nbr_ch_t,
			:nbr_lits,
			:prix_chambre,
			:capacite_couvert,
			:capacite_couvert_vendu,
			:Coordonnees_GPS_X,		
			:Coordonnees_GPS_Y,
			:nom_prop,
			:prenom_prop,
			:date_naiss_prop,
			:lieu_naiss_prop,
			:prenom_pere_prop,
			:nom_mere_prop,
			:prenom_mere_prop,
			:adresse_prop,
			:mobile_prop,
			:prop_email,
			:cat_etab,
			:secteur_etab,
			:vocation_etab,
			:type_etab,
			:wilaya
			)
			";
			$arrive->execute($data);
			echo '<div class="alert alert-success">تم اضافة المؤسسة الفندقية بنجاح</div>';	
	}
	
	
	
	if($_POST["action"] == 'fetch_single')
	{
		$arrive->query = " SELECT * FROM etab_hebergement
        INNER JOIN categorie_etab ON etab_hebergement.cat_etab_ID = categorie_etab.cat_etab_id
        INNER JOIN secteur_etab ON etab_hebergement.secteur_ID  = secteur_etab.secteur_etab_id
        INNER JOIN type_etab ON etab_hebergement.type_etab_ID = type_etab.type_etab_id
        INNER JOIN vocation_etab ON etab_hebergement.vocation_ID = vocation_etab.vocation_id  
        INNER JOIN wilaya ON etab_hebergement.wilaya_ID = wilaya.wilaya_id 
        WHERE etab_id = '".$_POST["etab_id"]."' ";
		$result = $arrive->get_result();
		$data = array();
		foreach($result as $row)
		{	
		$data['nom_etab_ar'] 			= $row['denomination_ar'];
		$data['nom_etab_fr'] 			= $row['denomination_fr'];
		$data['num_agrement'] 			= $row['num_agrement'];
		$data['date_agrement'] 			= $row['date_attribution'];
		$data['adresse'] 				= $row['adresse'];
		$data['tel_fax'] 				= $row['tel_fax'];
		$data['etab_email'] 			= $row['email'];
		$data['site_web'] 				= $row['site_web'];
		$data['nbr_ch_s'] 				= $row['chambre_total'];
		$data['nbr_ch_d'] 				= $row['nombre_chambre_double'];
		$data['nbr_ch_t'] 				= $row['nombre_chambre_triple'];
		$data['nbr_lits'] 				= $row['capacite_lits'];
		$data['prix_chambre'] 			= $row['prix_moyen_chambre'];
		$data['capacite_couvert'] 		= $row['capacite_couvert'];
		$data['capacite_couvert_vendu'] = $row['nombre_couvert_vendu'];
		$data['Coordonnees_GPS_X'] 		= $row['coordonnees_GPS_x'];
		$data['Coordonnees_GPS_Y'] 		= $row['coordonnees_GPS_y'];
		$data['nom_prop'] 				= $row['nom_proprietaire'];
		$data['prenom_prop'] 			= $row['prenom_proprietaire'];
		$data['date_naiss_prop'] 		= $row['date_naiss_proprietaire'];
		$data['lieu_naiss_prop'] 		= $row['lieu_naiss_proprietaire'];
		$data['prenom_pere_prop'] 		= $row['prenom_pere_proprietaire'];
		$data['nom_mere_prop'] 			= $row['nom_mere_proprietaire'];
		$data['prenom_mere_prop'] 		= $row['prenom_mere_proprietaire'];
		$data['adresse_prop'] 			= $row['adresse_proprietaire'];
		$data['mobile_prop'] 			= $row['tel_mobile_proprietaire'];
		$data['prop_email'] 			= $row['email_proprietaire'];
		$data['cat_etab'] 				= $row['cat_etab_ID'];
		$data['secteur_etab'] 			= $row['secteur_ID'];
		$data['vocation_etab'] 			= $row['vocation_ID'];
		$data['type_etab'] 				= $row['type_etab_ID'];
		}
		echo json_encode($data);
	}
	if($_POST["action"] == 'Edit')
	{
		$data = array
		(
		':nom_etab_ar'					=>	$arrive->clean_input($_POST["nom_etab_ar"]),
		':nom_etab_fr'					=>	$arrive->clean_input($_POST["nom_etab_fr"]),
		':num_agrement'					=>	$arrive->clean_input($_POST["num_agrement"]),
		':date_agrement'				=>	$arrive->clean_input($_POST["date_agrement"]),
		':adresse'						=>	$_POST["adresse"],
		':tel_fax'						=>	$_POST["tel_fax"],
		':etab_email'					=>	$_POST["etab_email"],
		':site_web'						=>	$_POST["site_web"],
		':nbr_ch_s'						=>	$_POST["nbr_ch_s"],
		':nbr_ch_d'						=>	$_POST["nbr_ch_d"],
		':nbr_ch_t'						=>	$_POST["nbr_ch_t"],
		':nbr_lits'						=>	$_POST["nbr_lits"],
		':prix_chambre'					=>	$_POST["prix_chambre"],
		':capacite_couvert'				=>	$_POST["capacite_couvert"],
		':capacite_couvert_vendu'		=>	$_POST["capacite_couvert_vendu"],
		':Coordonnees_GPS_X'			=>	$_POST["Coordonnees_GPS_X"],
		':Coordonnees_GPS_Y'			=>	$_POST["Coordonnees_GPS_Y"],
		':nom_prop'						=>	$_POST["nom_prop"],
		':prenom_prop'					=>	$_POST["prenom_prop"],
		':date_naiss_prop'				=>	$_POST["date_naiss_prop"],
		':lieu_naiss_prop'				=>	$_POST["lieu_naiss_prop"],
		':prenom_pere_prop'				=>	$_POST["prenom_pere_prop"],
		':nom_mere_prop'				=>	$_POST["nom_mere_prop"],
		':prenom_mere_prop'				=>	$_POST["prenom_mere_prop"],
		':adresse_prop'					=>	$_POST["adresse_prop"],
		':mobile_prop'					=>	$_POST["mobile_prop"],
		':prop_email'					=>	$_POST["prop_email"],
		':cat_etab'						=>	$_POST["cat_etab"],
		':secteur_etab'					=>	$_POST["secteur_etab"],
		':vocation_etab'				=>	$_POST["vocation_etab"],
		':type_etab'					=>	$_POST["type_etab"]
		);
		$arrive->query = "
		UPDATE etab_hebergement 
		SET 
		denomination_ar 			= :nom_etab_ar,
		denomination_fr 			= :nom_etab_fr,
		num_agrement 				= :num_agrement,
		date_attribution 			= :date_agrement,
		adresse 					= :adresse,
		tel_fax 					= :tel_fax,
		email 						= :etab_email,
		site_web 					= :site_web,
		chambre_total			 	= :nbr_ch_s,
		nombre_chambre_double 		= :nbr_ch_d,
		nombre_chambre_triple 		= :nbr_ch_t,
		capacite_lits 				= :nbr_lits,
		prix_moyen_chambre 			= :prix_chambre,
		capacite_couvert   			= :capacite_couvert,
		nombre_couvert_vendu	 	= :capacite_couvert_vendu,
		coordonnees_GPS_x			= :Coordonnees_GPS_X,		
		coordonnees_GPS_y			= :Coordonnees_GPS_Y,
		nom_proprietaire			= :nom_prop,
		prenom_proprietaire			= :prenom_prop,
		date_naiss_proprietaire		= :date_naiss_prop,
		lieu_naiss_proprietaire		= :lieu_naiss_prop,
		prenom_pere_proprietaire	= :prenom_pere_prop,
		nom_mere_proprietaire 		= :nom_mere_prop,
		prenom_mere_proprietaire 	= :prenom_mere_prop,
		adresse_proprietaire 		= :adresse_prop,
		tel_mobile_proprietaire 	= :mobile_prop,
		email_proprietaire 			= :prop_email,
		cat_etab_ID 				= :cat_etab,
		secteur_ID 					= :secteur_etab,
		vocation_ID 				= :vocation_etab,
		type_etab_ID 				= :type_etab
		WHERE etab_id = '".$_POST['hidden_id']."'
		";
		$arrive->execute($data);
			echo '<div class="alert alert-success">تم تحديث تفاصيل المؤسسة !</div>';
	}

// ------------------------------------------- DELETE -----------------------------
	if($_POST["action"] == 'delete')
	{
		$data = array(
			':statut_service'		=>	$_POST['next_status']
		);
		$arrive->query = "
		UPDATE etab_hebergement 
		SET statut_service = :statut_service 
		WHERE etab_id = '".$_POST["id"]."'
		";
		$arrive->execute($data);
		echo '<div class="alert alert-success">تغيير حالة المؤسسة إلى '.$_POST['next_status'].'</div>';
	}
// ------------------------------------------- PROFILE EDIT -----------------------------

if($_POST["action"] == 'profile')
	{	sleep(1);
		$error = '';
		$success = '';
		$admin_name = '';
		$admin_contact_no = '';
		$admin_email = '';
		$admin_profile = '';
	
		$data = array(
			':admin_email'	=>	$_POST["admin_email"],
			':etab_id'		=>	$_POST['hidden_id']
		);
		$arrive->query = "
		SELECT * FROM admin_table 
		WHERE admin_email = :admin_email 
		AND etab_id != :etab_id
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
			WHERE etab_id = '".$_POST['hidden_id']."'
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
		WHERE etab_id = '".$_SESSION["etab_id"]."'
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
				WHERE etab_id = '".$_SESSION["etab_id"]."'
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