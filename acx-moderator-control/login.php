<?php
require_once('../init.php');
?>
<!DOCTYPE html>
<html lang="tr">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="robots" content="noindex">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title><?php echo PROJECT; ?> - M-Kontrol Paneli</title>


	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="<?php echo ADMIN_THEME_URL; ?>/global_assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="<?php echo ADMIN_THEME_URL; ?>/global_assets/css/icons/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo ADMIN_THEME_URL; ?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo ADMIN_THEME_URL; ?>/assets/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo ADMIN_THEME_URL; ?>/assets/css/layout.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo ADMIN_THEME_URL; ?>/assets/css/components.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo ADMIN_THEME_URL; ?>/assets/css/colors.min.css" rel="stylesheet" type="text/css">



	<script src="<?php echo ADMIN_THEME_URL; ?>/global_assets/js/main/jquery.min.js"></script>
	<script src="<?php echo ADMIN_THEME_URL; ?>/global_assets/js/main/bootstrap.bundle.min.js"></script>
	<script src="<?php echo ADMIN_THEME_URL; ?>/global_assets/js/plugins/loaders/blockui.min.js"></script>
	
	<script src="<?php echo ADMIN_THEME_URL; ?>/global_assets/js/plugins/forms/styling/uniform.min.js"></script>

	<script src="<?php echo ADMIN_THEME_URL; ?>/assets/js/app.js"></script>

</head>

<body class="bg-slate-800">


	<div class="page-content">

	
		<div class="content-wrapper">

	
			<div class="content d-flex justify-content-center align-items-center">


				<form class="login-form" action="" method="post" style="width:480px">
					<div class="card mb-0">
						<div class="card-body">
							<div class="text-center mb-3">
								<br>
								<h5 class="mb-0">Moderatör Kontrol Giriş</h5>
							</div>
							<?php
							if($_POST)
							{
								
								if($db->table('md_control')->where('email','=',m_a_p('email'))->where('password','=',m_password(m_a_p('password')))->count()==0)
								{
									echo m_alert('Hata','Geçersiz kullanıcı bilgileri.');
								}
								else
								{	
									$login_id = $db->table('md_control')->where('email','=',m_a_p('email'))->where('password','=',m_password(m_a_p('password')))->get_var('id');
									$data = [
									'last_login' => $db->now(),
									'last_ip' => m_ip()
									];
									$query = $db->table('md_control')->where('id','=',$login_id)->update($data);
									m_set_session('m_admin',$login_id);
									m_redirect(MADMIN_URL);
												
												
								}
							}
							?>
							<div class="form-group form-group-feedback form-group-feedback-left">
								<input type="text" class="form-control" name="email" placeholder="Email Adresi" required>
								<div class="form-control-feedback">
									<i class="icon-user text-muted"></i>
								</div>
							</div>

							<div class="form-group form-group-feedback form-group-feedback-left">
								<input type="password" name="password" class="form-control" placeholder="Şifre" required>
								<div class="form-control-feedback">
									<i class="icon-lock2 text-muted"></i>
								</div>
							</div>

							<div class="form-group">
								<button type="submit" class="btn btn-primary btn-block">Giriş <i class="icon-circle-right2 ml-2"></i></button>
							</div>

						</div>
					</div>
				</form>
			

			</div>
	

		</div>
	

	</div>


</body>

</html>
