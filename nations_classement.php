<?php
 include('stathotel.php');
 $arrive = new stathotel();
 if(!$arrive->is_login())
{
header("location:".$arrive->base_url."index.php");
}
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
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">

                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-left" style="font-size: 20px;">
                                <li class="breadcrumb-item"><a href="#">الرئيسية</a></li>
                                <li class="breadcrumb-item active">لوحة التحكم</li>
                            </ol>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <div class="row">
                        <!-- ( CARDS ) -->
                        <div class="col-md-6">
                            <div class="card card-danger">
                                <div class="card-header">
                                    <h3 class="card-title" style="font-size: 20px;"> الوافدون حسب الجنسيات و
                                        تصنيف الفنادق</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                                class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                                class="fas fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="card-body col-lg-12">
                                    <p>جنسية أجنية</p>
                                    <div class="row">
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-danger">
                                                <div class="inner">
                                                    <p class="p_stat" style="font-size: 18px;">*1</p>
                                                    <h3><?php echo $arrive->Get_total_arrives_by_cat_etab_section_arrive('nombre_arrive', '*', 'اجانب') ;?>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-danger">
                                                <div class="inner">
                                                    <p class="p_stat" style="font-size: 18px;">*2</p>
                                                    <h3><?php echo $arrive->Get_total_arrives_by_cat_etab_section_arrive('nombre_arrive', '**', 'اجانب') ;?>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-danger">
                                                <div class="inner">
                                                    <h3>00</h3>

                                                    <p class="p_stat" style="font-size: 18px;">*3</p>
                                                </div>
                                                <div class="icon">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-danger">
                                                <div class="inner">
                                                    <h3>00</h3>
                                                    <p class="p_stat" style="font-size: 18px;">*4</p>
                                                </div>
                                                <div class="icon">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-danger">
                                                <div class="inner">
                                                    <h3>00</h3>
                                                    <p class="p_stat" style="font-size: 16px;">غ-مصنف</p>
                                                </div>
                                                <div class="icon">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-danger">
                                                <div class="inner">
                                                    <h3>00</h3>
                                                    <p class="p_stat" style="font-size: 16px;">هياكل-أ</p>
                                                </div>
                                                <div class="icon">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <p>جنسية جزائرية</p>
                                    <div class="row">
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-danger">
                                                <div class="inner">
                                                    <h3>00</h3>
                                                    <p class="p_stat" style="font-size: 18px;">*1</p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-danger">
                                                <div class="inner">
                                                    <h3>00</h3>
                                                    <p class="p_stat" style="font-size: 18px;">*2</p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-danger">
                                                <div class="inner">
                                                    <h3>00</h3>
                                                    <p class="p_stat" style="font-size: 18px;">*3</p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-danger">
                                                <div class="inner">
                                                    <h3>00</h3>
                                                    <p class="p_stat" style="font-size: 18px;">*4</p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-danger">
                                                <div class="inner">
                                                    <h3>00</h3>
                                                    <p class="p_stat" style="font-size: 16px;">غ-مصنف</p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-danger">
                                                <div class="inner">
                                                    <h3>00</h3>
                                                    <p class="p_stat" style="font-size: 16px;">هياكل-أ</p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <p>أجــــــانب غير مقيمين</p>
                                    <div class="row">
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-danger">
                                                <div class="inner">
                                                    <h3>00</h3>
                                                    <p class="p_stat" style="font-size: 18px;">*1</p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-danger">
                                                <div class="inner">
                                                    <h3>00</h3>
                                                    <p class="p_stat" style="font-size: 18px;">*2</p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-danger">
                                                <div class="inner">
                                                    <h3>00</h3>
                                                    <p class="p_stat" style="font-size: 18px;">*3</p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-danger">
                                                <div class="inner">
                                                    <h3>00</h3>
                                                    <p class="p_stat" style="font-size: 18px;">*4</p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-danger">
                                                <div class="inner">
                                                    <h3>00</h3>
                                                    <p class="p_stat" style="font-size: 16px;">غ-مصنف</p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-danger">
                                                <div class="inner">
                                                    <h3>00</h3>
                                                    <p class="p_stat" style="font-size: 16px;">هياكل-أ</p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <p>جزائريين غير مقيمين</p>
                                    <div class="row">
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-danger">
                                                <div class="inner">
                                                    <h3>00</h3>
                                                    <p class="p_stat" style="font-size: 18px;">*1</p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-danger">
                                                <div class="inner">
                                                    <h3>00</h3>
                                                    <p class="p_stat" style="font-size: 18px;">*2</p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-danger">
                                                <div class="inner">
                                                    <h3>00</h3>
                                                    <p class="p_stat" style="font-size: 18px;">*3</p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-danger">
                                                <div class="inner">
                                                    <h3>00</h3>
                                                    <p class="p_stat" style="font-size: 18px;">*4</p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-danger">
                                                <div class="inner">
                                                    <h3>00</h3>
                                                    <p class="p_stat" style="font-size: 16px;">غ-مصنف</p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-danger">
                                                <div class="inner">
                                                    <h3>00</h3>
                                                    <p class="p_stat" style="font-size: 16px;">هياكل-أ</p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.card-body -->
                            </div><!-- /.card -->
                        </div>
                        <div class="col-md-6">
                            <div class="card card-success">
                                <div class="card-header">
                                    <h3 class="card-title" style="font-size: 20px;">الليالي حسب الجنسيات و تصنيف
                                        الفنادق</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                                class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                                class="fas fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="card-body col-lg-12">
                                    <p>جنسية أجنية</p>
                                    <div class="row">
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-success">
                                                <div class="inner">
                                                    <h3>00</h3>
                                                    <p class="p_stat" style="font-size: 18px;">*1</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-success">
                                                <div class="inner">
                                                    <h3>00</h3>

                                                    <p class="p_stat" style="font-size: 18px;">*2</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-success">
                                                <div class="inner">
                                                    <h3>00</h3>

                                                    <p class="p_stat" style="font-size: 18px;">*3</p>
                                                </div>
                                                <div class="icon">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-success">
                                                <div class="inner">
                                                    <h3>00</h3>
                                                    <p class="p_stat" style="font-size: 18px;">*4</p>
                                                </div>
                                                <div class="icon">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-success">
                                                <div class="inner">
                                                    <h3>00</h3>
                                                    <p class="p_stat" style="font-size: 16px;">غ-مصنف</p>
                                                </div>
                                                <div class="icon">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-success">
                                                <div class="inner">
                                                    <h3>00</h3>
                                                    <p class="p_stat" style="font-size: 16px;">هياكل-أ</p>
                                                </div>
                                                <div class="icon">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <p>جنسية جزائرية</p>
                                    <div class="row">
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-success">
                                                <div class="inner">
                                                    <h3>00</h3>
                                                    <p class="p_stat" style="font-size: 18px;">*1</p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-success">
                                                <div class="inner">
                                                    <h3>00</h3>
                                                    <p class="p_stat" style="font-size: 18px;">*2</p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-success">
                                                <div class="inner">
                                                    <h3>00</h3>
                                                    <p class="p_stat" style="font-size: 18px;">*3</p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-success">
                                                <div class="inner">
                                                    <h3>00</h3>
                                                    <p class="p_stat" style="font-size: 18px;">*4</p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-success">
                                                <div class="inner">
                                                    <h3>00</h3>
                                                    <p class="p_stat" style="font-size: 16px;">غ-مصنف</p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-success">
                                                <div class="inner">
                                                    <h3>00</h3>
                                                    <p class="p_stat" style="font-size: 16px;">هياكل-أ</p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <p>أجــــــانب غير مقيمين</p>
                                    <div class="row">
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-success">
                                                <div class="inner">
                                                    <h3>00</h3>
                                                    <p class="p_stat" style="font-size: 18px;">*1</p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-success">
                                                <div class="inner">
                                                    <h3>00</h3>
                                                    <p class="p_stat" style="font-size: 18px;">*2</p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-success">
                                                <div class="inner">
                                                    <h3>00</h3>
                                                    <p class="p_stat" style="font-size: 18px;">*3</p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-success">
                                                <div class="inner">
                                                    <h3>00</h3>
                                                    <p class="p_stat" style="font-size: 18px;">*4</p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-success">
                                                <div class="inner">
                                                    <h3>00</h3>
                                                    <p class="p_stat" style="font-size: 16px;">غ-مصنف</p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-success">
                                                <div class="inner">
                                                    <h3>00</h3>
                                                    <p class="p_stat" style="font-size: 16px;">هياكل-أ</p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <p>جزائريين غير مقيمين</p>
                                    <div class="row">
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-success">
                                                <div class="inner">
                                                    <h3>00</h3>
                                                    <p class="p_stat" style="font-size: 18px;">*1</p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-success">
                                                <div class="inner">
                                                    <h3>00</h3>
                                                    <p class="p_stat" style="font-size: 18px;">*2</p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-success">
                                                <div class="inner">
                                                    <h3>00</h3>
                                                    <p class="p_stat" style="font-size: 18px;">*3</p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-success">
                                                <div class="inner">
                                                    <h3>00</h3>
                                                    <p class="p_stat" style="font-size: 18px;">*4</p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-success">
                                                <div class="inner">
                                                    <h3>00</h3>
                                                    <p class="p_stat" style="font-size: 16px;">غ-مصنف</p>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg-2 arrive_stat ">
                                            <!-- small box -->
                                            <div class="small-box bg-success">
                                                <div class="inner">
                                                    <h3>00</h3>
                                                    <p class="p_stat" style="font-size: 16px;">هياكل-أ</p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
  
                    </div>
                                          <!-- ******************************************* GLOBAL BOXES ************************************* -->
                                          <div class="row">
                            <div class="col-lg-3 ">
                                <!-- small box -->
                                <div class="small-box bg-success">
                                    <div class="inner">
                                        <h3><?php echo $arrive->Get_total_arrives('nombre_arrive', 'اجانب')?></h3>
                                        <p style="font-size: 20px;">الوافدون : أجانب</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-stats-bars"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">More info <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <!-- small box -->
                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <h3><?php echo $arrive->Get_total_arrives('nombre_arrive', 'جزائريين_غير_مقيمين')?>
                                        </h3>

                                        <p style="font-size: 18px;">الوافدون : جزائريون غير مقيمين</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-pie-graph"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">More info <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                            <div class="col-lg-3 ">
                                <!-- small box -->
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3><?php echo $arrive->Get_total_nuitee('nuite_mois', 'اجانب');?></h3>
                                        <p style="font-size: 20px;">الليــالي : أجانــب</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-stats-bars"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">More info <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 ">

                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo $arrive->Get_total_nuitee('nuite_mois', 'جزائريين_غير_مقيمين');?>
                                        </h3>
                                        <p style="font-size: 20px;">الليــالي : جزائريون غير مقيمون</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-pie-graph"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">More info <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-3 ">
                                <!-- small box -->
                                <div class="small-box bg-success">
                                    <div class="inner">
                                        <h3><?php echo $arrive->Get_total_arrives('nombre_arrive', 'جزائريين')?></h3>
                                        <p style="font-size: 20px;">الوافدون : جزائريين</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-stats-bars"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">More info <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <!-- small box -->
                                <div class="small-box bg-danger">
                                    <div class="inner">

                                        <h3><?php echo $arrive->Get_total_arrives('nombre_arrive', 'اجانب_غير_مقيمين')?>
                                        </h3>
                                        <p style="font-size: 20px;">الوافدون : اجانب غير مقيمين</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-pie-graph"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">More info <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                            <div class="col-lg-3 ">
                                <!-- small box -->
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3><?php echo $arrive->Get_total_nuitee('nuite_mois', 'جزائريين');?></h3>
                                        <p style="font-size: 20px;">الليــالي : جزائريون </p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-stats-bars"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">More info <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-3 ">

                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3><?php echo $arrive->Get_total_nuitee('nuite_mois', 'اجانب_غير_مقيمين');?>
                                        </h3>
                                        <p style="font-size: 20px;">الليــالي : أجانب غير مقيمون </p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-pie-graph"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">More info <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                        </div>















            </section>
        </div>
    </div>

    <?php
  include('includes/footer.php') ; 
?>
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <?php
  include('includes/script.php') ; 
?>
    <script>
    $(function() {
        /* ChartJS
         * -------
         * Here we will create a few charts using ChartJS
         */

        //--------------
        //- AREA CHART -
        //--------------

        // Get context with jQuery - using jQuery's .get() method.
        var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

        var areaChartData = {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [{
                    label: 'غير المقيمين أجانب',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: [28, 48, 40, 19, 86, 27, 90]
                },
                {
                    label: 'غير المقيمين جزائريين',
                    backgroundColor: 'rgba(210, 214, 222, 1)',
                    borderColor: 'rgba(210, 214, 222, 1)',
                    pointRadius: false,
                    pointColor: 'rgba(210, 214, 222, 1)',
                    pointStrokeColor: '#c1c7d1',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',
                    data: [65, 59, 80, 81, 56, 55, 40]
                },
            ]
        }

        var areaChartOptions = {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                display: false
            },
            scales: {
                xAxes: [{
                    gridLines: {
                        display: false,
                    }
                }],
                yAxes: [{
                    gridLines: {
                        display: false,
                    }
                }]
            }
        }
        // This will get the first returned node in the jQuery collection.
        var areaChart = new Chart(areaChartCanvas, {
            type: 'line',
            data: areaChartData,
            options: areaChartOptions
        })

        //-------------
        //- LINE CHART -
        //--------------
        // var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
        // var lineChartOptions = jQuery.extend(true, {}, areaChartOptions)
        // var lineChartData = jQuery.extend(true, {}, areaChartData)
        // lineChartData.datasets[0].fill = false;
        // lineChartData.datasets[1].fill = false;
        // lineChartOptions.datasetFill = false

        // var lineChart = new Chart(lineChartCanvas, { 
        //   type: 'line',
        //   data: lineChartData, 
        //   options: lineChartOptions
        // })

        //-------------
        //- DONUT CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
        var donutData = {
            labels: [
                'غير مقيمين أجانب',
                'غير مقيمين جزائريين',
                'مقيمين أجانب',
                'مقيمين جزائريين',
                // 'Opera',
                // 'Navigator',
            ],
            datasets: [{
                data: [700, 500, 400, 600],
                backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef'],
            }]
        }
        var donutOptions = {
            maintainAspectRatio: false,
            responsive: true,
        }
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        var donutChart = new Chart(donutChartCanvas, {
            type: 'doughnut',
            data: donutData,
            options: donutOptions
        })

        //-------------
        //- PIE CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        // var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
        // var pieData        = donutData;
        // var pieOptions     = {
        //   maintainAspectRatio : false,
        //   responsive : true,
        // }
        // //Create pie or douhnut chart
        // // You can switch between pie and douhnut using the method below.
        // var pieChart = new Chart(pieChartCanvas, {
        //   type: 'pie',
        //   data: pieData,
        //   options: pieOptions      
        // })

        //-------------
        //- BAR CHART -
        //-------------
        var barChartCanvas = $('#barChart').get(0).getContext('2d')
        var barChartData = jQuery.extend(true, {}, areaChartData)
        var temp0 = areaChartData.datasets[0]
        var temp1 = areaChartData.datasets[1]
        barChartData.datasets[0] = temp1
        barChartData.datasets[1] = temp0

        var barChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            datasetFill: false
        }

        var barChart = new Chart(barChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
        })

        //---------------------
        //- STACKED BAR CHART -
        //---------------------
        // var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
        // var stackedBarChartData = jQuery.extend(true, {}, barChartData)

        // var stackedBarChartOptions = {
        //   responsive              : true,
        //   maintainAspectRatio     : false,
        //   scales: {
        //     xAxes: [{
        //       stacked: true,
        //     }],
        //     yAxes: [{
        //       stacked: true
        //     }]
        //   }
        // }

        // var stackedBarChart = new Chart(stackedBarChartCanvas, {
        //   type: 'bar', 
        //   data: stackedBarChartData,
        //   options: stackedBarChartOptions
        // })
    })
    </script>
</body>

</html>