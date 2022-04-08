<?php

include('stathotel.php');
$arrive = new stathotel();
include('db_config.php');
if (isset($_POST["action"])) {
    if ($_POST["action"] == 'fetch') {

        $order_column = array('stat_arrive.stat_id','stat_arrive.date_rap','stat_arrive.date_arrive','stat_arrive.date_depart',
        'stat_arrive.nuite_mois','nation.nom_nation','stat_arrive.nombre_arrive','admin_table.admin_name' ,
         'wilaya.nom_wilaya','section_arrive.nom_section_arrive');
        $output = array();
        $main_query = "	SELECT * FROM stat_arrive
        INNER JOIN section_arrive ON stat_arrive.section_arrive_ID = section_arrive.section_arrive_id
		INNER JOIN nation ON stat_arrive.nation_ID = nation.nation_id 
		INNER JOIN etab_hebergement ON stat_arrive.etab_id = etab_hebergement.etab_id
        INNER JOIN categorie_etab ON etab_hebergement.cat_etab_ID = categorie_etab.cat_etab_id
		INNER JOIN admin_table ON stat_arrive.user_ID = admin_table.admin_id
		INNER JOIN wilaya ON stat_arrive.wilaya_ID = wilaya.wilaya_id ";
        if ($arrive->is_dta_user()) 
        {   $main_query .= "
                            WHERE admin_table.wilaya_ID =  '" . $_SESSION["wilaya_id"] . "' ";
                            // filter All ---------
                            if ($_POST["from_date"] != '' and $_POST["filter_section"] != '' and $_POST["filter_nation"] != '' and $_POST["filter_etab_dta"] != '') 
                            {
                                $search_query = "
                                AND etab_hebergement.etab_id = '" . $_POST["filter_etab_dta"] ."'
                                AND section_arrive.section_arrive_id = '" . $_POST["filter_section"] ."'
                                AND nation.nation_id = '" . $_POST["filter_nation"] ."'
                                AND DATE(stat_arrive.date_arrive) BETWEEN '" . $_POST["from_date"] ."' AND  '" . $_POST["to_date"] . "'
                                AND ( ";
                            }
                             // filter Etab + Section + date ---------
                             if ($_POST["from_date"] != '' and $_POST["filter_section"] != '' and $_POST["filter_etab_dta"] != '') 
                             {
                                 $search_query = "
                                 AND etab_hebergement.etab_id = '" . $_POST["filter_etab_dta"] ."'
                                 AND section_arrive.section_arrive_id = '" . $_POST["filter_section"] ."'
                                 AND DATE(stat_arrive.date_arrive) BETWEEN '" . $_POST["from_date"] ."' AND  '" . $_POST["to_date"] . "'
                                 AND ( 
                             ";
                             }
                            // filter date with etab Only ---------
                            elseif ($_POST["from_date"] != '' and $_POST["filter_etab_dta"] != ''  ) { 
                                $search_query = " 
                                AND etab_hebergement.etab_id = '" . $_POST["filter_etab_dta"] ."'
                                AND DATE(stat_arrive.date_arrive) BETWEEN '" . $_POST["from_date"] ."' AND  '" . $_POST["to_date"] . "'
                                AND ( ";
                            }
                            // filter date with section only ---------
                            elseif ($_POST["from_date"] != '' and $_POST["filter_section"] != ''  ) { 
                                $search_query = " 
                                AND section_arrive.section_arrive_id = '" . $_POST["filter_section"] ."'
                                AND DATE(stat_arrive.date_arrive) BETWEEN '" . $_POST["from_date"] ."' AND  '" . $_POST["to_date"] . "'
                                AND ( ";
                            }
                            // filter date with nation only ---------
                            elseif ($_POST["from_date"] != '' and $_POST["filter_nation"] != ''  ) {
                                $search_query = " 
                                AND nation.nation_id = '" . $_POST["filter_nation"] ."'
                                AND DATE(stat_arrive.date_arrive) BETWEEN '" . $_POST["from_date"] ."' AND  '" . $_POST["to_date"] . "'                
                                AND ( ";
                            }
                            // filter date only ---------        
                            elseif ($_POST["from_date"] != '' ) {           
                                $search_query = " AND DATE(stat_arrive.date_arrive) BETWEEN '" . $_POST["from_date"] ."' AND  '" . $_POST["to_date"] . "'
                                AND ( ";
                            }
                            // filter section with nation  ---------        
                            elseif ( $_POST["filter_section"] != '' and $_POST["filter_nation"] != '') {
                                
                                $search_query = " 
                                AND section_arrive.section_arrive_id = '" . $_POST["filter_section"] ."'
                                AND nation.nation_id = '" . $_POST["filter_nation"] ."'
                                AND ( ";
                            }
                            elseif ( $_POST["filter_section"] != '') {
                                
                                $search_query = " 
                                AND section_arrive.section_arrive_id = '" . $_POST["filter_section"] ."'
                                AND ( ";
                            }
                            elseif ( $_POST["filter_nation"] != '') {
                                
                                $search_query = " 
                                AND nation.nation_id = '" . $_POST["filter_nation"] ."'
                                AND ( ";
                            }
                            elseif ( $_POST["filter_etab_dta"] != '') {
                                
                                $search_query = " 
                                AND etab_hebergement.etab_id = '" . $_POST["filter_etab_dta"] ."'
                                AND ( ";
                            }
            
            else {
                $search_query = " AND ( ";
            }
        }
// START--- HOTEL USER----------------------------------------------------------- 
        elseif ($arrive->is_hotel_user()) {
            $main_query .= "  WHERE etab_hebergement.etab_id =  '" . $_SESSION["etab_id"] . "' 
			";
			if ($_POST["from_date"] != '' and $_POST["filter_section"] != '' and $_POST["filter_nation"] != '') 
			{
                $search_query = "
				AND section_arrive.section_arrive_id = '" . $_POST["filter_section"] ."'
				AND nation.nation_id = '" . $_POST["filter_nation"] ."'
                AND DATE(stat_arrive.date_arrive) BETWEEN '" . $_POST["from_date"] ."' AND  '" . $_POST["to_date"] . "'
				AND ( 
			";
            } 
			elseif ($_POST["from_date"] != '' and $_POST["filter_section"] != ''  ) { 
				$search_query = " 
				AND section_arrive.section_arrive_id = '" . $_POST["filter_section"] ."'
				AND DATE(stat_arrive.date_arrive) BETWEEN '" . $_POST["from_date"] ."' AND  '" . $_POST["to_date"] . "'
				AND ( ";
			}
			elseif ($_POST["from_date"] != '' and $_POST["filter_nation"] != ''  ) {
				$search_query = " 
				AND nation.nation_id = '" . $_POST["filter_nation"] ."'
				AND DATE(stat_arrive.date_arrive) BETWEEN '" . $_POST["from_date"] ."' AND  '" . $_POST["to_date"] . "'

				AND ( ";
			}
			elseif ($_POST["from_date"] != '' ) {
                
				$search_query = " AND DATE(stat_arrive.date_arrive) BETWEEN '" . $_POST["from_date"] ."' AND  '" . $_POST["to_date"] . "'
				AND ( ";
			}
            elseif ( $_POST["filter_section"] != '' and $_POST["filter_nation"] != '') {
                
				$search_query = " 
                AND section_arrive.section_arrive_id = '" . $_POST["filter_section"] ."'
				AND nation.nation_id = '" . $_POST["filter_nation"] ."'
				AND ( ";
			}
			elseif ( $_POST["filter_section"] != '') {
                
				$search_query = " 
				AND section_arrive.section_arrive_id = '" . $_POST["filter_section"] ."'
				AND ( ";
			}
          
			elseif ( $_POST["filter_nation"] != '') {
                
				$search_query = " 
				AND nation.nation_id = '" . $_POST["filter_nation"] ."'
				AND ( ";
			}
           
			else 
			{
                $search_query = " AND ( ";
            }
        } 
// START--- MASTER USER----------------------------------------------------------- 
        elseif ($arrive->is_master_user()) {

            $main_query .= "
            WHERE stat_arrive.valeur_statut_raport =  1 ";
            
            if ($_POST["from_date"] != '') {
                $search_query = "WHERE DATE(stat_arrive.date_arrive) BETWEEN '" . $_POST["from_date"] . "' AND  '" . $_POST["to_date"] . "'
							AND ( ";
            } else {
                $search_query = "AND ";
            }
        }
        if (isset($_POST["search"]["value"])) {
            if ($arrive->is_dta_user() or $arrive->is_hotel_user()) {
            $search_query .= 'stat_arrive.stat_id LIKE "%' . $_POST["search"]["value"] . '%" ';
            $search_query .= 'OR stat_arrive.nombre_arrive LIKE "%' . $_POST["search"]["value"] . '%" ';
            $search_query .= 'OR etab_hebergement.denomination_ar LIKE "%' . $_POST["search"]["value"] . '%" ';
            $search_query .= 'OR admin_table.admin_name LIKE "%' . $_POST["search"]["value"] . '%" ';
            $search_query .= 'OR wilaya.nom_wilaya LIKE "%' . $_POST["search"]["value"] . '%" ';
            $search_query .= 'OR section_arrive.nom_section_arrive LIKE "%' . $_POST["search"]["value"] . '%" ';
            $search_query .= 'OR nation.nom_nation LIKE "%' . $_POST["search"]["value"] . '%" ';
            }
            if ($arrive->is_master_user()) {
                $search_query .= 'wilaya.nom_wilaya LIKE "%' . $_POST["search"]["value"] . '%" ';
            
                if ($_POST["from_date"] != '') {
                    $search_query .= ') ';
                }

            } else {
                $search_query .= ') ';
            }
        }
        if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
            $order_query = 'ORDER BY stat_arrive.stat_id DESC ';
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
        $total_arrive = 0;
        $total_nuitee = 0;
        foreach ($result as $row) {
        $sub_array = array();
        $sub_array[] = $row["stat_id"];
        $sub_array[] = $row["denomination_ar"];
        $sub_array[] = $row["nom_section_arrive"];
        $sub_array[] = $row["nom_nation"];
        $sub_array[] = $row["nombre_arrive"];
        $sub_array[] = $row["nuite_mois"];
        $nuite_reste = "";
        if ($row["nuite_reste"] > 0) {
        $nuite_reste = '<span  style="font: size 10px; color: red;">' . $row["nuite_reste"] . '</span>';
        } else {
        $nuite_reste = '<span style="font: size 10px; color: green;">' . $row["nuite_reste"] . '</span>';
        }
        $sub_array[] = $nuite_reste;
        $sub_array[] = $row["date_arrive"];
        $sub_array[] = $row["date_depart"];
        $sub_array[] = $row["date_rap"];
        $statut_sejour = "";
        if ($row["valeur_statut_sejour"] == 1) {
        $statut_sejour = '<span class="badge badge-success" style="font: size 10px;">إقامة مكتملة</span>';
        } else {
        $statut_sejour = '<span class="badge badge-warning" style="font: size 10px;">إقامة جزئية</span>';
        }
        $sub_array[] = $statut_sejour;

        $ref_rap = '<span style="font: size 10px; background-color: #e9ecef;">' . $row["ref_rap"] . '</span>';
        $sub_array[] =  $ref_rap;
        // $total_order = $total_order + floatval($row["nombre_arrive"]);
        $total_arrive = $total_arrive + ($row["nombre_arrive"]) ;
        $total_nuitee = $total_nuitee + ($row["nuite_mois"]) ;
        $data[] = $sub_array;
        }
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $total_rows,
            "recordsFiltered"   =>  $filtered_rows,
            "data"              =>  $data,
            "total_arrive"      =>  $total_arrive, 
            "total_nuitee"      =>  $total_nuitee
            // "total" => number_format($total_order, 2)
        );
        echo json_encode($output);
    }
    
// ///////////////////////////// SLECT BOX DEPENDENCY SECTION ARRIVE ////////////////////////
if (isset($_POST['sectionId']) && !empty($_POST['sectionId'])) {
    $query = "SELECT * FROM nation WHERE section_arrive_ID = " . $_POST['sectionId'];
    $result = $con->query($query);

    if ($result->num_rows > 0) {
        echo '<option value="">اختر ...</option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['nation_id'] . '">' . $row['nom_nation'] . '</option>';
        }
    } else {
        $query = "SELECT * FROM nation ";
        $result = $con->query($query);

        if ($result->num_rows > 0) {
            echo '<option value="">اختر البلد ...</option>';
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['nation_id'] . '">' . $row['nom_nation'] . '</option>';
            }
        }
    }
} 

// // ///////////////////////////// EDIT SLECT BOX DEPENDENCY SECTION ARRIVE ////////////////////////
if (isset($_POST['sectionID']) && !empty($_POST['sectionID'])) {
    $query = "SELECT * FROM nation WHERE section_arrive_ID = " . $_POST['sectionID'];
    $result = $con->query($query);
    if ($result->num_rows > 0) {
        echo '<option value="">اختر ...</option>';
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['nation_id'] . '">' . $row['nom_nation'] . '</option>';
        }
    } else {
        $query = "SELECT * FROM nation ";
        $result = $con->query($query);

        if ($result->num_rows > 0) {
            echo '<option value="">اختر البلد ...</option>';
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['nation_id'] . '">' . $row['nom_nation'] . '</option>';
            }
        }
    }
}
}
?>