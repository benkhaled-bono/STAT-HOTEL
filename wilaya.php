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
            <br>
            <section class="content">
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <br> <br>
                        <div class="col-md-12">
                            <span id="message" class="text-center"></span>
                        </div>
                        <div class="row">
                            <h2 class="col-md-10"> 
                            <i class="fas fa-city" style="font-size: larger; color:black;"></i> ادارة الولايات</h2>
                            <div class="col text-right">
                                <button type="button" name="add_user" id="add_user" class=" btn btn-primary"><i
                                        class="fas fa-plus"></i> اضافة ولاية</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-body">
                                 <table id="user_table" class="table display " style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>اسم الولاية</th>
                                            <th>رقم الهاتف</th>
                                            <th>الايميل</th>
                                            <th>الحالة</th>
                                            <th>العمليات</th>
                                        </tr>
                                    </thead>
                                </table>
                        </div>
                    </div>
                </div>
            </section>
            <div id="userModal" class="modal fade text-left">
                <div class="modal-dialog">
                    <form method="post" id="user_form" enctype="multipart/form-data">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color:#28a745;" >
                                <h4 class="modal-title" id="modal_title">اضافة ولاية جديدة</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group text-left ">
                                    <div class="row text-left">
                                        <label class="col-md-6 text-left">اسم الولاية بالعربي<span
                                                class="text-danger text-left">*</span></label>
                                        <div class="col-md-10">
                                            <input type="text" name="admin_name" id="admin_name" class="form-control"
                                                required data-parsley-pattern="/^[ا-ي]+$/"
                                                data-parsley-maxlength="150" data-parsley-trigger="keyup" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-md-6 text-left">رقم الهاتف<span
                                                class="text-danger text-left">*</span></label>
                                        <div class="col-md-10 text-left">
                                            <input type="text" name="admin_contact_no" id="admin_contact_no"
                                                class="form-control" required data-parsley-type="integer"
                                                data-parsley-minlength="09" data-parsley-maxlength="12"
                                                data-parsley-trigger="keyup" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-md-6 text-left">الايميل<span
                                                class="text-danger text-left">*</span></label>
                                        <div class="col-md-10 text-left">
                                            <input type="text" name="admin_email" id="admin_email" class="form-control"
                                                required data-parsley-type="email" data-parsley-maxlength="150"
                                                data-parsley-trigger="keyup" />
                                        </div>
                                    </div>
                                </div>
                            
                           
                                <?php
								if ($arrive->is_master_user()) {
								?>
                                <div class="form-group">
                                    <div class="row">
                                        <label for="wilaya" class="col-md-4 text-left">الولاية :</label>
                                        <div class="col-md-10 text-left">
                                            <select name="wilaya" id="wilaya" class="custom-select">
                                                     <option value="">إختر ...</option>
                                                <?php echo $arrive->load_wilaya_for_master(); ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <?php
								}
								?>
                                  <?php
								if ($arrive->is_dta_user()) {
								?>
                                <div class="form-group">
                                    <div class="row">
                                        <label for="etab" class="col-md-4 text-left">المؤسسة الفندقية</label>
                                        <div class="col-md-10 text-left">
                                            <select name="etab" id="etab" class="custom-select">
                                                     <option value="">إختر في حالة المستخدم ''Hotel</option>
                                                <?php echo $arrive->load_etab_for_dta(); ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <?php
								}
								?>
                                
								 <br>
                                <div class="form-group">
                                    <div class="row">
                                        <label class="col-md-4 text-left"> اختر الصورة </label>
                                        <div class="col-md-10 col-md-8">
                                            <input type="file" name="user_image" id="user_image" />
                                            <span id="user_uploaded_image"></span>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="hidden_id" id="hidden_id" />
                                <input type="hidden" name="action" id="action" value="Add" />
                                <input type="submit" name="submit" id="submit_button" class="btn btn-success"
                                    value="Add" />
                                <button type="button" class="btn btn-default" data-dismiss="modal">خروج</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
	include('includes/footer.php');
	include('includes/script.php');
	?>
    <script>
    $(document).ready(function() {
        var dataTable = $('#user_table').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "wilaya_action.php",
                type: "POST",
                data: {
                    action: 'fetch'
                }
            },
            dom: 'lBfrtip',
            "columnDefs": [{
                "targets": [0,1,2,3,4,5],
                 "orderable": false,
                }, ],
            dom: 'lBfrtip',
                buttons: [
                    'copy', 'excel','print'
                ],
        });
        $('#add_user').click(function() {
            $('#user_form')[0].reset();
            $('#user_form').parsley().reset();
            $('#modal_title').text('اضافة مستخدم جديد');
            $('#action').val('Add');
            $('#submit_button').val('حفظ');
            $('#userModal').modal('show');
            $('#admin_password').attr('required', true);
            $('#admin_password').attr('data-parsley-minlength', '6');
            $('#admin_password').attr('data-parsley-maxlength', '16');
            $('#admin_password').attr('data-parsley-trigger', 'keyup');
        });
        $('#user_image').change(function() {
            var extension = $('#user_image').val().split('.').pop().toLowerCase();
            if (extension != '') {
                if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                    alert("ملف الصورة غير مدعم");
                    $('#user_image').val('');
                    return false;
                }
            }
        });
        $('#user_form').parsley();
        $('#user_form').on('submit', function(event) {
            event.preventDefault();
            if ($('#user_form').parsley().isValid()) {
                var extension = $('#user_image').val().split('.').pop().toLowerCase();
                if (extension != '') {
                    if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                        alert("ملف الصورة غير مدعم");
                        $('#user_image').val('');
                        return false;
                    }
                }
                $.ajax({
                    url: "user_action.php",
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
                        $('#userModal').modal('hide');
                        $('#message').html(data);
                        dataTable.ajax.reload();
                        setTimeout(function() {
                            $('#message').html('');
                        }, 4000);
                    }
                })
            }
        });
        $(document).on('click', '.edit_button', function() {
            var admin_id = $(this).data('id');
            $('#user_form').parsley().reset();
            $.ajax({
                url: "user_action.php",
                method: "POST",
                data: {
                    admin_id: admin_id,
                    action: 'fetch_single'
                },
                dataType: 'JSON',
                success: function(data) {
                    $('#admin_name').val(data.admin_name);
                    $('#admin_email').val(data.visitor_email);
                    $('#admin_contact_no').val(data.admin_contact_no);
                    $('#admin_email').val(data.admin_email);
                    $('#user_uploaded_image').html('<img src="' + data.admin_profile +
                        '" class="img-fluid img-thumbnail" width="75" height="75" /><input type="hidden" name="hidden_user_image" value="' +
                        data.admin_profile + '" />');
                    $('#admin_password').attr('required', false);
                    // $('#admin_password').attr('data-parsley-minlength', '');
                    // $('#admin_password').attr('data-parsley-maxlength', '');
                    // $('#admin_password').attr('data-parsley-trigger', '');
                    $('#wilaya').val(data.wilaya);
                    $('#modal_title').text('Edit Data');
                    $('#action').val('Edit');
                    $('#submit_button').val('Edit');
                    $('#userModal').modal('show');
                    $('#hidden_id').val(admin_id);
                }
            })
        });
        $(document).on('click', '.delete_button', function() {
            var id = $(this).data('id');
            var status = $(this).data('status');
            var next_status = 'Enable';
            if (status == 'Enable') {
                next_status = 'Disable';
            }
            if (confirm("هل أنت متأكد أنك تريد " + next_status + " هذا المستخدم ؟")) {
                $.ajax({
                    url: "user_action.php",
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
                    $('#visitor_meet_person_name_detail').text(data
                        .visitor_meet_person_name);
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