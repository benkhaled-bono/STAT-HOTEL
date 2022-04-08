<?php
include('stathotel.php');
$arrive = new stathotel();
if($arrive->is_login())
{
header("location:".$arrive->base_url."dashboard.php");
}
$pagetitle = 'Stat-Hotel تسجيل الدخول'; 

?>
<?php
include('includes/header.php');
// include('includes/navbar.php');
// include('includes/sidebar.php');
?>

<body class="hold-transition login-page">
    <div class="col-md-12 ">
        <img src="images/banner4.jpg" class="img-fluid" alt="banner">
    </div>
    <div class="login-box">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title-center">تسجيل الدخول</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form class="form-horizontal method=" post" id="login_form">
                <div class="card-body">
                    <span id="error"></span>
                    <div class="form-group row ">
                        <label for="user_email" class="col-sm-3 control-label">الايميل :</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" name="user_email" id="user_email"
                                placeholder="Email" data-parsley-type="email" data-parsley-trigger="keyup" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="user_password" class="col-sm-3 control-label">كلمة المرور :</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" name="user_password" id="user_password"
                                placeholder="Password" data-parsley-trigger="keyup" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-offset-2 col-sm-10">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck2">
                                <label class="form-check-label" for="exampleCheck2">تذكرني</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-info col-sm-12" name="login" id="login_button">دخول</button>
                </div>

            </form>
        </div> <!-- /.card -->



    </div>
   
    </div>
    <?php
include('includes/script.php');
?>
    <script>
    $(document).ready(function() {
        $('#login_form').parsley();
        $('#login_form').on('submit', function(event) {
            event.preventDefault();
            if ($('#login_form').parsley().isValid()) {
                $.ajax({
                    url: "login_action.php",
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: 'json',
                    beforeSend: function() {
                        $('#login_button').attr('disabled', 'disabled');
                        $('#login_button').val('wait...');
                    },
                    success: function(data) {
                        $('#login_button').attr('disabled', false);
                        if (data.error != '') {
                            $('#error').html(data.error);
                            $('#login_button').val('Login');
                        } else {
                            window.location.href =
                                "<?php echo $arrive->base_url; ?>dashboard.php";
                        }
                    }
                })
            }
        });
    });
    </script>
</body>

</html>