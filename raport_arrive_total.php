<?php
include('stathotel.php');
$arrive = new stathotel();
if (!$arrive->is_login()) {
    header("location:" . $arrive->base_url . "index.php");
}
if ($arrive->is_hotel_user()) {  $pagetitle ='فندق ' . $arrive->load_hotel() .'-'.' اجمالي  الوافدين حسب تصنيف الفنادق ';}
if ($arrive->is_dta_user()) {  $pagetitle ='ولاية ' . $arrive->load_wilaya() .'-'.' اجمالي  الوافدين حسب تصنيف الفنادق ';}
?>
<?php
include('includes/header.php');
include('includes/navbar.php');
include('includes/sidebar.php');
?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <div class="content-wrapper">
            <br>
            <section class="content">
                <br> <br>
                <!-- 1* Table -->
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-1 text-md-center">
                                    مـن
                                </div>
                                <div class="col-md-3">
                                    <input type="date" name="from_date" id="from_date" class="form-control text-md-left"
                                        placeholder="من" />
                                </div>
                                <div class="col-md-1 text-md-center">
                                    إلـى
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="date" name="to_date" id="to_date" class="form-control text-md-left"
                                        placeholder="إلى" />
                                </div>

                                <?php
                                if ($arrive->is_dta_user()) {  
                                 ?>
                                <div class="form-group col-md-3">
                                    <select name="filter_cat_etab" id="filter_cat_etab"
                                        class="form-control custom-select">
                                        <option value=''>كل التصنيفات</option>
                                        <?php echo $arrive->load_cat_etab_for_dta() ; ?>
                                    </select>
                                </div>
                                <?php
                                }
                                ?>
                                        <div class="col-md-2" ></div>
                                    <button type="button" name="filter" id="filter" class="btn btn-warning  col-md-4"><i
                                            class="fas fa-filter"></i>
                                        فلتــر</button>
                                    <button type="button" name="refresh" id="refresh"
                                        class="btn btn-secondary btn-md col-md-4"><i class="fas fa-sync-alt"></i>
                                        تحديث</button>
                               
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class=" table display table-responsive" style="width:100%" id="arrive_table">
                            <thead>
                                <tr>
                                    <th> الوافدون</th>
                                    <th>التصنيف</th>
                                    <th>تاريخ_البداية</th>
                                    <th>تاريخ_النهاية</th>
                                    <th>الاجانب المقيمون</th>
                                    <th>الجزائريون المقيمون</th>
                                    <th>الاجانب غير المقيمون</th>
                                    <th>الجزائريون غير المقيمون</th>
                                    <th>مجموع الوافدين</th>
                                </tr>
                            </thead>
                        </table>


                    </div>
                </div>
        </div>
        </section>

    </div>
    </div>
    <?php
    include('includes/footer.php');
    include('includes/script.php');
    ?>
    <script>
    $(document).ready(function() {
        var date = new Date();
        $('.input-daterange').datepicker({
            todayBtn: "linked",
            format: "yyyy-mm-dd",
            autoclose: true
        });
    });
    </script>
    <!-- ---------------------- LES ARRIVES -------------------------------------->
    <script>
    $(document).ready(function() {

        load_data();

        function load_data(from_date = '', to_date = '', filter_cat_etab = '') {
            var dataTable = $('#arrive_table').DataTable({
                "processing": true,
                "serverSide": true,
                "searching": false,
                "order": [],
                "ajax": {
                    url: "raport_arrive_total_action.php",
                    type: "POST",
                    data: {
                        action: 'fetch',
                        from_date: from_date,
                        to_date: to_date, 
                        filter_cat_etab: filter_cat_etab
                    },
                },
                "columnDefs": [{
                    "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8],
                    "orderable": false,
                }, ],
                dom: 'lBfrtip',
                buttons: [
                    'excel',
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
            });
        }
        $('#filter').click(function() {
            // var filter_section = $('#filter_section').val();
            // var filter_nation = $('#filter_nation').val();
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            var filter_cat_etab = $('#filter_cat_etab').val();
            // var filter_cat_etab = $('#filter_cat_etab').val();
            $('#arrive_table').DataTable().destroy();
            load_data(from_date, to_date, filter_cat_etab);
        });
        $('#refresh').click(function() {
            $('#from_date').val('');
            $('#to_date').val('');
            $('#filter_cat_etab').val('');
            // $('#filter_nation').val('');
            // $('#filter_cat_etab').val('');
            $('#arrive_table').DataTable().destroy();
            load_data();
        });

    });
    </script>