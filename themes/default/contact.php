<?php
	m_header();
?>  
<div class="main">
	<div class="container">
		<div class="row">
		<div class="col-xl-12 col-lg-12 col-sm-12 col-12">
		<div class="page_head">
		<div class="page_icon"><i class="fa fa-phone-square-alt"></i></div>
		<div class="page_title"><h1>İletişim</h1></div>
		</div>
		<div class="mt-3">
		<div class="row">
		
		<div class="col-xl-6 col-lg-6 col-sm-12">
		
		<div class="card">
		  <div class="card-body">
		  
			<form action="#" method="post">
			
				<?php
			$ok = 0;
			if($_POST)
			{
				if(m_u_p('captcha')==m_get_session('captcha'))
				{
					if(m_u_p('subject')=='' or m_u_p('name')=='' or m_u_p('phone')=='' or m_u_p('email')=='' or m_u_p('msg')=='')
					{
						echo m_alert('Hata','Lütfen tüm alanları doldurun.');
					}
					else
					{
						$data = [
						'name' => m_u_p('name'),
						'subject' => m_u_p('subject'),
						'email' => m_u_p('email'),
						'phone' => m_u_p('phone'),
						'msg' => m_u_p_msg('msg'),
						'ip' => m_ip(),
						'date' => $db->now(),
						'status' => 0
						
						];
						$ok = 1;
						$query = $db->table('contact')->insert($data);
						
						echo m_alert('Başarılı','Mesajınız teşekkür ederiz, yöneticilerimiz en kısa sürede inceleyip dönüş yapacaktır.');
					}
				}
				else
				{
					echo m_alert('Hata','Güvenlik kodunu yanlış girdiniz. Lütfen tekrar deneyiniz.');
				}
				$captcha = new captcha();
				$captcha->captcha_generate(5);
			}
			if($ok==0)
			{
				$captcha = new captcha();
				$captcha->captcha_generate(5);
			?>
			<div class="row">
				<div class="col-sm-6 col-md-6">
					<div class="mb-3">
						<label class="form-label">İsminiz</label>
						<input type="text" class="form-control" name="name" required value="<?php echo m_u_p('name'); ?>">
					</div>
				</div>
				<div class="col-sm-6 col-md-6">
					<div class="mb-3">
						<label class="form-label">Telefon Numaranız</label>
						<input type="text" class="form-control" name="phone" required value="<?php echo m_u_p('phone'); ?>">
					</div>
				</div>
				<div class="col-sm-6 col-md-6">
					<div class="mb-3">
						<label class="form-label">Email Adresiniz</label>
						<input type="email" class="form-control" name="email" required value="<?php echo m_u_p('email'); ?>">
					</div>
				</div>
				<div class="col-sm-6 col-md-6">
					<div class="mb-3">
						<label class="form-label">Konu</label>
						<select class="form-select" name="subject">
						<option value="İstek">İstek</option>
						<option value="Şikayet">Şikayet</option>
						<option value="Hukuki Sorunlar">Hukuki Sorunlar</option>
						<option value="Öneri">Öneri</option>
						<option value="Reklam ve İşbirliği">Reklam ve İşbirliği</option>
						<option value="Diğer">Diğer</option>
						</select>
					</div>
				</div>
				<div class="col-sm-12 col-md-12">
					<div class="mb-3">
						<label class="form-label">Mesajınız</label>
						<textarea class="form-control" name="msg" required style="height:250px"></textarea>
					</div>
				</div>
				<div class="col-sm-12 col-md-12">
					<div class="mb-3">
					<img src="<?php echo UPLOAD_URL.'/1x1.gif'; ?>" class="lazyload captcha" width="280" height="60" data-src="<?php echo m_permalink('captcha'); ?>" alt="Güvenlik Doğrulaması">
					</div>
					<div class="mb-3">
						<label class="form-label">Güvenlik Doğrulaması</label>
						<input type="text" class="form-control" name="captcha" placeholder="Resimde gördüğünüz karakterleri yazınız." required>
					</div>
				</div>
			</div>
			<br>

			<button type="submit" class="btn btn-default btn-sm"><i class="fa fa-check-square"></i> Gönder</button>

			<?php
			}
			?>
			</form>
		  </div>
		</div>
		
		
		</div>
		
		<div class="col-xl-6 col-lg-6 col-sm-6 col-12 mobile_hide">
		
		<div class="login_background">
			<img src="<?php echo UPLOAD_URL.'/1x1.gif'; ?>" class="lazyload" width="460" height="453" data-src="<?php echo SITE_THEME_URL; ?>/assets/img/login_register.webp" alt="İletişim">
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