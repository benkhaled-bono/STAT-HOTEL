<?php
//dashboard.php
 include('vms.php');
 $visitor = new vms();
 if(!$visitor->is_login())
{
header("location:".$visitor->base_url."index.php");
}
?>
<?php
include('includes/header.php') ; 
include('includes/navbar.php') ; 
include('includes/sidebar.php') ; 
?>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">لوحة التحكم</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">الرئيسة</a></li>
                                <li class="breadcrumb-item active">لوحة التحكم</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h4>قائمة المشاركين</h4>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="row input-daterange">
                                            <div class="col-md-6">
                                                <input type="text" name="from_date" id="from_date"
                                                    class="form-control form-control-sm" placeholder="من" readonly />
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" name="to_date" id="to_date"
                                                    class="form-control form-control-sm" placeholder="إلى" readonly />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <button type="button" name="filter" id="filter" class="btn btn-info btn-sm"><i
                                                class="fas fa-filter"></i></button>
                                        <button type="button" name="refresh" id="refresh"
                                            class="btn btn-secondary btn-sm"><i class="fas fa-sync-alt"></i></button>
                                    </div>
                                    <div class="col-md-2" align="left">
                                        <button type="button" name="add_visitor" id="add_visitor"
                                            class="btn btn-success btn-sm"><i class="fas fa-user-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                            
                                <table id="visitor_table" class="table table-bordered table-hover table-responsive table-striped" style="width:100%">
                                    <thead class="headertable">
                                        <tr>
                                            <th>اسم-المؤسسة</th>
                                            <th>العنوان</th>
                                            <th>الدائرة</th>
                                            <th>الهاتف</th>
                                            <th>الايميل</th>
                                            <th>اسم_لمالك</th>
                                            <th>اسم_المسير</th>
                                            <th>رقم_س_لتجاري</th>
                                            <th>تاريخ_بداية_النشاط</th>
                                            <th>نوع_النشاط</th>
                                            <th>طاقة_الاستيعاب</th>
                                            <th>تاريخ_التسجيل</th>
                                            <?php
                                            if($visitor->is_master_user())
                                            {
                                               echo '<th>Aj.par</th>';
                                            }
                                            ?>
                                             <th>التعديــل</th>
                                             <th>الحـــذف</th>
                                        </tr>
                                    </thead>
                                   
                                  
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
    </div>
    <?php
include('includes/footer.php') ; 
include('includes/script.php') ; 
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
  <script>
  $(document).ready(function() 
{
            load_data();

function load_data(from_date = '', to_date = '') 
{
    var dataTable = $('#visitor_table').DataTable({
          
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            url: "arrive_action.php",
            type: "POST",
           
            data: {
                action: 'fetch',
                from_date: from_date,
                to_date: to_date
            }
        },
        "columnDefs": [{
                        <?php
                        if($visitor->is_master_user())
                        {
                        ?> "targets": [12],
                        <?php
                        }
                        else
                        {
                        ?> "targets": [11],
                        <?php
                        }
									?> "orderable": false,
								}, ],
       // dom: 'Bfrtip',
//buttons: [
//'excel', 'print'
//],
});
}

$('#filter').click(function() {
                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();
                $('#visitor_table').DataTable().destroy();
                load_data(from_date, to_date);
            });

            $('#refresh').click(function() {
                $('#from_date').val('');
                $('#to_date').val('');
                $('#visitor_table').DataTable().destroy();
                load_data();
            });

            // $('#export').click(function() {
            //     var from_date = $('#from_date').val();
            //     var to_date = $('#to_date').val();

            //     if (from_date != '' && to_date != '') {
            //         window.location.href =
            //             "<?php //echo //$visitor->base_url; ?>export.php?from_date=" + from_date +
            //             "&to_date=" + to_date + "";
            //     } else {
            //         window.location.href = "<?php //echo $visitor->base_url; ?>export.php";
            //     }
            // });

});
</script>
</body>
</html>

