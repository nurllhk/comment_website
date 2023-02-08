<?php
	m_header();
	$captcha = new captcha();
	$captcha->captcha_generate(5);
?>   
<div class="main">
	<div class="container">
		<div class="row">

		
		<div class="col-xl-12 col-lg-12 col-sm-12">
		<div class="page_head">
		<div class="page_icon"><i class="fa fa-user-plus"></i></div>
		<div class="page_title"><h1>Kayıt Ol</h1></div>
		</div>
		
		<?php echo m_ads('720_300'); ?>
		
		<div class="login_page">
		<div class="row">
		
		<div class="col-xl-6 col-lg-6 col-sm-12 col-12">
		
		<div class="card">
		  <div class="card-body">
				<div class="social_login">
					<h2>Hızlı Kayıt Ol</h2>
					<div class="social_login_sites">
					<a href="<?php echo m_permalink('auth','google'); ?>"><span class="btn-group"><span class="btn btn-secondary"><i class="fab fa-google"></i></span><span class="btn btn-secondary">Google</span></span></a>
					<a href="<?php echo m_permalink('auth','facebook'); ?>"><span class="btn-group"><span class="btn btn-primary"><i class="fab fa-facebook"></i></span><span class="btn btn-primary">Facebook</span></span></a>
					</div>
					<h2>Email ile Kayıt Ol</h2>
				</div>
				<form class="register_form">
				<div class="register_result"></div>
				  <div class="mb-3">
					<label class="form-label">Kullanıcı Adı</label>
					<input type="text" class="form-control" name="username">
				  </div>
				  <div class="mb-3">
					<label class="form-label">Email Adresiniz</label>
					<input type="email" class="form-control" name="email">
				  </div>
				  <div class="mb-3">
					<label class="form-label">Telefon Numaranız</label>
					<input type="number" class="form-control" name="phone">
				  </div>
				  <div class="mb-3">
					<label class="form-label">Cinsiyet</label>
					<select class="form-select" name="gender">
							<option value="Erkek">Erkek</option>
							<option value="Kadın">Kadın</option>
					</select>
				  </div>
				  <div class="mb-3">
					<label class="form-label">Şifreniz</label>
					<input type="password" class="form-control" name="password">
				  </div>
				   <div class="mb-3">
					<label class="form-label">Referans Kodu</label>
					<?php
							if(m_u_g('referer')=='')
							{
							   $detect_referer = '';
							}
							else
							{
							   $referer_user_count = $db->table('users')->where('referer_key','=',m_u_g('referer'))->count();
							   if($referer_user_count>0)
							   {
								   $detect_referer = m_u_g('referer');
							   }
							   else
							   {
								   $detect_referer = '';
							   }
							   m_set_session('referer',$detect_referer);
							}
					?>
					<input type="text" class="form-control" name="referer" value="<?php echo $detect_referer; ?>" placeholder="Yoksa boş bırakınız...">
				  </div>
				  <div class="mb-3 text-center">
					<img src="<?php echo UPLOAD_URL.'/1x1.gif'; ?>"  class="lazyload captcha" width="280" height="60" data-src="<?php echo m_permalink('captcha'); ?>" alt="Güvenlik Doğrulaması">
				  </div>
				  <div class="mb-3">
					<label class="form-label">Güvenlik Doğrulaması</label>
					<input type="text" class="form-control" name="captcha" placeholder="Resimde gördüğünüz karakterleri yazınız.">
				  </div>
				  <div class="form-check">
					  <input class="form-check-input" type="checkbox" name="user agreement" value="1" id="flexCheckDefault">
					  <label class="form-check-label" for="flexCheckDefault">
						<a href="<?php echo m_permalink('page','kullanici-sozlesmesi'); ?>" target="_blank" title="Kullanıcı Sözleşmesini">Kullanıcı Sözleşmesini</a>, <a href="<?php echo m_permalink('page','ortaklik-programi'); ?>" target="_blank" title="Ortaklık Programı Kuralları">Ortaklık Programı Kurallarını</a> ve <a href="<?php echo m_permalink('page','gizlilik-politikasi'); ?>" target="_blank" title="Gizlilik Politikasını">Gizlilik Politikasını</a> kabul ediyorum.
					  </label>
				  </div>
				  <button type="submit" class="btn btn-default btn-sm w-100 mb-3"><i class="fa fa-check-square"></i> Kayıt Ol</button>
				</form>
		  </div>
		</div>
		
		
		</div>
		
		<div class="col-xl-6 col-lg-6 col-sm-6 col-12 mobile_hide">
		
		<div class="login_background">
			<img src="<?php echo UPLOAD_URL.'/1x1.gif'; ?>" class="lazyload" data-src="<?php echo SITE_THEME_URL; ?>/assets/img/login_register.webp" alt="Kayıt Ol">
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
					