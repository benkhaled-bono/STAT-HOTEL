<?php
 include('stathotel.php');
 $arrive = new stathotel();
 if(!$arrive->is_login())
{
header("location:".$arrive->base_url."index.php");
}
$pagetitle = 'لوحة التحكم'; 

?>
<?php
include('includes/header.php') ;
?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php 
include('includes/navbar.php') ; 
include('includes/sidebar.php') ; 
?>
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    <!-- HOTELS PARCS ----------------------------------------------------------------------------------------->
                    <div class="content-header">
                        <br><br><br>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <h4><i class="fas fa-h-square" style="font-size: larger; color:brown;"></i> الحضيـرة
                                    الفندقية
                                </h4>
                            </div>
                            <div class="col-md-6">
                                <ol class="breadcrumb float-md-right">
                                    <li class="breadcrumb-item" style="font-size: 20px;"><a href="#">لوحة التحكم</a></li>
                                    <li class="breadcrumb-item active" style="font-size: 20px;">إحصـائيات عامة</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 ">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <div class="row">
                                        <h5 class="col-md-10">
                                            <i class="fas fa-hotel" style="font-size: larger; color:black;"></i>
                                            عدد الفنادق
                                        </h5>
                                    </div>
                                    <h3><?php  echo $arrive->total_etab()?></h3>
                                </div>
                                <a href="etab_hebergement.php" class="small-box-footer"> الحضيرة <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 ">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <div class="row">
                                        <h5 class="col-md-10">
                                            <i class="fas fa-store-alt" style="font-size: larger; color:black;"></i>
                                            فنادق متوقفة
                                        </h5>
                                    </div>
                                    <h3><?php  echo $arrive->total_etab_inactive()?></h3>
                                </div>
                                <a href="etab_hebergement.php" class="small-box-footer"> الحضيرة <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 ">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <div class="row">
                                        <h5 class="col-md-10">
                                            <i class="fas fa-person-booth" style="font-size: larger; color:black;"></i>
                                            عدد الغرف
                                        </h5>
                                    </div>
                                    <h3><?php  echo $arrive->Get_sum_rooms()?>
                                    </h3>
                                </div>
                                <a href="etab_hebergement.php" class="small-box-footer"> الحضيرة <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 ">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <div class="row">
                                        <h5 class="col-md-10">
                                            <i class="fas fa-bed" style="font-size: larger; color:black;"></i>
                                            عدد الأسرة
                                        </h5>
                                    </div>
                                    <h3><?php  echo $arrive->Get_sum_beds()?></h3>
                                </div>
                                <a href="etab_hebergement.php" class="small-box-footer"> الحضيرة <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>



                    <!-- ------------------------------- GLOBAL STATS BOXES --------------------------------------------------->
                    <div class="content-header">
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <h4><i class="fas fa-users-cog" style="font-size: larger; color:brown;"></i> عدد وافدي
                                    الشهر الحالي</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 ">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <div class="row">
                                        <h5 class="col-md-10">
                                            <i class="fas fa-users" style="font-size: larger; color:black;"></i>
                                            أجانب مقيمون
                                        </h5>
                                    </div>
                                    <h3><?php  echo $arrive->Get_total_arrives('nombre_arrive', 1)?></h3>
                                </div>
                                <a href="raport_arrive_total.php" class="small-box-footer"> احصاء الوافدين <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 ">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <div class="row">
                                        <h5 class="col-md-10">
                                            <i class="fas fa-users" style="font-size: larger; color:black;"></i>
                                            جزائريون مقيمون
                                        </h5>
                                    </div>
                                    <h3><?php  echo $arrive->Get_total_arrives('nombre_arrive', 2)?></h3>
                                </div>
                                <a href="raport_arrive_total.php" class="small-box-footer"> احصاء الوافدين <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 ">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <div class="row">
                                        <h5 class="col-md-10">
                                            <i class="fas fa-users" style="font-size: larger; color:black;"></i>
                                            أجانب غ مقيمون
                                        </h5>
                                    </div>
                                    <h3><?php  echo $arrive->Get_total_arrives('nombre_arrive', 3)?></h3>
                                </div>
                                <a href="raport_arrive_total.php" class="small-box-footer"> احصاء الوافدين <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 ">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <div class="row">
                                        <h5 class="col-md-10">
                                            <i class="fas fa-users" style="font-size: larger; color:black;"></i>
                                            جزائريون غ مقيمون
                                        </h5>
                                    </div>
                                    <h3><?php  echo $arrive->Get_total_arrives('nombre_arrive', 4)?></h3>
                                </div>
                                <a href="raport_arrive_total.php" class="small-box-footer"> احصاء الوافدين <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <!-- LES NUITEES -------------------------------------------------------------------------------------- -->
                    <div class="content-header">
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <h4><i class="fas fa-bed" style="font-size: larger; color:brown;"></i> عدد الليالي
                                    الشهر الحالي</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 ">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <div class="row">
                                        <h5 class="col-md-10">
                                            <i class="fas fa-bed" style="font-size: larger; color:black;"></i>
                                            أجانب مقيمون
                                        </h5>
                                    </div>
                                    <h3><?php  echo $arrive->Get_sum_nuitees('nuite_mois', 1)?></h3>
                                </div>
                                <a href="raport_nuitee_total.php" class="small-box-footer"> احصاء الليالي <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 ">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <div class="row">
                                        <h5 class="col-md-10">
                                            <i class="fas fa-bed" style="font-size: larger; color:black;"></i>
                                            جزائريون مقيمون
                                        </h5>
                                    </div>
                                    <h3><?php  echo $arrive->Get_sum_nuitees('nuite_mois', 2)?></h3>
                                </div>
                                <a href="raport_nuitee_total.php" class="small-box-footer"> احصاء الليالي <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 ">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <div class="row">
                                        <h5 class="col-md-10">
                                            <i class="fas fa-bed" style="font-size: larger; color:black;"></i>
                                            أجانب غ مقيمون
                                        </h5>
                                    </div>
                                    <h3><?php  echo $arrive->Get_sum_nuitees('nuite_mois', 3)?></h3>
                                </div>
                                <a href="raport_nuitee_total.php" class="small-box-footer"> احصاء الليالي <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 ">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <div class="row">
                                        <h5 class="col-md-10">
                                            <i class="fas fa-bed" style="font-size: larger; color:black;"></i>
                                            جزائريون غ مقيمون
                                        </h5>
                                    </div>
                                    <h3><?php  echo $arrive->Get_sum_nuitees('nuite_mois', 4)?></h3>
                                </div>
                                <a href="raport_nuitee_total.php" class="small-box-footer"> احصاء الليالي <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>







                    <!-- START CHARTS---------------------------------------------------------------------------------------------------------------------------------->
                    <div class="row">
                        <!-- DONUT CHART ---------------------------------------------------->
                        <div class="col-md-6">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">الشهر الحالي : عدد الليالي حسب تصنيف الفنادق </h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                                class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                                class="fas fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <canvas id="doughnut_chart" style="height:230px; min-height:230px"></canvas>
                                </div>
                            </div>
                        </div>
                        <!-- BAR CHART------------------------------------------------------------------------------------------------------------------------>
                        <div class="col-md-6">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">الشهر الحالي : عدد الليالي حسب الجنسيات </h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                                class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                                class="fas fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container pie-chart">
                                        <canvas id="bar_chart"></canvas>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    </div>

                </div>
            </section>
        </div>
    </div>
    <?php
  include('includes/footer.php') ; 
?>
    <aside class="control-sidebar control-sidebar-dark">
    </aside>
    </div>
    <?php
  include('includes/script.php') ; 
?>
    <script>
    $(document).ready(function() {
        make_doughnut_chart();
        // make_bar_chart();
        function make_doughnut_chart() {
            $.ajax({
                url: "data.php",
                method: "POST",
                data: {
                    action: 'fetch_doughnut_chart'
                },
                dataType: "JSON",
                success: function(data) {
                    var cat_etab = [];
                    var total = [];
                    var color = [];
                    for (var count = 0; count < data.length; count++) {
                        cat_etab.push(data[count].cat_etab);
                        total.push(data[count].total);
                        color.push(data[count].color);
                    }
                    var chart_data = {
                        labels: cat_etab,
                        datasets: [{
                            backgroundColor: color,
                            color: '#fff',
                            data: total
                        }]
                    };
                    var options = {
                        responsive: true,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    min: 0
                                }
                            }]
                        }
                    };
                    var group_chart2 = $('#doughnut_chart');
                    var graph2 = new Chart(group_chart2, {
                        type: "doughnut",
                        data: chart_data
                    });
                }
            })
            $.ajax({
                url: "data.php",
                method: "POST",
                data: {
                    action: 'fetch_bar_chart'
                },
                dataType: "JSON",
                success: function(data) {
                    var nom_section_arrive = [];
                    var total = [];
                    var color = [];
                    for (var count = 0; count < data.length; count++) {
                        nom_section_arrive.push(data[count].nom_section_arrive);
                        total.push(data[count].total);
                        color.push(data[count].color);
                    }
                    var chart_data = {
                        labels: nom_section_arrive,
                        datasets: [{
                            label: 'الليالي',
                            backgroundColor: color,
                            color: '#fff',
                            data: total
                        }]
                    };
                    var options = {
                        responsive: true,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    min: 0
                                }
                            }]
                        }
                    };
                    var group_chart3 = $('#bar_chart');
                    var graph3 = new Chart(group_chart3, {
                        type: 'bar',
                        data: chart_data,
                        options: options
                    });
                }
            })
        }
    });
    </script>
</body>
</html>