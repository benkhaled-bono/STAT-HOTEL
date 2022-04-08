<?php
include('stathotel.php');
$arrive = new stathotel();
if (!$arrive->is_login()) {
    header("location:" . $arrive->base_url . "index.php");
}
?>
<?php
include('includes/header.php');
include('includes/navbar.php');
include('includes/sidebar.php');
?>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <div class="content-wrapper">
            <br><br><br>
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h5 style="font-weight: bolder;">قائمة الوافدين و الليالي المتبقية</h5>
                        </div><!-- /.col -->
                        <div class="col-md-12">
                            <span id="message" class="text-center"></span>
                        </div>
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <!-- <div class="col-md-4" align="right">
                                        <button type="button" name="add_arrive" id="add_arrive"
                                            class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> اضافة
                                            وافدين</button>
                                    </div> -->
                                    <div class="col-md-4">
                                        <!-- <div class="row input-daterange">
                                            <div class="col-md-6">
                                                <input type="text" name="from_date" id="from_date" class="form-control " placeholder="من" />
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="to_date" id="to_date" class="form-control " placeholder="إلى" />
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="col-md-4">
                                        <!-- <button type="button" name="filter" id="filter" class="btn btn-info btn-sm"><i class="fas fa-filter"></i></button>
                                        <button type="button" name="refresh" id="refresh" class="btn btn-secondary btn-sm"><i class="fas fa-sync-alt"></i></button> -->
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="stat_table" class="table table-bordered table-hover table-responsive location" style="width:100%">
                                    <thead class="headertable">
                                        <tr>
                                            <th>رقم</th>
                                            <th>تاريـــــــــــــــخ الارســــــال</th>
                                            <th>أقســـــام_ـالوافديـن</th>
                                            <th>البلد أوالجنسية</th>
                                            <th>عدد الوافدين</th>
                                            <th>تاريــــــــــــخ الدخــــــــــــول</th>
                                            <th>تاريـــــــــــــخ الخــــــــــــروج</th>
                                            <th>الليالي الشهري</th>
                                            <th>الليالي المتبقية</th>
                                            <th>حالة الاقامة</th>
                                            <?php
                                            if ($arrive->is_master_user()) {
                                                echo '<th>الولاية</th>';
                                                echo '<th>المؤسسة_الفندقية</th>';
                                                echo '<th>المستخدم</th>';
                                            }
                                            ?>
                                            <?php
                                            if ($arrive->is_dta_user() or $arrive->is_hotel_user()) {
                                                echo '<th>المؤسسة_الفندقية</th>';
                                                echo '<th>المستخـــــــــــــــدم</th>';
                                                echo '<th>الادارة</th>';
                                            }
                                            ?>
                                            <th>العمليــــــــــــــــــــــــــــــــات</th>
                                            <th>ref_Rap</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div><!-- /.card -->
                    </div>
                </div>
                  <!-- NEXT MONTH STAT ARRIVE -->
                  <div class="modal fade" id="reAdd_arrive_modal">
                    <form method="post" id="reAdd_arrive_form">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content ">
                                <div class="modal-header" style="background-color: #7c97ef;">
                                    <div class="row col-md-12">
                                        <h3 class="modal-title">عملية استكمال الاقامة...</h3>
                                    </div>
                                    <button type="button" class="close text-center" data-dismiss="modal"> &times;
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body" dir="rtl">
                                    <!-----------------------------START LOAD WILAYA - DTA - HOTEL --->
                                    <div class="form-row ">
                                        <div class="form-group col-md-4 ">
                                            <label for="stat_idR">رقم التسلسلي :</label>
                                            <input type="number" name="stat_idR" id="stat_idR" class="form-control"
                                                readonly disabled />
                                        </div>
                                        <div class="form-group col-md-4 input-daterange">
                                            <label for="date_rapR">تاريخ الارسال :</label>
                                            <input type="text" name="date_rapR" id="date_rapR" class="form-control"
                                                readonly disabled />
                                        </div>
                                        <div class="form-group col-md-4 ">
                                            <label for="ref_rap">الرقم المرجعي :</label>
                                            <input type="number" name="ref_rap" id="ref_rap" class="form-control"
                                                readonly disabled />
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="wilayaR">الولاية :</label>
                                            <select name="wilayaR" id="wilayaR" class="form-control custom-select"
                                                data-parsley-trigger="keyup" readonly disabled>
                                                <option value="">إختر ...</option>
                                                <?php echo $arrive->load_wilaya_for_edit(); ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="etabR">المؤسسة الفندقية :</label>
                                            <select name="etabR" id="etabR" class="form-control custom-select"
                                                data-parsley-trigger="keyup" readonly disabled>
                                                <option value="">إختر ...</option>
                                                <?php echo $arrive->load_etab_for_edit();
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="userR">المستخدم :</label>
                                            <select name="userR" id="userR" class="form-control custom-select"
                                                data-parsley-trigger="keyup" readonly disabled>
                                                <option value="">إختر ...</option>
                                                <?php echo $arrive->load_user_for_edit();
                                                ?>
                                            </select>
                                        </div>

                                    </div>
                                    <hr>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="section_arriveR">أقسام الوافدين :</label>
                                            <select name="section_arriveR" id="section_arriveR"
                                                class="form-control custom-select" data-parsley-trigger="keyup" readonly
                                                disabled>
                                                <option value="">إختر ...</option>
                                                <?php echo $arrive->load_section_arrive();
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="nationR">الجنسية أو بلد الاقامة :</label>
                                            <select name="nationR" id="nationR" class="form-control custom-select"
                                                data-parsley-trigger="keyup" readonly disabled>
                                                <option value="">إختر ...</option>
                                                <?php echo $arrive->load_nation();
                                                ?>
                                            </select>
                                        </div>
                                       
                                    </div>
                                    <hr>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="nombre_arriveR">عدد الوافدين :</label>
                                            <input type="number" min="1" max="10000" class="form-control"
                                                name="nombre_arriveR" id="nombre_arriveR"
                                                data-parsley-trigger="keyup"
                                                readonly disabled>
                                        </div>
                                        <div class="form-group col-md-4 input-daterange text-left">
                                            <label for="date_arriveR">تاريخ بداية الاقامة :</label>
                                            <input type="text" id="date_arriveR" name="date_arriveR"
                                                class="form-control" data-parsley-trigger="keyup" readonly disabled />
                                        </div>
                                        <div class="form-group col-md-4 input-daterange text-left">
                                            <label for="date_departR">تاريخ نهاية الاقامة :</label>
                                            <input type="text" id="date_departR" name="date_departR"
                                                class="form-control" data-parsley-trigger="keyup" readonly disabled />
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <input type="hidden" name="stat_hidden_idR" id="stat_hidden_idR" />
                                    <input type="hidden" name="action" id="action" value="next_add" />
                                    <input type="submit" name="submit" id="next_add_button" class="btn btn-primary lg"
                                        value="ليالي الشهر الموالي" />
                                    <button type="button" class="btn btn-danger" dir="rtl"
                                        data-dismiss="modal">اغلاق</button>
                                </div>

                            </div>
                    </form>
                </div><!-- END NEXT MONTH MODAL -->
            </section>
                <!-- START VIEW DETAILS MODAL -->
            <div id="stat_details_modal" class="modal fade">
                <div class="modal-dialog modal-lg">
                    <form method="post" id="stat_details_form">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color:#17a2b8">
                                <h4 class="modal-title" id="modal_title">معلومات خاصة بالتقرير :</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group col-md-offset-12">
                                    <div class="row ">
                                        <label class="col-md-2 text-left"><b>تاريخ التقرير :</b></label>
                                        <div class="col-md-4  text-left ">
                                            <input type="text" name="date_rapv" id="date_rapv" class="form-control"
                                                readonly disabled />
                                        </div>
                                        <label class="col-md-2 text-leftt"><b>الولاية :</b></label>
                                        <div class="col-md-3 text-left">
                                            <select name="wilayav" id="wilayav" class="form-control custom-select "
                                                data-parsley-trigger="keyup" disabled>
                                                <?php echo $arrive->load_wilaya_for_edit(); ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-offset-12">
                                    <div class="row">
                                        <label class="col-md-2 text-leftt"><b>المؤسسة الفندقية :</b></label>
                                        <div class="col-md-4 text-left">
                                            <select name="etabv" id="etabv" class="form-control custom-select "
                                                data-parsley-trigger="keyup" disabled>
                                                <?php echo $arrive->load_etab_for_edit();
                                                ?>
                                            </select>
                                        </div>
                                        <label class="col-md-2 text-leftt"><b>المستخدم :</b></label>
                                        <div class="col-md-3 text-left">
                                            <select name="userv" id="userv" class="form-control custom-select "
                                                data-parsley-trigger="keyup" disabled>
                                                <?php echo $arrive->load_user_for_edit();
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-offset-12">
                                    <div class="row">
                                        <label class="col-md-2 text-leftt"><b>القسم :</b></label>
                                        <div class="col-md-4 text-left">
                                            <select name="section_arrivev" id="section_arrivev"
                                                class="form-control custom-select " data-parsley-trigger="keyup"
                                                disabled>
                                                <?php echo $arrive->load_section_arrive();
                                                ?>
                                            </select>
                                        </div>
                                        <label class="col-md-2 text-leftt"><b>البلد :</b></label>
                                        <div class="col-md-3 text-left">
                                            <select name="nationv" id="nationv" class="form-control custom-select "
                                                data-parsley-trigger="keyup" disabled>
                                                <?php echo $arrive->load_nation_for_edit(); ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-offset-12">
                                    <div class="row">
                                        
                                        <label class="col-md-2 text-left"><b>تاريخ الدخول :</b></label>
                                        <div class="col-md-3  text-left ">
                                            <input type="text" name="date_arrivev" id="date_arrivev"
                                                class="form-control" disabled />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-offset-12">
                                    <div class="row">
                                        <label class="col-md-2 text-left"><b>تاريخ الخروج :</b></label>
                                        <div class="col-md-4  text-left ">
                                            <input type="text" name="date_departv" id="date_departv"
                                                class="form-control" disabled />
                                        </div>
                                        <label class="col-md-2 text-left"><b>العدد :</b></label>
                                        <div class="col-md-3  text-left ">
                                            <input type="text" name="nombre_arrivev" id="nombre_arrivev"
                                                class="form-control" disabled />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-offset-12">
                                    <div class="row">
                                        <label class="col-md-2 text-left"><b>مدة الاقامة :</b></label>
                                        <div class="col-md-4  text-left ">
                                            <input type="text" name="sejour_generalv" id="sejour_generalv"
                                                class="form-control" disabled />
                                        </div>
                                        <label class="col-md-2 text-left"><b>الاقامة الشهرية :</b></label>
                                        <div class="col-md-3  text-left ">
                                            <input type="text" name="sejour_moisv" id="sejour_moisv"
                                                class="form-control" disabled />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-md-2 text-left"><b>الاقامة المتبقية :</b></label>
                                        <div class="col-md-4  text-left text-left">
                                            <input type="text" name="sejour_restev" id="sejour_restev"
                                                class="form-control" disabled />
                                        </div>
                                        <label class="col-md-2 text-left">الليالي الاجمالي :</b></label>
                                        <div class="col-md-3  text-left text-left">
                                            <input type="text" name="nuite_generalv" id="nuite_generalv"
                                                class="form-control" disabled />
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-md-2 text-left">الليالي الشهري :</b></label>
                                        <div class="col-md-4  text-left text-left">
                                            <input type="text" name="nuite_moisv" id="nuite_moisv" class="form-control"
                                                disabled />
                                        </div>
                                        <label class="col-md-2 text-left">الليالي المتبقية :</b></label>
                                        <div class="col-md-3  text-left text-left">
                                            <input type="text" name="nuite_restv" id="nuite_restv" class="form-control"
                                                disabled />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3  text-left text-left" style="display: none;">
                                    <input type="text" name="val_rapv" id="val_rapv" class="form-control" />
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="hidden_stat_idv" id="hidden_stat_idv" />
                                <input type="hidden" name="action" value="change_report_status" />
                                <?php
                                if ($arrive->is_dta_user()) {
                                    ?>
                                <input type="submit" name="submit" id="detail_submit_button" class="btn btn-info"
                                    value="تأكيد التقرير" />

                                <?php
                                }
                                ?>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">الغاء</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div> <!-- END VIEW DETAILS MODAL -->
<!-- START EDIT UPDATE MODAL -->
<div class="modal fade" id="edit_arrive_modal">
                <form method="post" id="edit_arrive_form">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content ">
                            <div class="modal-header" style="background-color: #ffc107;">
                                <div class="row col-md-12">
                                    <h3 class="modal-title">تعديل الوافدين</h3>
                                </div>
                                <button type="button" class="close text-center" data-dismiss="modal"> &times; </button>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body" dir="rtl">
                                <!-----------------------------START LOAD WILAYA - DTA - HOTEL --->
                                <div class="form-row ">
                                    <div class="form-group col-md-3  text-left">

                                        <label for="date_rap2">تاريخ الارسال :</label>
                                        <input type="date" name="date_rap2" id="date_rap2" class="form-control" required
                                            data-parsley-trigger="keyup" placeholder="yyyy/mm/dd" />
                                    </div>
                                    <!-- ///////////////////// START LOAD FOR MASTER **************** -->
                                    <?php
                                    if ($arrive->is_master_user()) {
                                        ?>
                                    <div class="form-group col-md-3">
                                        <label for="wilaya2">الولاية :</label>
                                        <select name="wilaya2" id="wilaya2" class="form-control custom-select" required
                                            readonly disabled data-parsley-trigger="keyup">
                                            <option value="">إختر ...</option>
                                            <?php echo $arrive->load_wilaya_for_master(); ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="etab2">المؤسسة الفندقية :</label>
                                        <select name="etab2" id="etab2" class="form-control custom-select" required
                                            readonly disabled data-parsley-trigger="keyup">
                                            <option value="">إختر ...</option>
                                            <?php echo $arrive->load_etab_for_master(); ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="user2">المستخدم :</label>
                                        <select name="user2" id="user2" class="form-control custom-select" required
                                            readonly disabled data-parsley-trigger="keyup">
                                            <option value="">إختر ...</option>
                                            <?php echo $arrive->load_hotel_users_for_master(); ?>
                                        </select>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                    if ($arrive->is_dta_user()) {
                                        ?>
                                    <div class="form-group col-md-3">
                                        <label for="wilaya2">الولاية :</label>
                                        <select name="wilaya2" id="wilaya2" class="form-control custom-select" required
                                            readonly data-parsley-trigger="keyup" readonly>
                                            <?php echo $arrive->load_wilaya_for_dta(); ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="etab2">المؤسسة الفندقية :</label>
                                        <select name="etab2" id="etab2" class="form-control custom-select" required
                                            readonly data-parsley-trigger="keyup">
                                            <option value="">إختر ...</option>
                                            <?php echo $arrive->load_etab_for_edit(); ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="user2">المستخدم :</label>
                                        <select name="user2" id="user2" class="form-control custom-select" required
                                            readonly data-parsley-trigger="keyup">
                                            <option value="">إختر ...</option>
                                            <?php echo $arrive->load_user_for_edit(); ?>
                                        </select>
                                    </div>
                                    <?php
                                    }
                                    ?>

                                    <?php
                                    if ($arrive->is_hotel_user() or $arrive->is_hotel_agent_user()) {
                                        ?>

                                    <div class="form-group col-md-3">
                                        <label for="wilaya2">الولاية :</label>
                                        <select name="wilaya2" id="wilaya2" class="form-control custom-select" required
                                            readonly data-parsley-trigger="keyup" readonly>
                                            <?php echo $arrive->load_wilaya_for_hotel(); ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="etab2">المؤسسة الفندقية :</label>
                                        <select name="etab2" id="etab2" class="form-control custom-select" required
                                            readonly data-parsley-trigger="keyup" readonly>
                                            <?php echo $arrive->load_etab_for_hotel(); ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="user2">المستخدم :</label>
                                        <select name="user2" id="user2" class="form-control custom-select" required
                                            readonly data-parsley-trigger="keyup" readonly>
                                            <?php echo $arrive->load_hotel_users_for_hotel(); ?>
                                        </select>
                                    </div>

                                    <?php
                                    }
                                    ?>
                                </div>
                                <hr>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="section_arrive2">أقسام الوافدين :</label>
                                        <select name="section_arrive2" id="section_arrive2"
                                            class="form-control custom-select" required data-parsley-trigger="keyup">
                                            <option value="">إختر ...</option>
                                            <?php echo $arrive->load_section_arrive();
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="nation2">الجنسية أو بلد الاقامة :</label>
                                        <select name="nation2" id="nation2" class="form-control custom-select" required
                                            data-parsley-trigger="keyup">
                                            <option value="">إختر ...</option>
                                            <?php echo $arrive->load_nation();
                                            ?>
                                        </select>
                                    </div>
                                   </div>
                                <hr>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="nombre_arrive2">عدد الوافدين :</label>
                                        <input type="number" min="1" max="10000" class="form-control"
                                            name="nombre_arrive2" id="nombre_arrive2" placeholder="أدخل عدد الوافدين"
                                            required data-parsley-trigger="keyup">
                                    </div>
                                    <div class="form-group col-md-4 text-left">
                                        <label for="date_arrive2">تاريخ بداية الاقامة :</label>
                                        <input type="date" id="date_arrive2" name="date_arrive2" class="form-control"
                                            placeholder="Y/m/d" required data-parsley-trigger="keyup" />
                                    </div>
                                    <div class="form-group col-md-4 i text-left">
                                        <label for="date_depart2">تاريخ نهاية الاقامة :</label>
                                        <input type="date" id="date_depart2" name="date_depart2" class="form-control"
                                            placeholder="Y/m/d" required data-parsley-trigger="keyup" />
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="hidden_id2" id="hidden_id2" />
                                <input type="hidden" name="action" id="action" value="Edit" />
                                <input type="submit" name="submit" id="update_button" class="btn btn-warning lg"
                                    value="تعديل" />
                                <button type="button" class="btn btn-danger" dir="rtl"
                                    data-dismiss="modal">اغلاق</button>
                            </div>

                        </div>
                </form>
            </div><!-- END EDIT UPDATE MODAL -->
        </div>
    </div>
    <?php
    include('includes/footer.php');
    include('includes/script.php');
    ?>
    <script>
        // ************************************ VALIDATION DATE ARRIVE-DEPART-RAPPORT ****************** -->
      
     $(document).ready(function() 
    {
        load_data();
        function load_data(from_date = '', to_date = '') {
            var dataTable = $('#stat_table').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    url: "nuitee_incomplet_action.php",
                    type: "POST",

                    data: {
                        action: 'fetch',
                        from_date: from_date,
                        to_date: to_date
                    }
                },
                "columnDefs": [{
                "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14],
                "orderable": false,
                }, 
            ],
            "searching":false,
                dom: 'lBfrtip',
                buttons: [
                    // 'copy', 'excel','print'
                ]
            });
        }
            $('#filter').click(function() {
                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();
                $('#stat_table').DataTable().destroy();
                load_data(from_date, to_date);
            });
            $('#refresh').click(function() {
                $('#from_date').val('');
                $('#to_date').val('');
                $('#stat_table').DataTable().destroy();
                load_data();
            });
             // ************************************* EDIT STAT ARRIVE ******************************************
        $(document).on('click', '.edit_button', function() {
            var stat_id = $(this).data('id');
            $('#edit_arrive_form').parsley().reset();
            $.ajax({
                url: "nuitees_action.php",
                method: "POST",
                data: {
                    stat_id: stat_id,
                    action: 'fetch_update'
                },
                dataType: 'JSON',
                success: function(data) {
                    $('#date_rap2').val(data.date_rap2);
                    $('#wilaya2').val(data.wilaya2);
                    $('#etab2').val(data.etab2);
                    $('#user2').val(data.user2);
                    $('#section_arrive2').val(data.section_arrive2);
                    $('#nation2').val(data.nation2);
                    $('#date_arrive2').val(data.date_arrive2);
                    $('#date_depart2').val(data.date_depart2);
                    $('#nombre_arrive2').val(data.nombre_arrive2);
                    $('#action').val('Edit');
                    $('#update_button').val('تعديل');
                    $('#edit_arrive_modal').modal('show');
                    $('#hidden_id2').val(stat_id);
                }
            })
        });
        $('#edit_arrive_form').on('submit', function(event) {
            event.preventDefault();
            if ($('#edit_arrive_form').parsley().isValid()) {
                $.ajax({
                    url: "nuitees_action.php",
                    method: "POST",
                    data: $(this).serialize(),
                    beforeSend: function() {
                        $('#update_button').attr('disabled', 'disabled');
                        $('#update_button').val('wait...');
                    },
                    success: function(data) {
                        $('#update_button').attr('disabled', false);
                        $('#edit_arrive_modal').modal('hide');
                        $('#message').html(data);
                        $('#stat_table').DataTable().destroy();
                        load_data();
                        setTimeout(function() {
                            $('#message').html('');
                        }, 5000);
                    }
                })
            }
        });
     // **************************************** VIEW STAT ARRIVE *********************************************************
     $(document).on('click', '.view_button', function() {
            //$('#detail_submit_button').prop('disabled', false);

            var stat_id = $(this).data('id');
            $.ajax({
                url: "nuitees_action.php",
                method: "POST",
                data: {
                    stat_id: stat_id,
                    action: 'fetch_view'
                },
                dataType: 'JSON',
                success: function(data) {
                    $('#date_rapv').val(data.date_rapv);
                    $('#wilayav').val(data.wilayav);
                    $('#etabv').val(data.etabv);
                    $('#userv').val(data.userv);
                    $('#section_arrivev').val(data.section_arrivev);
                    $('#nationv').val(data.nationv);
                    $('#date_arrivev').val(data.date_arrivev);
                    $('#date_departv').val(data.date_departv);
                    $('#nombre_arrivev').val(data.nombre_arrivev);
                    $('#sejour_generalv').val(data.sejour_generalv);
                    $('#sejour_moisv').val(data.sejour_moisv);
                    $('#sejour_restev').val(data.sejour_restev);
                    $('#nuite_generalv').val(data.nuite_generalv);
                    $('#nuite_moisv').val(data.nuite_moisv);
                    $('#nuite_restv').val(data.nuite_restv);
                    $('#val_rapv').val(data.val_rapv);
                    $('#stat_details_modal').modal('show');
                    $('#hidden_stat_idv').val(stat_id);
                    var d = document.getElementById("val_rapv").value;
                    if (d == 1) {
                        $('#detail_submit_button').prop('disabled', true);
                    } else {
                        $('#detail_submit_button').prop('disabled', false);
                    }
                }
            })
        });
        $('#stat_details_form').parsley();
        $('#stat_details_form').on('submit', function(event) {
            event.preventDefault();
            if ($('#stat_details_form').parsley().isValid()) {
                $.ajax({
                    url: "nuitees_action.php",
                    method: "POST",
                    data: $(this).serialize(),
                    beforeSend: function() {
                        $('#detail_submit_button').attr('disabled', 'disabled');
                        $('#detail_submit_button').val('wait...');
                    },
                    success: function(data) {
                        $('#val_rapv').prop('disabled', false);
                        $('#detail_submit_button').attr('disabled', false);
                        $('#detail_submit_button').val('تأكيد التقرير');
                        $('#stat_details_modal').modal('hide');
                        $('#message').html(data);
                        $('#stat_table').DataTable().destroy();
                        load_data();
                        setTimeout(function() {
                            $('#message').html('');
                        }, 5000);
                    }
                });
            }
        });
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// **************************************** NEXT-ADD UPDATE STAT ARRIVE *********************************************************
            $(document).on('click', '.nextAdd_button', function() {
            var stat_id = $(this).data('id');
            $('#reAdd_arrive_form').parsley().reset();
            $.ajax({
                url: "nuitee_incomplet_action.php",
                method: "POST",
                data: {
                    stat_id: stat_id,
                    action: 'fetch_next_add'
                },
                dataType: 'JSON',
                success: function(data) {
                    $('#stat_idR').prop('disabled', true);
                    $('#date_rapR').prop('disabled', true);
                    $('#wilayaR').prop('disabled', true);
                    $('#etabR').prop('disabled', true);
                    $('#userR').prop('disabled', true);
                    $('#section_arriveR').prop('disabled', true);
                    $('#nationR').prop('disabled', true);
                    $('#date_arriveR').prop('disabled', true);
                    $('#date_departR').prop('disabled', true);
                    $('#nombre_arriveR').prop('disabled', true);
                    $('#ref_rap').prop('disabled', true);
                    $('#stat_idR').val(data.stat_idR);
                    $('#date_rapR').val(data.date_rapR);
                    $('#wilayaR').val(data.wilayaR);
                    $('#etabR').val(data.etabR);
                    $('#userR').val(data.userR);
                    $('#section_arriveR').val(data.section_arriveR);
                    $('#nationR').val(data.nationR);
                    $('#date_arriveR').val(data.date_arriveR);
                    $('#date_departR').val(data.date_departR);
                    $('#nombre_arriveR').val(data.nombre_arriveR);
                    $('#ref_rap').val(data.ref_rap);
                    $('#action').val('next_add');
                    $('#nextAdd_button').val('ليالي الشهر الموالي');
                    $('#reAdd_arrive_modal').modal('show');
                    $('#stat_hidden_idR').val(stat_id);
                }
            })
        });
        //***** NEXT-ADD ADD STAT ARRIVE 
            $('#reAdd_arrive_form').parsley();
            $('#reAdd_arrive_form').on('submit', function(event) {
            $('#stat_idR').prop('disabled', false);
            $('#ref_rap').prop('disabled', false);
            $('#date_rapR').prop('disabled', false);
            $('#wilayaR').prop('disabled', false);
            $('#etabR').prop('disabled', false);
            $('#userR').prop('disabled', false);
            $('#section_arriveR').prop('disabled', false);
            $('#nationR').prop('disabled', false);
            $('#date_arriveR').prop('disabled', false);
            $('#date_departR').prop('disabled', false);
            $('#nombre_arriveR').prop('disabled', false);
            event.preventDefault();
            if ($('#reAdd_arrive_form').parsley().isValid()) {
                $.ajax({
                    url: "nuitees_action.php",
                    method: "POST",
                    data: $(this).serialize(),
                    beforeSend: function() {
                        $('#nextAdd_button').attr('disabled', 'disabled');
                        $('#nextAdd_button').val('wait...');
                    },
                    success: function(data) {
                        $('#nextAdd_button').attr('disabled', false);
                        $('#reAdd_arrive_modal').modal('hide');
                        $('#message').html(data);
                        $('#stat_table').DataTable().destroy();
                        load_data();
                        setTimeout(function() {
                            $('#message').html('');
                        }, 5000);
                    }
                })
            }
        });
    });
        // **************************************** DELETE STAT ARRIVE *********************************************************
        $(document).on('click', '.delete_button', function() {
            var id = $(this).data('id');
            if (confirm("هل أنت متأكد أنك تريد إزالته ؟")) {
                $.ajax({
                    url: "nuitee_incomplet_action.php",
                    method: "POST",
                    data: {
                        id: id,
                        action: 'delete'
                    },
                    success: function(data) {
                        $('#message').html(data);
                        $('#stat_table').DataTable().destroy();
                        load_data();
                        setTimeout(function() {
                            $('#message').html('');
                        }, 2000);
                    }
                });
            }
        });
        // ***************************************************************************************************************************************
        // *********************************************** DEPENDENCE FOR ADD SELECT BOX ********************************************
    
    </script>
</body>

</html>