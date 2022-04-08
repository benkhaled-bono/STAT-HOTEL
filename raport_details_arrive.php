<?php

include('stathotel.php');
$arrive = new stathotel();
if (!$arrive->is_login()) {
    header("location:" . $arrive->base_url . "index.php");
}
$pagetitle = "البحث و الفلترة" ; 
?>
<?php
include('includes/header.php');
include('includes/navbar.php');
include('includes/sidebar.php');
?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <div class="content-wrapper">
            <div class="content-header">
                <br><br><br>
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h4><i class="fas fa-search" style="font-size: larger; color:brown;"></i> التفاصيل - البحث - الطباعة</h4>
                        </div>
                        <div class="col-sm-6">
                            <!-- <label style="font-size: 20px;"> <?php // echo $arrive->Get_etab_name()?></label> -->
                        </div>
                        <div class="col-md-12">
                            <span id="message" class="text-center"></span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <?php
                                            if ($arrive->is_dta_user()) {  
                                         ?>
                                            <div class="form-group col-md-4">
                                                <select name="filter_etab_dta" id="filter_etab_dta" class="form-control custom-select">
                                                <option value=''>كل المؤسسات</option>    
                                                <?php echo $arrive->load_etab_for_dta() ; ?>
                                                </select>
                                            </div>
                                            <?php
                                            }
                                         ?>
                                            <?php
                                            if ($arrive->is_hotel_user()) {  
                                         ?>
                                            <div class="form-group col-md-4">
                                                <select name="filter_etab" id="filter_etab"
                                                    class="form-control custom-select">
                                                    <?php echo $arrive->load_etab_for_hotel() ; ?>
                                                </select>
                                            </div>
                                            <?php
                                            }
                                         ?>
                                            <div class="form-group col-md-4">
                                                <select name="filter_section" id="filter_section"
                                                    class="form-control custom-select">
                                                    <option value=''>كل الوافدين</option>
                                                    <?php echo $arrive->load_section_arrive() ; ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <select name="filter_nation" id="filter_nation"
                                                    class="form-control custom-select">
                                                    <option value=''>كل البلدان</option>
                                                    <?php echo $arrive->load_nation() ; ?>
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-1 text-md-center">
                                                مـن
                                            </div>
                                            <div class="col-md-3">
                                                <input type="date" name="from_date" id="from_date"
                                                    class="form-control text-md-left" placeholder="من" />
                                            </div>
                                            <div class="col-md-1 text-md-center">
                                                إلـى
                                            </div>
                                            <div class="form-group col-md-3 ">
                                                <input type="date" name="to_date" id="to_date"
                                                    class="form-control text-md-left" placeholder="إلى" />
                                            </div>
                                            <div class="col-md-4">
                                                <button type="button" name="filter" id="filter"
                                                    class="btn btn-primary btn-md"><i class="fas fa-filter"></i>
                                                    فلتــر</button>
                                                <button type="button" name="refresh" id="refresh"
                                                    class="btn btn-secondary btn-md"><i class="fas fa-sync-alt"></i>
                                                    تحديث</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="stat_table" class="display table-responsive" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>رقم</th>
                                            <th>المؤسسة_الفندقية</th>
                                            <th>أقســـــام_الوافديـن</th>
                                            <th>البلد أوالجنسية</th>
                                            <th>عدد الوافدين</th>
                                            <th>الليالي الشهري</th>
                                            <th>الليالي المتبقية</th>
                                            <th>تاريــــــــــــخ الدخــــــــــــول</th>
                                            <th>تاريـــــــــــــخ الخــــــــــــروج</th>
                                            <th>تاريـــــــــــــــخ الارســــــال</th>
                                            <th>حالة الاقامة</th>
                                            <th>ref_Rap</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4"></th>
                                            <th id="total_arrive" style="font-size: 20px; color:red"></th>
                                            <th id="total_nuitee" style="font-size: 20px; color:green"></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div><!-- /.card -->
                    </div>
                </div>

            </section>

        </div>
    </div>
    <?php
    include('includes/footer.php');
    include('includes/script.php');
    ?>
    <script type="text/javascript" language="javascript">
    $(document).ready(function() {
        var date = new Date();
        $('.input-daterange').datepicker({
            todayBtn: "linked",
            format: "yyyy-mm-dd",
            autoclose: true
        });
    });
    $(document).ready(function() 
    {
        load_data();

        function load_data(from_date = '', to_date = '', filter_section = '', filter_nation = '', filter_etab_dta = '') {
            var dataTable = $('#stat_table').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    url: "raport_details_arrive_action.php",
                    type: "POST",
                    data: {
                        action: 'fetch',
                        from_date: from_date,
                        to_date: to_date,
                        filter_section: filter_section,
                        filter_nation: filter_nation,
                        filter_etab_dta: filter_etab_dta
                    },
                },
                drawCallback: function(settings) {
                    $('#total_arrive').html(settings.json.total_arrive);
                    $('#total_nuitee').html(settings.json.total_nuitee);
                },
                dom: 'lBfrtip',
                buttons: [
                        {
                            extend: "print",
                            customize: function(win) {
                                var last = null;
                                var current = null;
                                var bod = [];
                                var css = '@page { size: landscape; }',
                                    head = win.document.head || win.document.getElementsByTagName(
                                        'head')[0],
                                    style = win.document.createElement('style');
                                style.type = 'text/css';
                                style.media = 'print';
                                if (style.styleSheet) {
                                    style.styleSheet.cssText = css;
                                } else {
                                    style.appendChild(win.document.createTextNode(css));
                                }
                                head.appendChild(style);
                            }
                        },
                    ],
                "targets": [],
                "orderable": true,
            });
        }
        $('#filter').click(function() {
            var filter_section = $('#filter_section').val();
            var filter_nation = $('#filter_nation').val();
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            var filter_etab_dta = $('#filter_etab_dta').val();
            $('#stat_table').DataTable().destroy();
            load_data(from_date, to_date, filter_section, filter_nation, filter_etab_dta);
        });
        $('#refresh').click(function() {
            $('#from_date').val('');
            $('#to_date').val('');
            $('#filter_section').val('');
            $('#filter_nation').val('');
            $('#filter_etab_dta').val('');
            $('#stat_table').DataTable().destroy();
            load_data();
        });
       
    // ***************************************************************************************************************************************
    // *********************************************** DEPENDENCE FOR ADD SELECT BOX ********************************************
    $(document).ready(function() { // NATION dependent ajax
        $("#section_arrive").on("change", function() {
            var sectionId = $(this).val();
            $.ajax({
                url: "nuitees_action.php",
                type: "POST",
                cache: false,
                data: {
                    sectionId: sectionId
                },
                success: function(data) {
                    $("#nation").html(data);

                }
            });
        });
    });

    // ************************************************ DEPENDENCE FOR SELECT BOX ******************************************************
    $(document).ready(function() { // Nation dependent ajax
        $("#section_arrive2").on("change", function() {
            var sectionID = $(this).val();
            $.ajax({
                url: "nuitees_action.php",
                type: "POST",
                cache: false,
                data: {
                    sectionID: sectionID
                },
                success: function(data) {
                    $("#nation2").html(data);

                }
            });
    
        });
    });
});
    </script>
</body>

</html>