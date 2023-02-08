<?php
	m_header();
?>  
<div class="main">
	<div class="container">
		<div class="row">

		
		<div class="col-xl-12 col-lg-12 col-sm-12 col-12">
		<div class="page_head">
		<div class="page_icon"><i class="fa fa-unlock"></i></div>
		<div class="page_title"><h1>Şifremi Unuttum</h1></div>
		</div>
		<div class="mt-3">
		<div class="row">
		
		<div class="col-xl-6 col-lg-6 col-sm-12">
		
		<div class="card">
		  <div class="card-body">
				 <?php
					if($_POST)
					{
					$informations = $db->table('users')->where('email','=',m_u_p('email'))->get();
					$info = $informations['data'][0];
					
					$name = $info['username'];
					if($informations['total_count']=='1' and $info['status']=='1')
					{
							$hash = md5(time().'-'.$info['id'].'-'.$info['email']);
							$link = SITE_DOMAIN.'/sifre-yenileme/'.$hash;
							email_send($info['email'],'Şifre Yenileme',email_rp($name,$link));
							$data = [
							'password_hash' => $hash
							];
							$query = $db->table('users')->where('id','=',$info['id'])->update($data);
					$state='ok';
					$result= m_alert('Başarılı','Lütfen email adresinize gönderilen maili kontrol ediniz. Eğer email görünmüyorsa lütfen Junk/Spam klasörünü kontrol ediniz.');
					}
					else
					{
					$result= m_alert('Hata','Geçersiz kullanıcı adı veya email adresi girdiniz. Lütfen tekrar deneyiniz.');
					}
					
					
					
					}

			?>
			<?php
			if($state=='ok')
			{
			echo $result;
			}
			else
			{
				echo $result;
			?>
          <form method="post" action="">
                <div class="mb-3">
                  <label class="form-label">Kayıtlı Email Adresiniz</label>
                  <input class="form-control" required="required" name="email" type="email">
                </div>
            <button type="submit" class="btn btn-default btn-sm"><i class="fa fa-check-square"></i> Şifre Sıfırlama Bağlantısını Gönder</button>
          </form>
		  <?php
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