<?php
class stathotel
{
	public $base_url = '';
	public $connect;
	public $query;
	public $statement;
	//public $pagetitle;

	function __construct()
	{
		$dsn   = 'mysql:host=localhost;dbname=gst_25_09_21';
		$user  = 'root';
		$pass  = '';
		try {
			$this->connect = new PDO($dsn, $user, $pass);
			$this->connect->setAttribute(
				PDO::ATTR_ERRMODE,
				PDO::ERRMODE_EXCEPTION
			);
			$this->connect->exec("SET CHARACTER SET UTF8");
			session_start();
		} catch (PDOException $e) {
			echo 'Failed to Connect' . $e->getMessage();
		}
	}

	function gettitle() 

	{
		global $pagetitle;

		if (isset($pagetitle)) 
			{
			echo $pagetitle;

			} else { echo 'MTA-STATHOTEL';} 
	}

	function execute($data = null)
	{
		$this->statement = $this->connect->prepare($this->query);
		if ($data) {
			$this->statement->execute($data);
		} else {
			$this->statement->execute();
		}
	}
	function row_count()
	{
		return $this->statement->rowCount();
	}

	function statement_result()
	{
		return $this->statement->fetchAll();
	}

	function get_result()
	{
		return $this->connect->query($this->query, PDO::FETCH_ASSOC);
	}

	function is_login()
	{
		if (isset($_SESSION['admin_id'])) {
			return true;
		}
		return false;
	}
	function is_master_user()
	{
		if (isset($_SESSION['admin_type'])) {
			if ($_SESSION["admin_type"] == 'Master') {
				return true;
			}
			return false;
		}
		return false;
	}
	function is_dta_user()
	{
		if (isset($_SESSION['admin_type'])) {
			if ($_SESSION["admin_type"] == 'Dta') {
				return true;
			}
			return false;
		}
		return false;
	}
	function is_hotel_user()
	{
		if (isset($_SESSION['admin_type'])) {
			if ($_SESSION["admin_type"] == 'Hotel') {
				return true;
			}
			return false;
		}
		return false;
	}
	function clean_input($string)
	{
		$string = trim($string);
		$string = stripslashes($string);
		$string = htmlspecialchars($string);
		return $string;
	}
	function load_visitor()
	{
		$this->query = "
SELECT * FROM visitor_table 
ORDER BY visitor_id DESC
";
		$result = $this->get_result();
		$output = '';
		foreach ($result as $row) {
			$output .= '<option value="' . $row["visitor_id"] . '">' . $row["visitor_name"] . '</option>';
		}
		return $output;
	}
	
	function load_section_arrive()
	{
		$this->query = " SELECT * FROM section_arrive 	";
		$result = $this->get_result();

		$output = '';
		foreach ($result as $row) {
			$output .= '<option value="' . $row["section_arrive_id"] . '">' . $row["nom_section_arrive"] . '</option>';
		}
		return $output;
	}
	
	//************************************************************* LOAD FOR MASTER ***********
	
	function total_etab()
	{
		$this->query = "
		SELECT * FROM etab_hebergement
		
		";
		if ($this->is_hotel_user()) {
			$this->query .= " WHERE etab_hebergement.etab_id ='" . $_SESSION["etab_id"] . "'";
		}
		$this->execute();
		return $this->row_count();
	}

	function total_etab_inactive()
	{
		$this->query = "
		SELECT * FROM etab_hebergement
		WHERE etab_hebergement.statut_service = 'Inactive'	";
		if ($this->is_hotel_user()) {
			$this->query .= " AND etab_hebergement.etab_id ='" . $_SESSION["etab_id"] . "'";
		}
		$this->execute();
		return $this->row_count();
	}
	function Get_total_today_visitor()
	{
		$this->query = "
		SELECT * FROM visitor_table 
		WHERE DATE(visitor_enter_time) = DATE(NOW())
		";

		if(!$this->is_master_user())
		{
			$this->query .= " AND visitor_enter_by ='".$_SESSION["admin_id"]."'";
		}

		$this->execute();
		return $this->row_count();
	}
	function load_cat_etab()
	{
		$this->query = "
		SELECT * FROM categorie_etab
		ORDER BY cat_etab ASC
		";
		$result = $this->get_result();
		$output = '';
		foreach ($result as $row) {
			$output .= '<option value="' . $row["cat_etab_id"] . '">' . $row["cat_etab"] . '</option>';
		}
		return $output;
	}
	

	function load_secteur_etab()
	{
		$this->query = "
		SELECT * FROM secteur_etab
		ORDER BY nom_secteur ASC
		";
		$result = $this->get_result();
		$output = '';
		foreach ($result as $row) {
			$output .= '<option value="' . $row["secteur_etab_id"] . '">' . $row["nom_secteur"] . '</option>';
		}
		return $output;
	}
	
		function load_vocation_etab()
		{
			$this->query = "
			SELECT * FROM vocation_etab
			ORDER BY nom_vocation ASC
			";
			$result = $this->get_result();
			$output = '';
			foreach ($result as $row) {
				$output .= '<option value="' . $row["vocation_id"] . '">' . $row["nom_vocation"] . '</option>';
			}
			return $output;
		}
		function load_type_etab()
		{
			$this->query = "
			SELECT * FROM type_etab
			ORDER BY nom_type_etab ASC
			";
			$result = $this->get_result();
			$output = '';
			foreach ($result as $row) {
				$output .= '<option value="' . $row["type_etab_id"] . '">' . $row["nom_type_etab"] . '</option>';
			}
			return $output;
		}

	function load_wilaya_for_master()
	{
		$this->query = "
		SELECT * FROM wilaya
		ORDER BY nom_wilaya ASC
		";
		$result = $this->get_result();
		$output = '';
		foreach ($result as $row) {
			$output .= '<option value="' . $row["wilaya_id"] . '">' . $row["nom_wilaya"] . '</option>';
		}
		return $output;
	}
	
	function load_etab_for_master()
	{
		$this->query = "
		SELECT * FROM etab_hebergement 
		ORDER BY etab_id DESC
		";
		$result = $this->get_result();
		$output = '';
		foreach ($result as $row) {
			$output .= '<option value="' . $row["etab_id"] . '">' . $row["denomination_ar"] . '</option>';
		}
		return $output;
	}
	function load_hotel_users_for_master()
	{
		$this->query = "
		SELECT * FROM admin_table 
		ORDER BY admin_id DESC
		";
		$result = $this->get_result();
		$output = '';
		foreach ($result as $row) {
			$output .= '<option value="' . $row["admin_id"] . '">' . $row["admin_name"] . '</option>';
		}
		return $output;
	}
	// END LOAD FOR MASTER ///////////////////////

	// START LOAD FOR DTA  ///////////////////////
	function load_wilaya_for_dta()
	{
		if (isset($_SESSION['wilaya_id'])) {
			$this->query = "
		SELECT * FROM wilaya
		WHERE wilaya.wilaya_id = '" . $_SESSION['wilaya_id'] . "' ";
			$result = $this->get_result();
			$output = '';
			foreach ($result as $row) {
				$output .= '<option value="' . $row["wilaya_id"] . '" readonly>' . $row["nom_wilaya"] . '</option>';
			}
			return $output;
		}
	}

	function load_cat_etab_for_dta()
	{
		$this->query = "
		SELECT * FROM categorie_etab
		ORDER BY cat_etab ASC
		";
		$result = $this->get_result();
		$output = '';
		foreach ($result as $row) {
			$output .= '<option value="' . $row["cat_etab"] . '">' . $row["cat_etab"] . '</option>';
		}
		return $output;
	}
	function load_wilaya()
	{
		 
			$this->query = "
		SELECT * FROM wilaya
		WHERE wilaya.wilaya_id = '" . $_SESSION['wilaya_id'] . "' ";
			$result = $this->get_result();
			$output = '';
			foreach ($result as $row) {
				$output .=  $row["nom_wilaya"] ;
			}
			return $output;
		
	}
	function load_hotel()
	{
		 
			$this->query = "
		SELECT * FROM etab_hebergement
		WHERE etab_hebergement.etab_id = '" . $_SESSION['etab_id'] . "' ";
			$result = $this->get_result();
			$output = '';
			foreach ($result as $row) {
				$output .=  $row["denomination_ar"] ;
			}
			return $output;
		
	}

	function load_etab_for_dta()
	{
		$this->query = "
		SELECT * FROM etab_hebergement 
		WHERE etab_hebergement.wilaya_ID = '" . $_SESSION['wilaya_id'] . "' 
		ORDER BY etab_id DESC
		";
		$result = $this->get_result();
		$output = '';
		foreach ($result as $row) {
			$output .= '<option value="' . $row["etab_id"] . '">' . $row["denomination_ar"] . '</option>';
		}
		return $output;
	}
	function load_hotel_users_for_dta()
	{
		$this->query = "
		SELECT * FROM admin_table 
		WHERE admin_table.wilaya_ID = '" . $_SESSION['wilaya_id'] . "'
		ORDER BY admin_id DESC
		";
		$result = $this->get_result();
		$output = '';
		foreach ($result as $row) {
			$output .= '<option value="' . $row["admin_id"] . '">' . $row["admin_name"] . '</option>';
		}
		return $output;
	}
	// END LOAD FOR DTA ///////////////////////
	// START LOAD FOR HOTEL   ///////////////////////
	function load_wilaya_for_hotel()
	{
		if (isset($_SESSION['etab_id'])) {
			$this->query = "
			SELECT * FROM wilaya
			INNER JOIN etab_hebergement ON etab_hebergement.wilaya_ID = wilaya.wilaya_id

			WHERE etab_hebergement.etab_id = '" . $_SESSION['etab_id'] . "' ";
			$result = $this->get_result();
			$output = '';
			foreach ($result as $row) {
				$output .= '<option value="' . $row["wilaya_id"] . '" readonly>' . $row["nom_wilaya"] . '</option>';
			}
			return $output;
		}
	}
	function load_etab_for_hotel()
	{
		$this->query = "
SELECT * FROM etab_hebergement 
WHERE etab_hebergement.etab_id = '" . $_SESSION['etab_id'] . "' 

";
		$result = $this->get_result();
		$output = '';
		foreach ($result as $row) {
			$output .= '<option value="' . $row["etab_id"] . '">' . $row["denomination_ar"] . '</option>';
		}
		return $output;
	}

	function load_hotel_users_for_hotel()
	{
		$this->query = "
SELECT * FROM admin_table 
INNER JOIN etab_hebergement ON admin_table.etab_ID = etab_hebergement.etab_id
WHERE admin_table.admin_id = '" . $_SESSION['admin_id'] . "' 

";
		$result = $this->get_result();
		$output = '';
		foreach ($result as $row) {
			$output .= '<option value="' . $row["admin_id"] . '">' . $row["admin_name"] . '</option>';
		}
		return $output;
	}
	function load_type_tourisme()
	{
		$this->query = "
SELECT * FROM agence_v_type_tourisme 
ORDER BY nom_type ASC
";
		$result = $this->get_result();
		$output = '';
		foreach ($result as $row) {
			$output .= '<option value="' . $row["type_id"] . '">' . $row["nom_type"] . '</option>';
		}
		return $output;
	}

	
	function load_activite_tourisme()
	{
		$this->query = "
SELECT * FROM agence_v_activite 
ORDER BY nom_activite ASC
";
		$result = $this->get_result();
		$output = '';
		foreach ($result as $row) {
			$output .= '<option value="' . $row["activite_id"] . '">' . $row["nom_activite"] . '</option>';
		}
		return $output;
	}
	function load_nation()
	{
		$this->query = "
SELECT * FROM nation 
ORDER BY nation.nom_nation ASC";
		$result = $this->get_result();
		$output = '';
		foreach ($result as $row) {
			$output .= '<option value="' . $row["nation_id"] . '">' . $row["nom_nation"] . '</option>';
		}
		return $output;
	}
	function load_continents()
	{
		$this->query = "
SELECT * FROM continent 

";
		$result = $this->get_result();
		$output = '';
		foreach ($result as $row) {
			$output .= '<option value="' . $row["continent_id"] . '">' . $row["nom_continent"] . '</option>';
		}
		return $output;
	}
	function load_agence_v_user()
	{
		if (isset($_SESSION['admin_id'])) {
			$this->query = "
SELECT * FROM agence_v_rap_tourisme 
INNER JOIN agence_v ON agence_v.agence_id = agence_v_rap_tourisme.Agence_ID
INNER JOIN admin_table ON admin_table.admin_id = agence_v.Admin_ID
WHERE agence_v.Admin_ID = '" . $_SESSION['admin_id'] . "' ;
ORDER BY agence_v_denom ASC
";
			$result = $this->get_result();
			$output = '';
			foreach ($result as $row) {
				$output .= '<option value="' . $row["agence_id"] . '" readonly>' . $row["agence_v_denom"] . '</option>';
			}
			return $output;
		}
	}
	function Get_profile_image()
	{
		$this->query = "
SELECT admin_profile FROM admin_table 
WHERE admin_id = '" . $_SESSION["admin_id"] . "'
";

		$result = $this->get_result();

		foreach ($result as $row) {
			return $row['admin_profile'];
		}
	}
	function Get_admin_name()
	{
		$this->query = "
			SELECT admin_name FROM admin_table 
			WHERE admin_id = '" . $_SESSION["admin_id"] . "'
			";
		$result = $this->get_result();
		foreach ($result as $row) {
			return $row['admin_name'];
		}
	}
	function Get_etab_name()
	{
		$this->query = "
			SELECT denomination_ar FROM etab_hebergement 
			WHERE etab_id = '" . $_SESSION["etab_id"] . "'
			";
		$result = $this->get_result();
		foreach ($result as $row) {
			return $row['denomination_ar'];
		}
	}
	function Get_total_today_agence_rap_tour()
	{
		$this->query = "
SELECT * FROM agence_v_rap_tourisme 
WHERE DAY(date_rapport) = DAY(DATE(NOW()))
";

		if (!$this->is_master_user()) {
			$this->query .= " AND Admin_ID ='" . $_SESSION["admin_id"] . "'";
		}
		$this->execute();
		return $this->row_count();
	}
	
	function Get_total_recent_month_agence_rap_tour()
	{
		$this->query = "
SELECT * FROM agence_v_rap_tourisme 
WHERE MONTH(date_rapport) = MONTH(DATE(NOW()) - INTERVAL 1 DAY)
";
		if (!$this->is_master_user()) {
			$this->query .= " AND Admin_ID ='" . $_SESSION["admin_id"] . "'";
		}
		$this->execute();
		return $this->row_count();
	}

	function is_sejour_0()
	{
		$this->query = "
SELECT * FROM stat_arrive " ;

	$this->query .= " WHERE stat_arrive.valeur_statut_sejour == 1 " ;
	return true;
	}	

//----------------------------------------------- FUNCTIONS FOR DATE--------------------------------------------------------------------------------------------
function Firstdayofnextsmonth($date){
	$date = new DateTime($date);
	$date->modify('first day of next month');
return $date->format('Y-m-d');
}
function get_firstdate_next_month()
	{
		$firstDayNextMonth = strtotime('first day of next month');
		// echo $firstDayNextMonth;
		$daysTilNextMonth = ($firstDayNextMonth - time()) / (24 * 3600);
		// ,echo $daysTilNextMonth;
		$firstDayNextMonth = date('Y-m-d', strtotime('first day of next month'));
		return $firstDayNextMonth ;
	}
	function get_date($date)
	{
		return $date;
	}
	function Get_first_date_last_month_date()
	{
		$month_ini = date("Y-m-d", mktime(0, 0, 0, date("m", strtotime("-1 month")), 1, date("Y", strtotime("-1 month"))));
		return $month_ini;
	}

	function Get_end_month_last_month_date()
	{
		$month_end = date("Y-m-d", mktime(0, 0, 0, date("m", strtotime("-1 month")), date("t", strtotime("-1 month")), date("Y", strtotime("-1 month"))));
		return $month_end;
	}

	function Get_firstdate_of_current_month_date()
	{
		$first_date = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
		return $first_date;
	}
	
	function Get_last_day_date_current_month_date()
	{
		$lastdate = date("Y-m-d", strtotime("last day of this month"));

		return  $lastdate;
	}

	// *************************************** RE-ADD STAT FUNCTION **********************
	function get_first_day_of_this_month()
	{
		// date = date("Y/m/d");
		// echo $date;
		$fDate = date("Y-m-d", strtotime("first day of this month"));
		return $fDate;
	}
	function get_last_date_of_spacific_date($a_date)
	{
		//$a_date = "2009/05/23";
		return date("Y-m-t", strtotime($a_date));
	}


	function get_total_days_of_current_month()
	{
		$total_days = Date('t');
		return $total_days;
	}

	function get_total_days_of_specific_month($a_date)
	{
		// $a_date = "2009/02/02";
		$a_date =  date("Y-m-t", strtotime($a_date));
		$index_month = date("m", strtotime($a_date)) + 0 ;
		$index_year = date("Y", strtotime($a_date)) + 0;
		//$index_days = date("j", strtotime($date)) + 0;
		return cal_days_in_month(CAL_GREGORIAN, $index_month, $index_year); // get total days of month
		
	}

	function get_day_of_current_month()
	{
		$today_day = Date('d');
		return $today_day;
	}

	function get_theday_of_specific_date($date)
	{
		$day = date("j", strtotime($date)) + 0 ; // conversion into string format
		return $day;
	}

	function diff_date($origin, $target)
	{

		$origin = new DateTime($origin);
		$target = new DateTime($target);
		$interval = $origin->diff($target);
		return $interval->format('%a');
	}
	function diff_date_for_sejour($origin, $target)
	{

		$origin = new DateTime($origin);
		$target = new DateTime($target);
		$interval = $origin->diff($target);
		return $interval->format('%a');
		
	}
	function Get_total_agence_v()
	{
		$this->query = "
SELECT * FROM agence_v 
";
		$this->execute();
		return $this->row_count();
	}
	function Get_total_etab_hotel()
	{
		$this->query = "
SELECT * FROM hotels 
";
		$this->execute();
		return $this->row_count();
	}
	function is_hotel_agent_user()
	{
		if (isset($_SESSION['admin_type'])) {
			if ($_SESSION["admin_type"] == 'Hotel_Agent') {
				return true;
			}
			return false;
		}
		return false;
	}
	// ****************************** FUNCTIONS FOR EDIT ****************************************
	function load_wilaya_for_edit()
	{
		$this->query = "
SELECT * FROM wilaya ";
		$result = $this->get_result();
		$output = '';
		foreach ($result as $row) {
			$output .= '<option value="' . $row["wilaya_id"] . '">' . $row["nom_wilaya"] . '</option>';
		}
		return $output;
	}
	function load_etab_for_edit()
	{
		$this->query = "
SELECT * FROM etab_hebergement ";
		$result = $this->get_result();
		$output = '';
		foreach ($result as $row) {
			$output .= '<option value="' . $row["etab_id"] . '">' . $row["denomination_ar"] . '</option>';
		}
		return $output;
	}
	function load_etab_for_user_edit()
	{
		$this->query = "
SELECT * FROM etab_hebergement 
WHERE etab_id = '" . $_SESSION["etab_id"] . "'
";
		$result = $this->get_result();
		$output = '';
		foreach ($result as $row) {
			$output .= '<option value="' . $row["etab_id"] . '">' . $row["denomination_ar"] . '</option>';
		}
		return $output;
	}
	function load_user_for_edit()
	{
		$this->query = "
SELECT * FROM admin_table ";
		$result = $this->get_result();
		$output = '';
		foreach ($result as $row) {
			$output .= '<option value="' . $row["admin_id"] . '">' . $row["admin_name"] . '</option>';
		}
		return $output;
	}
	function load_user_type_for_dta_user()
	{
		$this->query = "
		SELECT * FROM admin_table 
		WHERE admin_id = '" . $_SESSION["admin_id"] . "' ";
		$result = $this->get_result();
		$output = '';
		foreach ($result as $row) {
			$output .= '<option value="' . $row["admin_id"] . '">' . $row["admin_type"] . '</option>';
		}
		return $output;
	}
	function load_nation_for_edit()
	{
		$this->query = "
SELECT * FROM nation ";
		$result = $this->get_result();
		$output = '';
		foreach ($result as $row) {
			$output .= '<option value="' . $row["nation_id"] . '">' . $row["nom_nation"] . '</option>';
		}
		return $output;
	}
	function load_continent_for_edit()
	{
		$this->query = "
SELECT * FROM continent ";
		$result = $this->get_result();
		$output = '';
		foreach ($result as $row) {
			$output .= '<option value="' . $row["continent_id"] . '">' . $row["nom_continent"] . '</option>';
		}
		return $output;
	}
// ---------------------------------------------------------------------------------------------------------------------------------------------------------------------
// --------------------------------------------- NEXT MONTH ADD REPORT ------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------------------------------------------------------


// --- SUM FUNCTIONS GLOBAL BOXESS - ARRIVES-NUITE  ------------------------------------------------------------------------------------------------

function Get_sum_rooms()
 { 
		$query = "	SELECT SUM(etab_hebergement.chambre_total) AS total FROM  etab_hebergement " ;
		
		if($this->is_dta_user())
		{
			$query .= " 	
			WHERE etab_hebergement.wilaya_ID = '" . $_SESSION['wilaya_id'] . "'";
		}
		if($this->is_hotel_user() )
		{
			$query .= " WHERE etab_hebergement.etab_id = '" . $_SESSION['etab_id'] . "'";
		}
		$stmt = $this->connect->prepare($query);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$total = $this->total= $row['total'];
		if ( $total > 0) {
			return $total;
		}else {
			return 0;
		}
 }

 function Get_sum_beds()
 { 
		$query = "	SELECT SUM(etab_hebergement.capacite_lits) AS total FROM  etab_hebergement " ;
		
		if($this->is_dta_user())
		{
			$query .= " 	
			WHERE etab_hebergement.wilaya_ID = '" . $_SESSION['wilaya_id'] . "'";
		}
		if($this->is_hotel_user() )
		{
			$query .= " WHERE etab_hebergement.etab_id = '" . $_SESSION['etab_id'] . "'";
		}
		$stmt = $this->connect->prepare($query);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$total = $this->total= $row['total'];
		if ( $total > 0) {
			return $total;
		}else {
			return 0;
		}
 }
function Get_total_arrives($column, $section_id)
 {
	 	$firstd = $this->Get_firstdate_of_current_month_date();
		$lastd = $this->Get_last_day_date_current_month_date();
		$query = "	SELECT SUM($column) AS total FROM  stat_arrive 
		INNER JOIN section_arrive ON stat_arrive.section_arrive_ID = section_arrive.section_arrive_id
      	WHERE section_arrive.section_arrive_id = $section_id

		AND DATE(stat_arrive.date_arrive) >= '$firstd'  AND  DATE(stat_arrive.date_depart) <= '$lastd' ";
		
		if($this->is_dta_user())
		{
			$query .= " AND stat_arrive.wilaya_ID = '" . $_SESSION['wilaya_id'] . "'";
		}
		if($this->is_hotel_user() or $this->is_hotel_agent_user())
		{
			$query .= " AND stat_arrive.etab_ID = '" . $_SESSION['etab_id'] . "'";
		}
		$stmt = $this->connect->prepare($query);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$total = $this->$column = $row['total'];
		if ( $total > 0) {
			return $total;
		}else {
			return 0;
		}
 }
 function Get_total_arrives_by_cat_etab_section_arrive($nombre, $etoile, $setion)
 {
	 	$firstd = $this->Get_first_date_last_month_date();
		$lastd = $this->Get_end_month_last_month_date();
		$query = "	SELECT SUM($nombre) AS total FROM  stat_arrive 
		INNER JOIN etab_hebergement ON stat_arrive.etab_ID = etab_hebergement.etab_id
        INNER JOIN categorie_etab ON etab_hebergement.cat_etab_ID = categorie_etab.cat_etab_id
		INNER JOIN section_arrive ON stat_arrive.section_arrive_ID = section_arrive.section_arrive_id
        WHERE categorie_etab.cat_etab = '$etoile'
        AND nom_section_arrive = '$setion'  
		AND date_arrive BETWEEN '$firstd'  AND '$lastd' ";
		if($this->is_dta_user())
		{
			$query .= " AND stat_arrive.wilaya_ID = '" . $_SESSION['wilaya_id'] . "'";
		}
		if($this->is_hotel_user() or $this->is_hotel_agent_user())
		{
			$query .= " AND stat_arrive.etab_ID = '" . $_SESSION['etab_id'] . "'";
		}
		$stmt = $this->connect->prepare($query);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$total = $this->$nombre = $row['total'];
		if ( $total > 0) {
			return $total;
		}else {
			return 0;
		}
 }
//  ********************************************** NUITEE FUNCTIONS *******************************
 function Get_sum_nuitees($column, $section_id)
 {
	 	$firstd = $this->Get_firstdate_of_current_month_date();
		$lastd = $this->Get_last_day_date_current_month_date();
		$query = "	SELECT SUM($column) AS total FROM  stat_arrive 
		INNER JOIN section_arrive ON stat_arrive.section_arrive_ID = section_arrive.section_arrive_id
      	WHERE section_arrive.section_arrive_id = $section_id  
		AND date_arrive BETWEEN '$firstd'  AND '$lastd' ";
		
		if($this->is_dta_user())
		{
			$query .= " AND stat_arrive.wilaya_ID = '" . $_SESSION['wilaya_id'] . "'";
		}
		if($this->is_hotel_user() or $this->is_hotel_agent_user())
		{
			$query .= " AND stat_arrive.etab_ID = '" . $_SESSION['etab_id'] . "'";
		}
		$stmt = $this->connect->prepare($query);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$total = $this->$column = $row['total'];
		if ( $total > 0) {
			return $total;
		}else {
			return 0;
		}
 }

 function Get_total_nuitee_by_cat_etab_section_arrive($nuite_mois, $etoile, $setion)
 {
	 	$firstd = $this->Get_first_date_last_month_date();
		$lastd = $this->Get_end_month_last_month_date();
		$query = "	SELECT SUM($nombre) AS total FROM  stat_arrive 
		INNER JOIN etab_hebergement ON stat_arrive.etab_ID = etab_hebergement.etab_id
        INNER JOIN categorie_etab ON etab_hebergement.cat_etab_ID = categorie_etab.cat_etab_id
		INNER JOIN section_arrive ON stat_arrive.section_arrive_ID = section_arrive.section_arrive_id
        WHERE categorie_etab.cat_etab = '$etoile'
        AND nom_section_arrive = '$setion'  
		AND date_arrive BETWEEN '$firstd'  AND '$lastd' ";
		if($this->is_dta_user())
		{
			$query .= " AND stat_arrive.wilaya_ID = '" . $_SESSION['wilaya_id'] . "'";
		}
		if($this->is_hotel_user() or $this->is_hotel_agent_user())
		{
			$query .= " AND stat_arrive.etab_ID = '" . $_SESSION['etab_id'] . "'";
		}
		$stmt = $this->connect->prepare($query);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$total = $this->$nombre = $row['total'];
		if ( $total > 0) {
			return $total;
		}else {
			return 0;
		}
 }






}
