<?php
	m_header();
?>  
<div class="main">
	<div class="container">
		<div class="row">
		<div class="col-xl-12 col-lg-12 col-sm-12 col-12">
		<div class="page_head">
		<div class="page_icon"><i class="fa fa-question-circle"></i></div>
		<div class="page_title"><h1>Yeni Şifre Belirleme</h1></div>
		</div>
		<div class="mt-3">
		<div class="row">
		
		<div class="col-xl-6 col-lg-6 col-sm-12">
		
		<div class="card">
		  <div class="card-body">
				  <?php
						$state='no';
						if($_POST)
						{
							$informations = $db->table('users')->where('password_hash','=',m_u_g('hash'))->get();
							$info = $informations['data'][0];
							if($informations['total_count']>0 and m_u_p('password')!='' and m_u_p('password_again')!='')
							{
									$state='ok';
									$data = [
									'password_hash' => '',
									'password' => m_password(m_u_p('password'))
									];
									$query = $db->table('users')->where('id','=',$info['id'])->update($data);
									echo m_alert('Başarılı','Şifreniz başarıyla değiştirilmiştir.');
							}
							else
							{
									$state='no';
									echo m_alert('Hata','Lütfen girdiğiniz şifreleri kontrol ediniz');
							}
						
						
						
						
					
						}


				$informations = $db->table('users')->where('password_hash','=',m_u_g('hash'))->get();

				if($informations['total_count']>0 and $state!='ok')
				{
				?>
				  <form method="post" action="">
						<div class="mb-3">
						  <label class="form-label">Yeni Şifreniz</label>
						  <input type="password" class="form-control" name="password" required>
						</div>
						<div class="mb-3">
						  <label class="form-label">Yeni Şifrenizi Tekrar Yazın</label>
						  <input type="password" class="form-control" name="password_again" required>
						</div>
					<button type="submit" class="btn btn-default btn-sm"><i class="fa fa-check-square"></i> Şifremi Güncelle</button>
				  </form>
				  <?php
				}
				else
				{
					if($state!='ok')
					{
					echo m_alert('Hata','Bu şifre yenileme linki geçersizdir.');
					}
				}
				?>
		  </div>
		</div>
		
		
		</div>
		
		<div class="col-xl-6 col-lg-6 col-sm-6 col-12 mobile_hide">
		
		<div class="login_background">
			<img class="lazyload" width="460" height="453" data-src="<?php echo SITE_THEME_URL; ?>/assets/img/login_register.webp">
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