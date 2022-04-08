<?php

include('stathotel.php');
$arrive = new stathotel();
include('db_config.php');
if (isset($_POST["action"])) {
    if ($_POST["action"] == 'fetch') {

        $output = array();
        $main_query = "	SELECT SUM((stat_arrive.nuite_mois)) as 'المجموع العام', 
        SUM((CASE WHEN section_arrive.section_arrive_id = 1 THEN stat_arrive.nuite_mois ELSE 0 END)) AS 'الاجانب المقيمون', 
        SUM((CASE WHEN section_arrive.section_arrive_id = 2 THEN stat_arrive.nuite_mois ELSE 0 END)) AS 'الجزائريون المقيمون', 
        SUM((CASE WHEN section_arrive.section_arrive_id = 3 THEN stat_arrive.nuite_mois ELSE 0 END)) AS 'الاجانب غير المقيمون', 
        SUM((CASE WHEN section_arrive.section_arrive_id = 4 THEN stat_arrive.nuite_mois ELSE 0 END)) AS 'الجزائريون غير المقيمون'
        FROM stat_arrive
        INNER JOIN wilaya on stat_arrive.wilaya_ID = wilaya.wilaya_id
        INNER JOIN etab_hebergement on etab_hebergement.etab_id = stat_arrive.etab_ID
        INNER JOIN categorie_etab ON categorie_etab.cat_etab_id = etab_hebergement.cat_etab_ID
        INNER JOIN section_arrive ON section_arrive.section_arrive_id = stat_arrive.section_arrive_ID
         ";
        if ($arrive->is_dta_user()) 
        {  

            $main_query .= "
            WHERE  wilaya.wilaya_id =  '" . $_SESSION["wilaya_id"] . "' ";

                            if ($_POST["from_date"] != '' and $_POST["to_date"] != '' and  $_POST["filter_cat_etab"] != '') 
                            {
                                $search_query = "
                                
                                AND DATE(stat_arrive.date_arrive) >= '" . $_POST["from_date"] ."'  AND  DATE(stat_arrive.date_depart) <= '" . $_POST["to_date"] . "'
                                AND categorie_etab.cat_etab =  '" . $_POST["filter_cat_etab"] ."'
                                
                                AND ( ";
                            }
                            elseif ($_POST["from_date"] != '') 
                            {
                                $search_query = "
                               AND DATE(stat_arrive.date_arrive) BETWEEN '" . $_POST["from_date"] ."' AND  '" . $_POST["to_date"] . "'
                                AND ( ";
                            }
                            elseif ($_POST["filter_cat_etab"] != '') 
                            {
                                $search_query = "
                                AND categorie_etab.cat_etab =  '" . $_POST["filter_cat_etab"] ."'
                                AND ( ";
                            }
                            
                            
                             // filter Etab + Section + date ---------
                            //  if ($_POST["from_date"] != '' and $_POST["filter_section"] != '' and $_POST["filter_cat_etab"] != '') 
                            //  {
                            //      $search_query = "
                            //      AND etab_hebergement.etab_id = '" . $_POST["filter_cat_etab"] ."'
                            //      AND section_arrive.section_arrive_id = '" . $_POST["filter_section"] ."'
                            //      AND DATE(stat_arrive.date_arrive) BETWEEN '" . $_POST["from_date"] ."' AND  '" . $_POST["to_date"] . "'
                            //      AND ( 
                            //  ";
                            //  }
                            // // filter date with etab Only ---------
                            // elseif ($_POST["from_date"] != '' and $_POST["filter_cat_etab"] != ''  ) { 
                            //     $search_query = " 
                            //     AND etab_hebergement.etab_id = '" . $_POST["filter_cat_etab"] ."'
                            //     AND DATE(stat_arrive.date_arrive) BETWEEN '" . $_POST["from_date"] ."' AND  '" . $_POST["to_date"] . "'
                            //     AND ( ";
                            // }
                            // // filter date with section only ---------
                            // elseif ($_POST["from_date"] != '' and $_POST["filter_section"] != ''  ) { 
                            //     $search_query = " 
                            //     AND section_arrive.section_arrive_id = '" . $_POST["filter_section"] ."'
                            //     AND DATE(stat_arrive.date_arrive) BETWEEN '" . $_POST["from_date"] ."' AND  '" . $_POST["to_date"] . "'
                            //     AND ( ";
                            // }
                            // // filter date with nation only ---------
                            // elseif ($_POST["from_date"] != '' and $_POST["filter_nation"] != ''  ) {
                            //     $search_query = " 
                            //     AND nation.nation_id = '" . $_POST["filter_nation"] ."'
                            //     AND DATE(stat_arrive.date_arrive) BETWEEN '" . $_POST["from_date"] ."' AND  '" . $_POST["to_date"] . "'                
                            //     AND ( ";
                            // }
                            // // filter date only ---------        
                            // elseif ($_POST["from_date"] != '' ) {           
                            //     $search_query = " AND DATE(stat_arrive.date_arrive) BETWEEN '" . $_POST["from_date"] ."' AND  '" . $_POST["to_date"] . "'
                            //     AND ( ";
                            // }
                            // // filter section with nation  ---------        
                            // elseif ( $_POST["filter_section"] != '' and $_POST["filter_nation"] != '') {
                                
                            //     $search_query = " 
                            //     AND section_arrive.section_arrive_id = '" . $_POST["filter_section"] ."'
                            //     AND nation.nation_id = '" . $_POST["filter_nation"] ."'
                            //     AND ( ";
                            // }
                            // elseif ( $_POST["filter_section"] != '') {
                                
                            //     $search_query = " 
                            //     AND section_arrive.section_arrive_id = '" . $_POST["filter_section"] ."'
                            //     AND ( ";
                            // }
                            // elseif ( $_POST["filter_nation"] != '') {
                                
                            //     $search_query = " 
                            //     AND nation.nation_id = '" . $_POST["filter_nation"] ."'
                            //     AND ( ";
                            // }
                            // elseif ( $_POST["filter_cat_etab"] != '') {
                                
                            //     $search_query = " 
                            //     AND etab_hebergement.etab_id = '" . $_POST["filter_cat_etab"] ."'
                            //     AND ( ";
                            // }
            
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
            // $search_query .= 'OR stat_arrive.nombre_arrive LIKE "%' . $_POST["search"]["value"] . '%" ';
            // $search_query .= 'OR etab_hebergement.denomination_ar LIKE "%' . $_POST["search"]["value"] . '%" ';
            // $search_query .= 'OR admin_table.admin_name LIKE "%' . $_POST["search"]["value"] . '%" ';
            // $search_query .= 'OR wilaya.nom_wilaya LIKE "%' . $_POST["search"]["value"] . '%" ';
            // $search_query .= 'OR section_arrive.nom_section_arrive LIKE "%' . $_POST["search"]["value"] . '%" ';
            // $search_query .= 'OR nation.nom_nation LIKE "%' . $_POST["search"]["value"] . '%" ';
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
        // if(isset($_POST["order"]))
		// {
		// 	$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		// }
		// else
		// {
            $order_query = 'ORDER BY stat_arrive.stat_id DESC ';
		// }
       
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
        $sub_array[] = "اليالي";
        $sub_array[] = $_POST["filter_cat_etab"];
        $sub_array[] =  $_POST["from_date"]  ;
        $sub_array[] =  $_POST["to_date"] ;
        $sub_array[] = $row["الاجانب المقيمون"];
        $sub_array[] = $row["الجزائريون المقيمون"];
        $sub_array[] = $row["الاجانب غير المقيمون"];
        $sub_array[] = $row["الجزائريون غير المقيمون"];
        $sub_array[] = $row["المجموع العام"];        
        $data[] = $sub_array;
        }
        $output = array(
            "draw"              =>  intval($_POST["draw"]),
            "recordsTotal"      =>  $total_rows,
            "recordsFiltered"   =>  $filtered_rows,
            "data"              =>  $data,
            // "total_arrive"      =>  $total_arrive, 
            // "total_nuitee"      =>  $total_nuitee
            // "total" => number_format($total_order, 2)
        );
        echo json_encode($output);
    }
}
?>