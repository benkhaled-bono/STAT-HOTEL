<?php
include('stathotel.php');
$arrive = new stathotel();
if($_POST["user_email"])
{
    //sleep(2);
	$error = '';
	$data = array(
		':admin_email'	=>	$_POST["user_email"]
	);

	$arrive->query = "
	SELECT * FROM admin_table 
 	WHERE admin_email = :admin_email	 
	";
	$arrive->execute($data);
	//$statement = $arrive->connect->prepare($query);
	//$statement->execute($data);
	//$total_row = $statement->rowCount();
	$total_row = $arrive->row_count();
	if($total_row == 0)
	{
		$error = '<div class="alert alert-danger">عنوان بريد إلكتروني خاطئ !</div>';
	}
	else
	{
		// $result = $statement->fetchAll();
		$result = $arrive->statement_result();

		foreach($result as $row)
		{
			if($row["admin_status"] == 'Enable')
			{
				if(password_verify($_POST["user_password"], $row["admin_password"]))
				{
					$_SESSION['admin_id'] 	= $row['admin_id'];
					$_SESSION['admin_type'] = $row['admin_type'];
					$_SESSION['wilaya_id'] 	= $row['wilaya_ID'];
					$_SESSION['etab_id'] 	= $row['etab_ID'];
				}
				else
				{
					$error = '<div class="alert alert-danger">كلمة المرور خاطئة !</div>';
				}
			}
			else
			{
				$error = '<div class="alert alert-danger">عذرا ، لقد تم إلغاء تنشيط حسابك ، اتصل بالمدير</div>';
			}
		}
	}

	$output = array(
		'error'		=>	$error
	);
	echo json_encode($output);
}
?>