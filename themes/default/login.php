<?php
	m_header();
?>  
<div class="main">
	<div class="container">
		<div class="row">

		
		<div class="col-xl-12 col-lg-12 col-sm-12 col-12">
		<div class="page_head">
		<div class="page_icon"><i class="fa fa-sign-in-alt"></i></div>
		<div class="page_title"><h1>Giriş Yap</h1></div>
		</div>
		
		<?php echo m_ads('720_300'); ?>
		
		<div class="login_page">
		<div class="row">
		
		<div class="col-xl-6 col-lg-6 col-sm-12">
		
		<div class="card">
		  <div class="card-body">
				<div class="social_login">
					<h2>Hızlı Giriş</h2>
					<div class="social_login_sites">
					<a href="<?php echo m_permalink('auth','google'); ?>"><span class="btn-group"><span class="btn btn-secondary"><i class="fab fa-google"></i></span><span class="btn btn-secondary">Google</span></span></a>
					<a href="<?php echo m_permalink('auth','facebook'); ?>"><span class="btn-group"><span class="btn btn-primary"><i class="fab fa-facebook"></i></span><span class="btn btn-primary">Facebook</span></span></a>
					</div>
					<h2>Email ile Giriş</h2>
				</div>
				<form class="login_form">
				<div class="login_result"></div>
				  <div class="mb-3">
					<label class="form-label">Email Adresiniz</label>
					<input type="email" class="form-control" name="email">
				  </div>
				  <div class="mb-3">
					<label class="form-label">Şifreniz</label>
					<input type="password" class="form-control" name="password">
				  </div>
				  <button type="submit" class="btn btn-default w-100 mb-3"><i class="fa fa-sign-in-alt"></i> Giriş Yap</button>
				  <a href="<?php echo m_permalink('register'); ?>" title="Kayıt Ol"><span class="btn btn-primary"><i class="fa fa-user-plus"></i> Kayıt Ol</span></a>
				  <a href="<?php echo m_permalink('forgot_password'); ?>" title="Şifremi Unuttum"><span class="btn btn-dark"><i class="fa fa-unlock"></i> Şifremi Unuttum</span></a>
				</form>
		  </div>
		</div>
		
		
		</div>
		
		<div class="col-xl-6 col-lg-6 col-sm-6 col-12 mobile_hide">
		
		<div class="login_background">
			<img src="<?php echo UPLOAD_URL.'/1x1.gif'; ?>" class="lazyload" width="460" height="453" data-src="<?php echo SITE_THEME_URL; ?>/assets/img/login_register.webp" alt="Giriş Yap">
		</div>
		
		</div>
		
		
		
		</div>
		</div>
		</div>
		
		
		
		</div>
	</div>
</div>
<?php
	m_footer();
?>