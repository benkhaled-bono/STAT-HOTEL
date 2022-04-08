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
            <br> <br>  <br> 
            <section class="content">

                <div class="card shadow mb-4">
                    <div class="card-header">
                        <div class="col-md-12">
                            <span id="message" class="text-center"></span>
                        </div>
                        <div class="row">
                            <h2 class="col-md-10"><i class="fas fa-hotel" style="font-size: larger; color:brown;"></i>
                                قائمة المؤسسات
                                الفندقية</h2>
                            <div class="col text-right">
                                <button type="button" name="add_etab" id="add_etab" class=" btn btn-primary "><i
                                        class="fas fa-plus"></i> اضافة مؤسسة</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-body">
                             <table id="etab_table" class="table display table-responsive" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>رقم</th>
                                        <th>حالة_الخدمة</th>
                                        <th>الاسم_بالعربي</th>
                                        <th>الاسم_بالفرنسية</th>
                                        <th>رقم_الرخصة</th>
                                        <th>تاريخ_الرخصة</th>
                                        <th>العنــــــــــــــــــــــــــــــــــــــــــوان</th>
                                        <th>الهاتف_الفاكس</th>
                                        <th>الايمايل</th>
                                        <th>الموقع_الالكتروني</th>
                                        <th>اجمالي_الغرف</th>
                                        <th>عدد_الغرف 2</th>
                                        <th>عدد_الغرف 3</th>
                                        <th>عدد الاسرة</th>
                                        <th>السعر المتوسط</th>
                                        <th>عدد الوجبات</th>
                                        <th>الوجبات_المباعة</th>
                                        <th>نسبة_الوجبات</th>
                                        <th>بيانات GPS X</th>
                                        <th>بيانات GPS Y</th>
                                        <th>لقب_المالك</th>
                                        <th>اسم_المالك</th>
                                        <th>تاريخ_الازدياد</th>
                                        <th>مكان_الازدياد</th>
                                        <th>اسم_الاب</th>
                                        <th>لقب_الام</th>
                                        <th>اسم_الام</th>
                                        <th>عنــــــوان_المـــــــــــــالك</th>
                                        <th>هاتف_المالك</th>
                                        <th>ايمايل_المالك</th>
                                        <th>تاريخ_الاضافة</th>
                                        <th>التصنيف</th>
                                        <th>القطاع</th>
                                        <th>Vocation</th>
                                        <th>النوع</th>
                                        <th>الولاية</th>
                                        <th>العمليــــــــــــات</th>
                                    </tr>
                                </thead>
                            </table>

                        </div>
                    </div>
                </div>
            </section>
            <div id="etabModal" class="modal fade ">
              
                    <form method="post" id="etab_form">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header" style="background-color:#28a745;">
                                    <h4 class="modal-title" id="modal_title">اضافة مؤسسة جديد</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body" dir="rtl">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="nom_etab_ar">اسم المؤسسة بالعربي :</label><span
                                                class="text-danger text-left">*</span>
                                            <input type="text" name="nom_etab_ar" id="nom_etab_ar" class="form-control"
                                                data-parsley-maxlength="150" data-parsley-trigger="keyup" />
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="nom_etab_fr">اسم المؤسسة بالفرنسي :</label><span
                                                class="text-danger text-left">*</span>
                                            <input type="text" name="nom_etab_fr" id="nom_etab_fr" class="form-control"
                                                data-parsley-maxlength="150" data-parsley-trigger="keyup" />
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="num_agrement">رقم الاعتماد :</label><span
                                                class="text-danger text-left">*</span>
                                            <input type="text" name="num_agrement" id="num_agrement"
                                                class="form-control"
                                                data-parsley-trigger="keyup" />
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="date_agrement">تاريخ الاعتماد :</label><span
                                                class="text-danger text-left">*</span>
                                            <input type="date" id="date_agrement" name="date_agrement"
                                                class="form-control" data-parsley-trigger="keyup" />
                                        </div>
                                         <div class="form-group col-md-4">
                                            <label for="adresse">عنوان المؤسسة :</label><span
                                                class="text-danger text-left">*</span>
                                            <input type="text" name="adresse" id="adresse" class="form-control" 
                                                data-parsley-maxlength="250" data-parsley-trigger="keyup" />
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="tel_fax">هاتف/فاكس المؤسسة :</label><span
                                                class="text-danger text-left">*</span>
                                            <input type="text" name="tel_fax" id="tel_fax" class="form-control" 
                                                data-parsley-minlength="09" data-parsley-maxlength="25"
                                                data-parsley-trigger="keyup" />
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="etab_email">ايميل المؤسسة :</label><span
                                                class="text-danger text-left">*</span>
                                            <input type="text" name="etab_email" id="etab_email" class="form-control"
                                                 data-parsley-type="email" data-parsley-maxlength="150"
                                                data-parsley-trigger="keyup" />
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="site_web">موقع الانترنت :</label><span
                                                class="text-danger text-left">*</span>
                                            <input type="text" name="site_web" id="site_web" class="form-control"
                                                data-parsley-maxlength="150" data-parsley-trigger="keyup" />
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="nbr_ch_s">اجمالي الغرف :</label><span
                                                class="text-danger text-left">*</span>
                                            <input type="number" min="0" max="10000" class="form-control"
                                                name="nbr_ch_s" id="nbr_ch_s"  data-parsley-trigger="keyup">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="nbr_ch_d">عدد الغرف الزوجية :</label><span
                                                class="text-danger text-left">*</span>
                                            <input type="number" min="0" max="10000" class="form-control"
                                                name="nbr_ch_d" id="nbr_ch_d" data-parsley-trigger="keyup">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="nbr_ch_t">عدد الغرف الثلاثية :</label><span
                                                class="text-danger text-left">*</span>
                                            <input type="number" min="0" max="10000" class="form-control"
                                                name="nbr_ch_t" id="nbr_ch_t" data-parsley-trigger="keyup">
                                        </div>
                                       <div class="form-group col-md-4">
                                            <label for="nbr_lits">عدد الاسرة :</label><span
                                                class="text-danger text-left">*</span>
                                            <input type="number" min="0" max="10000" class="form-control"
                                                name="nbr_lits" id="nbr_lits"  data-parsley-trigger="keyup">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="prix_chambre">السعر المتوسط للغرفة :</label><span
                                                class="text-danger text-left">*</span>
                                            <input type="number" min="0" class="form-control" name="prix_chambre"
                                                id="prix_chambre"  data-parsley-trigger="keyup"
                                                placeholder="دج...">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="capacite_couvert">طاقة الوجبات :</label><span
                                                class="text-danger text-left">*</span>
                                            <input type="number" min="0" class="form-control" name="capacite_couvert"
                                                id="capacite_couvert"  data-parsley-trigger="keyup">
                                        </div>
                                       <div class="form-group col-md-4">
                                            <label for="capacite_couvert_vendu">عدد الوجبات المباعة :</label><span
                                                class="text-danger text-left">*</span>
                                            <input type="number" min="0" class="form-control"
                                                name="capacite_couvert_vendu" id="capacite_couvert_vendu" 
                                                data-parsley-trigger="keyup">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="Coordonnees_GPS_X">Coordonnees_GPS_X :</label><span
                                                class="text-danger text-left">*</span>
                                            <input type="text" min="0" class="form-control" name="Coordonnees_GPS_X"
                                                id="Coordonnees_GPS_X"  data-parsley-trigger="keyup">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="Coordonnees_GPS_Y">Coordonnees_GPS_Y :</label><span
                                                class="text-danger text-left">*</span>
                                            <input type="text" min="0" class="form-control" name="Coordonnees_GPS_Y"
                                                id="Coordonnees_GPS_Y" data-parsley-trigger="keyup">
                                        </div>
                                       <div class="form-group col-md-4">
                                            <label for="nom_prop">لقب المالك :</label><span
                                                class="text-danger text-left">*</span>
                                            <input type="text" name="nom_prop" id="nom_prop" class="form-control"
                                                data-parsley-maxlength="150" data-parsley-trigger="keyup" />
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="prenom_prop">اسم المالك بالعربي :</label><span
                                                class="text-danger text-left">*</span>
                                            <input type="text" name="prenom_prop" id="prenom_prop" class="form-control"
                                                data-parsley-maxlength="150" data-parsley-trigger="keyup" />
                                        </div>
                                       <div class="form-group col-md-4">
                                            <label for="date_naiss_prop">تاريخ الازدياد :</label><span
                                                class="text-danger text-left">*</span>
                                            <input type="date" id="date_naiss_prop" name="date_naiss_prop"
                                                class="form-control"  data-parsley-trigger="keyup" />
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="lieu_naiss_prop"> مكان الازدياد بالعربي:</label><span
                                                class="text-danger text-left">*</span>
                                            <input type="text" name="lieu_naiss_prop" id="lieu_naiss_prop"
                                                class="form-control"  
                                                data-parsley-maxlength="150" data-parsley-trigger="keyup" />
                                        </div>
                                      <div class="form-group col-md-4">
                                            <label for="prenom_pere_prop">اسم أب المالك بالعربي:</label><span
                                                class="text-danger text-left">*</span>
                                            <input type="text" name="prenom_pere_prop" id="prenom_pere_prop"
                                                class="form-control" 
                                                data-parsley-maxlength="150" data-parsley-trigger="keyup" />
                                        </div>
                                             <div class="form-group col-md-4">
                                            <label for="nom_mere_prop">لقب أم المالك بالعربي:</label><span
                                                class="text-danger text-left">*</span>
                                            <input type="text" name="nom_mere_prop" id="nom_mere_prop"
                                                class="form-control" 
                                                data-parsley-maxlength="150" data-parsley-trigger="keyup" />
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="prenom_mere_prop">اسم أم المالك بالعربي:</label><span
                                                class="text-danger text-left">*</span>
                                            <input type="text" name="prenom_mere_prop" id="prenom_mere_prop"
                                                class="form-control"
                                                data-parsley-maxlength="150" data-parsley-trigger="keyup" />
                                        </div>
                                       <div class="form-group col-md-4">
                                            <label for="adresse_prop">عنوان المالك بالعربي:</label><span
                                                class="text-danger text-left">*</span>
                                            <input type="text" name="adresse_prop" id="adresse_prop"
                                                class="form-control" data-parsley-maxlength="250"
                                                data-parsley-trigger="keyup" />
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="mobile_prop">موبايل المالك :</label><span
                                                class="text-danger text-left">*</span>
                                            <input type="text" name="mobile_prop" id="mobile_prop" class="form-control"
                                                data-parsley-minlength="09" data-parsley-maxlength="12"
                                                data-parsley-trigger="keyup" />
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="prop_email">ايميل المالك :</label><span
                                                class="text-danger text-left">*</span>
                                            <input type="text" name="prop_email" id="prop_email" class="form-control"
                                                data-parsley-type="email" data-parsley-maxlength="150"
                                                data-parsley-trigger="keyup" />
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="cat_etab">التصنيف :</label><span
                                                class="text-danger text-left">*</span>
                                            <select name="cat_etab" id="cat_etab" class="form-control custom-select"
                                                 data-parsley-trigger="keyup">
                                                <option value="">إختر ...</option>
                                                <?php  echo $arrive->load_cat_etab(); ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="secteur_etab">القطاع :</label><span
                                                class="text-danger text-left">*</span>
                                            <select name="secteur_etab" id="secteur_etab"
                                                class="form-control custom-select" 
                                                data-parsley-trigger="keyup">
                                                <option value="">إختر ...</option>
                                                <?php echo $arrive->load_secteur_etab(); ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="vocation_etab">طبيعة المؤسسة :</label><span
                                                class="text-danger text-left">*</span>
                                            <select name="vocation_etab" id="vocation_etab"
                                                class="form-control custom-select" 
                                                data-parsley-trigger="keyup">
                                                <option value="">إختر ...</option>
                                                <?php  echo $arrive->load_vocation_etab(); ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="type_etab">نوع المؤسسة :</label><span
                                                class="text-danger text-left">*</span>
                                            <select name="type_etab" id="type_etab" class="form-control custom-select"
                                                 data-parsley-trigger="keyup">
                                                <option value="">إختر ...</option>
                                                <?php  echo $arrive->load_type_etab(); ?>
                                            </select>
                                        </div> 
                                    </div>
                                </div> <!-- END MODAL BODY  -->
                                <div class="modal-footer">
                                    <input type="hidden" name="hidden_id" id="hidden_id" />
                                    <input type="hidden" name="action" id="action" value="Add" />
                                    <input type="submit" name="submit" id="submit_button" class="btn btn-success" value="Add" />
                                    <button type="button" class="btn btn-default" data-dismiss="modal">خروج</button>
                                </div>
                            </div>
                        </div>
                    </form>
                
            </div>
        </div>
    </div>
    <?php
	include('includes/footer.php');
	include('includes/script.php');
	?>
    <script>
    $(document).ready(function() {
        var dataTable = $('#etab_table').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "etab_action.php",
                type: "POST",
                data: {
                    action: 'fetch'
                }
            },
            "columnDefs": [{
                "targets": [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20,
                    21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35],
                "orderable": false,
            }, ],
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel', 'print'
            ],
        });
        $('#add_etab').click(function() {
            $('#etab_form')[0].reset();
            $('#etab_form').parsley().reset();
            $('#modal_title').text('اضافة مؤسسة جديدة');
            $('#action').val('Add');
            $('#submit_button').val('حفظ');
            $('#etabModal').modal('show');
        });
       $('#etab_form').parsley();
        $('#etab_form').on('submit', function(event) {
            event.preventDefault();
            if ($('#etab_form').parsley().isValid()) {
                $.ajax({
                    url: "etab_action.php",
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#submit_button').attr('disabled', 'disabled');
                        $('#submit_button').val('wait...');
                    },
                    success: function(data) {
                        $('#submit_button').attr('disabled', false);
                        $('#etabModal').modal('hide');
                        $('#message').html(data);
                        dataTable.ajax.reload();
                        setTimeout(function() {
                            $('#message').html('');
                        }, 5000);
                    }
                })
            }
        });
        $(document).on('click', '.edit_button', function() {
            var etab_id = $(this).data('id');
            $('#etab_form').parsley().reset();
            $.ajax({
                url: "etab_action.php",
                method: "POST",
                data: {
                    etab_id: etab_id,
                    action: 'fetch_single'
                },
                dataType: 'JSON',
                success: function(data) {
                    $('#nom_etab_ar').val(data.nom_etab_ar);
                    $('#nom_etab_fr').val(data.nom_etab_fr);
                    $('#num_agrement').val(data.num_agrement);
                    $('#date_agrement').val(data.date_agrement);
                    $('#adresse').val(data.adresse);
                    $('#tel_fax').val(data.tel_fax);
                    $('#etab_email').val(data.etab_email);
                    $('#site_web').val(data.site_web);
                    $('#nbr_ch_s').val(data.nbr_ch_s);
                    $('#nbr_ch_d').val(data.nbr_ch_d);
                    $('#nbr_ch_t').val(data.nbr_ch_t);
                    $('#nbr_lits').val(data.nbr_lits);
                    $('#prix_chambre').val(data.prix_chambre);
                    $('#capacite_couvert').val(data.capacite_couvert);
                    $('#capacite_couvert_vendu').val(data.capacite_couvert_vendu);
                    $('#Coordonnees_GPS_X').val(data.Coordonnees_GPS_X);
                    $('#Coordonnees_GPS_Y').val(data.Coordonnees_GPS_Y);
                    $('#nom_prop').val(data.nom_prop);
                    $('#prenom_prop').val(data.prenom_prop);
                    $('#date_naiss_prop').val(data.date_naiss_prop);
                    $('#lieu_naiss_prop').val(data.lieu_naiss_prop);
                    $('#prenom_pere_prop').val(data.prenom_pere_prop);
                    $('#nom_mere_prop').val(data.nom_mere_prop);
                    $('#prenom_mere_prop').val(data.prenom_mere_prop);
                    $('#adresse_prop').val(data.adresse_prop);
                    $('#mobile_prop').val(data.mobile_prop);
                    $('#prop_email').val(data.prop_email);
                    $('#cat_etab').val(data.cat_etab);
                    $('#secteur_etab').val(data.secteur_etab);
                    $('#vocation_etab').val(data.vocation_etab);
                    $('#type_etab').val(data.type_etab);
                    $('#modal_title').text('تعديل البيانات');
                    $('#action').val('Edit');
                    $('#submit_button').val('تعديل');
                    $('#etabModal').modal('show');
                    $('#hidden_id').val(etab_id);
                }
            })
        });
        $(document).on('click', '.delete_button', function() {
            var id = $(this).data('id');
            var status = $(this).data('status');
            var next_status = 'Active';
            if (status == 'Active') {
                next_status = 'Inactive';
            }
            if (confirm("هل أنت متأكد أنك تريد " + next_status + " هذا المستخدم ؟")) {
                $.ajax({
                    url: "etab_action.php",
                    method: "POST",
                    data: {
                        id: id,
                        action: 'delete',
                        status: status,
                        next_status: next_status
                    },
                    success: function(data) {
                        $('#message').html(data);
                        dataTable.ajax.reload();
                        setTimeout(function() {
                            $('#message').html('');
                        }, 5000);
                    }
                });
            }
        });
        $(document).on('click', '.view_button', function() {
            var visitor_id = $(this).data('id');
            $.ajax({
                url: "visitor_action.php",
                method: "POST",
                data: {
                    visitor_id: visitor_id,
                    action: 'fetch_single'
                },
                dataType: 'JSON',
                success: function(data) {
                    $('#visitor_name_detail').text(data.visitor_name);
                    $('#visitor_email_detail').text(data.visitor_email);
                    $('#visitor_mobile_no_detail').text(data.visitor_mobile_no);
                    $('#visitor_address_detail').text(data.visitor_address);
                    $('#visitor_department_detail').text(data.visitor_department);
                    $('#visitor_meet_person_name_detail').text(data.visitor_meet_person_name);
                    $('#visitor_reason_to_meet_detail').text(data.visitor_reason_to_meet);
                    $('#visitor_outing_remark').val(data.visitor_outing_remark);
                    $('#visitordetailModal').modal('show');
                    $('#hidden_visitor_id').val(visitor_id);
                }
            })
        });
        $('#visitor_details_form').parsley();
        $('#visitor_details_form').on('submit', function(event) {
            event.preventDefault();
            if ($('#visitor_details_form').parsley().isValid()) {
                $.ajax({
                    url: "visitor_action.php",
                    method: "POST",
                    data: $(this).serialize(),
                    beforeSend: function() {
                        $('#detail_submit_button').attr('disabled', 'disabled');
                        $('#detail_submit_button').val('wait...');
                    },
                    success: function(data) {
                        $('#detail_submit_button').attr('disabled', false);
                        $('#detail_submit_button').val('Save');
                        $('#visitordetailModal').modal('hide');
                        $('#message').html(data);
                        dataTable.ajax.reload();
                        setTimeout(function() {
                            $('#message').html('');
                        }, 5000);
                    }
                });
            }
        });
    });
    </script>
</body>

</html>