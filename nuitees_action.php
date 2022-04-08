<?php

include('stathotel.php');
$arrive = new stathotel();
include('db_config.php');
if (isset($_POST["action"])) {
    if ($_POST["action"] == 'fetch') {
        $order_column = array('stat_arrive.stat_id', 'stat_arrive.nombre_arrive', 'admin_table.admin_name','nation.nom_nation','section_arrive.nom_section_arrive', 'wilaya.nom_wilaya' );
        $output = array();
        $main_query = "
		SELECT * FROM stat_arrive
		INNER JOIN etab_hebergement ON stat_arrive.etab_id = etab_hebergement.etab_id
		INNER JOIN admin_table ON stat_arrive.user_ID = admin_table.admin_id
		INNER JOIN wilaya ON stat_arrive.wilaya_ID = wilaya.wilaya_id
		INNER JOIN section_arrive ON stat_arrive.section_arrive_ID = section_arrive.section_arrive_id
		INNER JOIN nation ON stat_arrive.nation_ID = nation.nation_id ";
        if ($arrive->is_dta_user()) 
        {
            $main_query .= "
                            WHERE admin_table.wilaya_ID =  '" . $_SESSION["wilaya_id"] . "' ";
        if ($_POST["from_date"] != '') 
        {
            $search_query = "
                            AND DATE(stat_arrive.date_arrive) BETWEEN '" . $_POST["from_date"] . "' AND  '" . $_POST["to_date"] . "' AND ( ";
            } else {
                $search_query = " AND ( ";
            }
        }
        elseif ($arrive->is_hotel_user()) {
            $main_query .= "
                    WHERE etab_hebergement.etab_id =  '" . $_SESSION["etab_id"] . "'
                    AND DATE(stat_arrive.date_rap)  BETWEEN   '" . $arrive->Get_first_date_last_month_date() . "' AND '" . $arrive->get_firstdate_next_month() . "' ";

            if ($_POST["from_date"] != '') {
                $search_query = "
                    AND DATE(stat_arrive.date_arrive) BETWEEN '" . $_POST["from_date"] . "' AND  '" . $_POST["to_date"] . "' AND ( 
			";
            } else {
                $search_query = " AND ( ";
            }
        } 
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
        if (isset($_POST["order"])) {
            $order_query = 'ORDER BY ' . $order_column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
        }
        $order_query = 'ORDER BY stat_arrive.stat_id DESC ';
        $limit_query = '';
        if ($_POST["length"] != -1) {
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
        $sub_array[] = $row["date_rap"];
        $sub_array[] = $row["nom_section_arrive"];
        $sub_array[] = $row["nom_nation"];
        $sub_array[] = $row["nombre_arrive"];
        $sub_array[] = $row["date_arrive"];
        $sub_array[] = $row["date_depart"];
        $sub_array[] = $row["nuite_mois"];
            $nuite_reste = "";
            if ($row["nuite_reste"] > 0) {
                $nuite_reste = '<span  style="font: size 10px; color: red;">' . $row["nuite_reste"] . '</span>';
            } else {
                $nuite_reste = '<span style="font: size 10px; color: green;">' . $row["nuite_reste"] . '</span>';
            }
            $sub_array[] = $nuite_reste;
            if ($arrive->is_master_user()) {
                $sub_array[] = $row["nom_wilaya"];
                $sub_array[] = $row["denomination_ar"];
                $sub_array[] = $row["admin_name"];
            }
                $sub_array[] = $row["denomination_ar"];
                $sub_array[] = $row["admin_name"];
            if ($arrive->is_dta_user() or $arrive->is_hotel_user()) {
                $statut_raport = "";
                if ($row["valeur_statut_raport"] == 1) {
                    $statut_raport = '<button type="button" name="statut_raport"  class="btn btn-block btn-info btn-sm data-id="' . $row["stat_id"] . '" style="font-size:10px;">نهائي</button>';
                } else {
                    $statut_raport = '<button type="button" name="statut_raport"  class="btn btn-block btn-danger btn-sm data-id="' . $row["stat_id"] . '" style="font-size:10px;">مؤقت</button>';
                }
                $sub_array[] = $statut_raport;
            }
            //  ------------------ EDIT BUTTON -----------------------------      
            $edit_nombre = "";
            $editbutton = "";
            if ($arrive->is_hotel_user() and $row["date_arrive"] >= $arrive->Get_first_date_last_month_date()
                and $row["date_arrive"] <= $arrive->Get_last_day_date_current_month_date()) {
                $editbutton = '<button type="button" name="edit_button" id="edit_button" class="btn btn-warning btn-sm edit_button" data-toggle="tooltip" data-placement="top" title="تعديل التقرير" data-id="' . $row["stat_id"] . '"><i class="fas fa-edit"></i></button>';
                $edit_nombre = '<button type="button" name="edit_nombre" id="edit_nombre" class="btn btn-warning btn-sm edit_nombre" data-toggle="tooltip" data-placement="top" title="تعديل عدد الوافدين" data-id="' . $row["stat_id"] . '"><i class="fas fa-user"></i><i class="fas fa-edit"></i></button>';

                if (($row["valeur_statut_sejour"] == 1 and $row["nuite_reste"] == 0)) {
                    $editbutton = "";
                    $edit_nombre = "";
                   
                }
            }
            if ($arrive->is_hotel_user() and $row["sejour_reste"] == 0  
                and ($row["date_arrive"] <= $arrive->Get_last_day_date_current_month_date())
                and ($row["date_arrive"] >= $arrive->Get_first_date_last_month_date()))
            {
                $editbutton = '<button type="button" name="edit_button" id="edit_button" class="btn btn-warning btn-sm edit_button" data-toggle="tooltip" data-placement="top" title="تعديل التقرير" data-id="' . $row["stat_id"] . '"><i class="fas fa-edit"></i></button>';
                $edit_nombre = '<button type="button" name="edit_nombre" id="edit_nombre" class="btn btn-warning btn-sm edit_nombre" data-toggle="tooltip" data-placement="top" title="تعديل عدد الوافدين" data-id="' . $row["stat_id"] . '"><i class="fas fa-user"><i class="fas fa-edit"></i></i></button>';

            }
            //  ------------------ NEXT ADD BUTTON -----------------------------      
            $nextAdd_button = "";
            if (($arrive->is_hotel_user() or $arrive->is_hotel_agent_user() )

                and ($row["date_arrive"] >= $arrive->Get_first_date_last_month_date())
                and ($row["date_arrive"] <= $arrive->Get_last_day_date_current_month_date())
            ) {
                $nextAdd_button = '<button type="button" name="nextAdd_button" class="btn btn-primary btn-sm nextAdd_button" data-id="' . $row["stat_id"] . '"><i class="fas fa-arrow-alt-circle-up"></i></button>';
                if (($row["valeur_statut_sejour"] == 1 and $row["nuite_reste"] == 0)) {
                    $nextAdd_button = "";
                }
            }
            //  ------------------ DELETE BUTTON -----------------------------      
            $delete_button = "";
            if (($arrive->is_hotel_user() or $arrive->is_hotel_agent_user() or $arrive->is_dta_user())

                and ($row["date_arrive"] >= $arrive->Get_first_date_last_month_date())
                and ($row["date_arrive"] <= $arrive->Get_last_day_date_current_month_date())
            ) {
                $delete_button = '<button type="button" name="delete_button" class="btn btn-danger btn-sm delete_button" data-toggle="tooltip" data-placement="top" title="حذف التقرير" data-id="' . $row["stat_id"] . '"><i class="fas fa-times"></i></button>';

                if (($row["valeur_statut_sejour"] == 1 and $row["nuite_reste"] == 0)) {
                    $delete_button = "";
                }
            }
            if (($arrive->is_hotel_user() or $arrive->is_hotel_agent_user() or $arrive->is_dta_user()) and $row["sejour_reste"] == 0  and ($row["date_arrive"] <= $arrive->Get_last_day_date_current_month_date())
                and ($row["date_arrive"] >= $arrive->Get_first_date_last_month_date())
            ) {
                $delete_button = '<button type="button" name="delete_button" class="btn btn-danger btn-sm delete_button" data-toggle="tooltip" data-placement="top" title="حذف التقرير" data-id="' . $row["stat_id"] . '"><i class="fas fa-times"></i></button>';
            }

            $statut_sejour = "";
            if ($row["valeur_statut_sejour"] == 1) {
                $statut_sejour = '<span class="badge badge-success" style="font: size 10px;">إقامة مكتملة</span>';
            } else {
                $statut_sejour = '<span class="badge badge-warning" style="font: size 10px;">إقامة جزئية</span>';
            }
            $sub_array[] = $statut_sejour;
            $sub_array[] = '<div align="right">'
                        . '<button type="button" name="view_button" class="btn btn-info btn-sm view_button" data-toggle="tooltip" data-placement="top" title="تأكيد حالة التقرير من طرف الادارة" data-id="' . $row["stat_id"] . '" " ><i class="fas fa-eye"></i></button>'
                // . " " . $edit_nombre . " "
                . " " . $editbutton . " "
                . " " . $nextAdd_button . " "
                . " " . $delete_button . " " .
                '</div>';
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
    //	************************************* START ADD STAT *************************************************************
    if ($_POST["action"] == 'Add') {
        $date_rap     = $_POST["date_rap"];
        $date_arrive = $_POST["date_arrive"];
        $date_depart     = $_POST["date_depart"];
        $nombre = $_POST["nombre_arrive"];
        $dif_days = $arrive->diff_date($date_depart, $date_arrive);
        $date_arrive_selected = $arrive->get_date($date_arrive);
        $get_last_date_of_spacific_date = $arrive->get_last_date_of_spacific_date($date_arrive);
        $dif_days_of_completed_sejour = $arrive->diff_date_for_sejour($get_last_date_of_spacific_date, $date_arrive_selected);
        $sejour_global = 0;
        $sejour_mois = 0;
        $sejour_reste = 0;
        $nuite_global = 0;
        $nuite_mois = 0;
        $nuite_reste = 0;
        if ($dif_days <= $dif_days_of_completed_sejour) {
        $sejour_global = $dif_days;
        $sejour_mois     = $dif_days;
        $nuite_reste     = 0;
        $valeur_statut_sejour = 1;
        $nuite_global     = ($sejour_global * $nombre);
        $nuite_mois     = ($sejour_mois * $nombre);
        $nuite_reste     = $sejour_reste;
        }
        if ($dif_days > $dif_days_of_completed_sejour) {
        $sejour_global = $dif_days;
        $sejour_mois     = $dif_days_of_completed_sejour;
        $sejour_reste     = ($sejour_global - $dif_days_of_completed_sejour);
        $valeur_statut_sejour = 0;
        $nuite_global     = ($sejour_global * $nombre);
        $nuite_mois     = ($sejour_mois * $nombre);
        $nuite_reste     = $sejour_reste * $nombre;
        }
        $data = array(
        ':date_rap' =>    $date_rap,
        ':section_arrive'            =>  $_POST["section_arrive"],
        ':nombre_arrive'            =>  $nombre,
        ':date_arrive'              =>  $date_arrive,
        ':date_depart'               =>  $date_depart,
        ':sejour_general'             =>    $sejour_global,
        ':sejour_mois'                 =>    $sejour_mois,
        ':sejour_reste'             =>    $sejour_reste,
        ':nuite_general'             =>    $nuite_global,
        ':nuite_mois'                 =>    $nuite_mois,
        ':nuite_rest'                 =>    $nuite_reste,
        ':valeur_statut_sejour'     =>    $valeur_statut_sejour,
        ':valeur_statut_raport'     =>    0,
        ':nation'                   =>  $_POST["nation"],
        ':wilaya'                     =>    $_POST["wilaya"],
        ':etab'                     =>    $_POST["etab"],
        ':user'                     =>    $_POST["user"]
         );
        $arrive->query = "	INSERT INTO stat_arrive 
        (
        date_rap, 
        section_arrive_ID,
        nombre_arrive,
        date_arrive,
        date_depart,
        sejour_general,
        sejour_mois,
        sejour_reste,
		nuite_general,
		nuite_mois,
		nuite_reste,
        valeur_statut_sejour,
        valeur_statut_raport,
        nation_ID,
       	wilaya_ID,
		etab_ID,
		user_ID
		) 
		
		VALUES 
		(
		:date_rap,
		:section_arrive,
		:nombre_arrive,
		:date_arrive,
		:date_depart,
	    :sejour_general,
        :sejour_mois,
        :sejour_reste,
		:nuite_general,
		:nuite_mois,
		:nuite_rest,
		:valeur_statut_sejour,
		:valeur_statut_raport,
		:nation,
		:wilaya,
		:etab,
		:user
		)";

        $arrive->execute($data);
        echo '<div class="alert alert-success" style="font-size: 18px;" >تمت الاضافة بنجـــــاح</div>';
    }
    // ************************************* START  UPDATE STAT ********************************************
    if ($_POST["action"] == 'fetch_update') {
        $arrive->query = "
		SELECT * FROM stat_arrive
		WHERE stat_id = '" . $_POST["stat_id"] . "'";
        
        $result = $arrive->get_result();
        $data = array();
        foreach ($result as $row) {
            $data['date_rap2']                 = $row['date_rap'];
            $data['section_arrive2']         = $row['section_arrive_ID'];
            $data['nombre_arrive2']         = $row['nombre_arrive'];
            $data['wilaya2']                 = $row['wilaya_ID'];
            $data['etab2']                     = $row['etab_ID'];
            $data['user2']                     = $row['user_ID'];
            $data['date_arrive2']             = $row['date_arrive'];
            $data['date_depart2']             = $row['date_depart'];
            $data['nation2']                 = $row['nation_ID'];
        }
        echo json_encode($data);
    }
    if ($_POST["action"] == 'Edit') {

        $date_rap     = $_POST["date_rap2"];
        $section_arrive = $_POST["section_arrive2"];
        $date_arrive = $_POST["date_arrive2"];
        $date_depart     = $_POST["date_depart2"];
        $nombre = $_POST["nombre_arrive2"];
        $dif_days = $arrive->diff_date($date_depart, $date_arrive);
        $date_arrive_selected = $arrive->get_date($date_arrive);
        $get_last_date_of_spacific_date = $arrive->get_last_date_of_spacific_date($date_arrive);
        $dif_days_of_completed_sejour = $arrive->diff_date_for_sejour($get_last_date_of_spacific_date, $date_arrive_selected);
        $sejour_global = 0;
        $sejour_mois = 0;
        $sejour_reste = 0;
        $nuite_global = 0;
        $nuite_mois = 0;
        $nuite_reste = 0;
        if ($dif_days <= $dif_days_of_completed_sejour) {
        $sejour_global = $dif_days;
        $sejour_mois     = $dif_days;
        $sejour_reste     = 0;
        $valeur_statut_sejour = 1;
        $nuite_global     = ($sejour_global * $nombre);
        $nuite_mois     = ($sejour_mois * $nombre);
        $nuite_reste     = $sejour_reste;
        }
        if ($dif_days > $dif_days_of_completed_sejour) {
        $sejour_global = $dif_days;
        $sejour_mois     = $dif_days_of_completed_sejour;
        $sejour_reste     = ($sejour_global - $dif_days_of_completed_sejour);
        $valeur_statut_sejour = 0;
        $nuite_global     = ($sejour_global * $nombre);
        $nuite_mois     = ($sejour_mois * $nombre);
        $nuite_reste     = $sejour_reste * $nombre;
        }
        $data = array(
        ':date_rap'                 =>    $date_rap,
        ':section_arrive'            =>  $section_arrive,
        ':nombre_arrive'            =>  $nombre,
        ':date_arrive'              =>  $date_arrive,
        ':date_depart'               =>  $date_depart,
        ':sejour_general'             =>    $sejour_global,
        ':sejour_mois'                 =>    $sejour_mois,
        ':sejour_reste'             =>    $sejour_reste,
        ':nuite_general'             =>    $nuite_global,
        ':nuite_mois'                 =>    $nuite_mois,
        ':nuite_rest'                 =>    $nuite_reste,
        ':valeur_statut_sejour'     =>    $valeur_statut_sejour,
        ':valeur_statut_raport'     =>    0,
        ':nation'                   =>  $_POST["nation2"],
        ':wilaya'                     =>    $_POST["wilaya2"],
        ':etab'                     =>    $_POST["etab2"],
        ':user'                     =>    $_POST["user2"]
        );
        $arrive->query = ("
        UPDATE stat_arrive 
        SET 
        date_rap 	= :date_rap,
        section_arrive_ID = :section_arrive,
        nombre_arrive = :nombre_arrive,
        date_arrive = :date_arrive,
        date_depart = :date_depart,
        sejour_general = :sejour_general,
        sejour_mois = :sejour_mois,
        sejour_reste = :sejour_reste,
        nuite_general = :nuite_general,
        nuite_mois = :nuite_mois,
        nuite_reste = :nuite_rest,
        valeur_statut_sejour = :valeur_statut_sejour,
        valeur_statut_raport = :valeur_statut_raport, 
        nation_ID = :nation,
        wilaya_ID = :wilaya,
        etab_ID = :etab,
        user_ID = :user
        WHERE stat_id = '" . $_POST['hidden_id2'] . "'
		");
        $arrive->execute($data);
        echo '<div class="alert alert-success" style="font-size: 18px;" >تم التعديل بنجـــــاح...</div>';
    }
    // ************************************* START VIEW MODAL STAT ********************************************
    if ($_POST["action"] == 'fetch_view') {
        $arrive->query = "
		SELECT * FROM stat_arrive
	
		WHERE stat_id = '" . $_POST["stat_id"] . "'";
        $result = $arrive->get_result();
        $data = array();
        foreach ($result as $row) {
            $data['date_rapv']                 = $row['date_rap'];
            $data['wilayav']                 = $row['wilaya_ID'];
            $data['etabv']                     = $row['etab_ID'];
            $data['userv']                     = $row['user_ID'];
            $data['section_arrivev']         = $row['section_arrive_ID'];
            $data['date_arrivev']             = $row['date_arrive'];
            $data['date_departv']             = $row['date_depart'];
            $data['nationv']                 = $row['nation_ID'];
            $data['nombre_arrivev']         = $row['nombre_arrive'];
            $data['sejour_generalv']         = $row['sejour_general'];
            $data['sejour_moisv']             = $row['sejour_mois'];
            $data['sejour_restev']             = $row['sejour_reste'];
            $data['nuite_generalv']         = $row['nuite_general'];
            $data['nuite_moisv']             = $row['nuite_mois'];
            $data['nuite_restv']             = $row['nuite_reste'];
            $data['val_rapv']                 = $row['valeur_statut_raport'];
        }
        echo json_encode($data);
    }
    if ($_POST["action"] == 'change_report_status') {
        $data = array(':valeur_statut_raport'    =>    1);
        $arrive->query = "
	UPDATE 	stat_arrive 
	SET valeur_statut_raport = :valeur_statut_raport
	WHERE stat_id = '" . $_POST["hidden_stat_idv"] . "' ";
        $arrive->execute($data);
        echo '<div class="alert alert-success" style="font-size: 20px;">تم تأكيد التقرير من طرف المديرية...</div>';
    }
    // ************************************* START DELETE STAT ********************************************
    if ($_POST["action"] == 'delete') {
        $arrive->query = "
		DELETE FROM stat_arrive 
		WHERE stat_id = '" . $_POST["id"] . "'
		";
        $arrive->execute();
        echo '<div class="alert alert-success" style="font-size: 18px;" >تم الحذف بنجـــــاح...</div>';
    }
    // -------------------------------------------------------------------------------------------------------------
    // ************************************* NEXT MONTH -ADD STAT ***********************************************************
    if ($_POST["action"] == 'fetch_next_add') {
        $arrive->query = "
		SELECT * FROM stat_arrive
	
		WHERE stat_id = '" . $_POST["stat_id"] . "'";
        $result = $arrive->get_result();
        $data = array();
        foreach ($result as $row) {
            $data['stat_idR']                 = $row['stat_id'];
            $data['date_rapR']                 = $row['date_rap'];
            $data['section_arriveR']         = $row['section_arrive_ID'];
            $data['nombre_arriveR']         = $row['nombre_arrive'];
            $data['wilayaR']                 = $row['wilaya_ID'];
            $data['etabR']                     = $row['etab_ID'];
            $data['userR']                     = $row['user_ID'];
            $data['date_arriveR']             = $row['date_arrive'];
            $data['date_departR']             = $row['date_depart'];
            $data['nationR']                 = $row['nation_ID'];
            $data['ref_rap']             = $row['ref_rap'];
        }
        echo json_encode($data);
    }
    if ($_POST["action"] == 'next_add') {

              $data = array(
            ':nuite_restR'   =>    0,
            ':valeur_statut_sejourR' =>    1
        );
        $arrive->query = ("
		UPDATE stat_arrive 
		SET 
		nuite_reste 			= :nuite_restR,
		valeur_statut_sejour 	= :valeur_statut_sejourR
		WHERE stat_id = '" . $_POST['stat_hidden_idR'] . "'
		");
        $arrive->execute($data);
        $date_rap     = $_POST["date_rapR"];
        $date_arrive = $arrive->Firstdayofnextsmonth($_POST["date_arriveR"]);
        $date_depart     = $_POST["date_departR"];
        $nombre = $_POST["nombre_arriveR"];
        $dif_days = $arrive->diff_date($date_depart, $date_arrive);
        $date_arrive_selected = $arrive->get_date($date_arrive);
        $get_last_date_of_spacific_date = $arrive->get_last_date_of_spacific_date($date_arrive);
        $dif_days_of_completed_sejour = $arrive->diff_date_for_sejour($get_last_date_of_spacific_date, $date_arrive_selected);
        $sejour_global = 0;
        $sejour_mois = 0;
        $sejour_reste = 0;
        $nuite_global = 0;
        $nuite_mois = 0;
        $nuite_reste = 0;
        $valeur_statut_sejour = 0;

         if ($dif_days = 1 ) {
            $sejour_global = $nombre;
            $sejour_mois     = $nombre;
            $sejour_reste     = 0;
            $valeur_statut_sejour = 1;
            $nuite_global = $sejour_global;
            $nuite_mois = $sejour_mois;
            $nuite_reste = $sejour_reste;
        }

        if ($dif_days <= $dif_days_of_completed_sejour) {
        $sejour_global = $dif_days;
        $sejour_mois     = $dif_days;
        $sejour_reste     = 0;
        $valeur_statut_sejour = 1;
        $nuite_global = ((int)$nombre * (int)$sejour_global);
        $nuite_mois = ((int)$nombre * (int)$sejour_mois)+1;
        $nuite_reste = $sejour_reste;
        } 

        if ($dif_days > $dif_days_of_completed_sejour) {
        $sejour_global = $dif_days;
        $sejour_mois     = $dif_days_of_completed_sejour + 1;
        $sejour_reste     = ($sejour_global - $dif_days_of_completed_sejour)+1;
        $valeur_statut_sejour = 0;
        $nuite_global     = ((int)$sejour_global * (int)$nombre);
        $nuite_mois     = ((int)$sejour_mois * (int)$nombre) + 1 ; 
        $nuite_reste     = ($sejour_reste * $nombre);
        }
        $data = array(
        ':date_rap'                  => $date_rap,
        ':section_arrive'            => $_POST["section_arriveR"],
        ':nombre_arrive'             =>  $nombre,
        ':date_arrive'               =>  $date_arrive,
        ':date_depart'               =>  $date_depart,
        ':sejour_general'            =>    $sejour_global,
        ':sejour_mois'               =>    $sejour_mois,
        ':sejour_reste'              =>    $sejour_reste,
        ':nuite_general'             =>    $nuite_global,
        ':nuite_mois'                 =>    $nuite_mois,
        ':nuite_rest'                 =>    $nuite_reste,
        ':valeur_statut_sejour'     =>    $valeur_statut_sejour,
        ':valeur_statut_raport'     =>    0,
        ':nation'                   =>  $_POST["nationR"],
        ':wilaya'                   =>    $_POST["wilayaR"],
        ':etab'                     =>    $_POST["etabR"],
        ':user'                     =>    $_POST["userR"],
        ':ref_rap'                  =>    $_POST["stat_idR"]
        );

        $arrive->query = "	INSERT INTO stat_arrive 
        (
        date_rap, 
        section_arrive_ID,
        nombre_arrive,
        date_arrive,
        date_depart,
        sejour_general,
        sejour_mois,
        sejour_reste,
		nuite_general,
		nuite_mois,
		nuite_reste,
        valeur_statut_sejour,
        valeur_statut_raport,
        nation_ID,
       	wilaya_ID,
		etab_ID,
		user_ID,
		ref_rap
		) 
		VALUES 
		(
		:date_rap,
		:section_arrive,
		:nombre_arrive,
		:date_arrive,
		:date_depart,
	    :sejour_general,
        :sejour_mois,
        :sejour_reste,
		:nuite_general,
		:nuite_mois,
		:nuite_rest,
		:valeur_statut_sejour,
		:valeur_statut_raport,
		:nation,
		:wilaya,
		:etab,
		:user,
		:ref_rap
		)";
        $arrive->execute($data);
        echo '<div class="alert alert-success" style="font-size: 18px;" >تم استكمال الاقامة بنجـــــاح...</div>';
    }
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
?>