<?php
include('stathotel.php');
$arrive = new stathotel();
if(isset($_POST["action"]))
{
	if($_POST["action"] == 'fetch_doughnut_chart')
	{
	$output = array();
	$main_query =
	" SELECT categorie_etab.cat_etab, SUM(stat_arrive.nuite_mois) AS Total 
	FROM stat_arrive
	INNER JOIN etab_hebergement on etab_hebergement.etab_id = stat_arrive.etab_ID
	INNER JOIN categorie_etab ON categorie_etab.cat_etab_id = etab_hebergement.cat_etab_ID
	WHERE stat_arrive.date_arrive >= '" . $arrive->Get_firstdate_of_current_month_date() . "' AND stat_arrive.date_depart <= '" . $arrive->Get_last_day_date_current_month_date() . "'
	";
	if($arrive->is_dta_user()) {
		$main_query .= " AND stat_arrive.wilaya_ID = '" . $_SESSION['wilaya_id'] . "' ";

	}
	if($arrive->is_hotel_user()) {
		$main_query .= " AND stat_arrive.etab_ID = '" . $_SESSION['etab_id'] . "' ";

	}
	$main_query .= " GROUP BY categorie_etab.cat_etab ";
	$arrive->query = $main_query ;
	$arrive->execute();
	$result = $arrive->get_result();
	$arrive->query = $main_query;
	$arrive->execute();
	$data = array();
		foreach($result as $row)
		{
			$data[] = array(
				'cat_etab'		=>	$row["cat_etab"],
				'total'			=>	$row["Total"],
				'color'			=>	'#' . rand(100, 999) . ''
			);
		}
		echo json_encode($data);
	}
	if($_POST["action"] == 'fetch_bar_chart')
	{
	$main_query =
	" SELECT section_arrive.nom_section_arrive, SUM(stat_arrive.nuite_mois) AS Total 
	FROM stat_arrive
	INNER JOIN section_arrive ON stat_arrive.section_arrive_ID = section_arrive.section_arrive_id
	WHERE stat_arrive.date_arrive >= '" . $arrive->Get_firstdate_of_current_month_date() . "' AND stat_arrive.date_depart <= '" . $arrive->Get_last_day_date_current_month_date() . "'
	";
	if($arrive->is_dta_user()) {
		$main_query .= " AND stat_arrive.wilaya_ID = '" . $_SESSION['wilaya_id'] . "' ";

	}
	if($arrive->is_hotel_user()) {
		$main_query .= " AND stat_arrive.etab_ID = '" . $_SESSION['etab_id'] . "' ";

	}
	$main_query .= "GROUP BY section_arrive.nom_section_arrive ";
	$arrive->query = $main_query ;
	$arrive->execute();
	$result = $arrive->get_result();
	$arrive->query = $main_query;
	$arrive->execute();
	$data = array();
	foreach($result as $row)
	{
		$data[] = array(
			'nom_section_arrive'		=>	$row["nom_section_arrive"],
			'total'			=>	$row["Total"],
			'color'			=>	'#' . rand(100, 999) . ''
		);
	}
	echo json_encode($data);
	}
}
?>