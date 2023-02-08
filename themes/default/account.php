<?php
	m_header();
?>   
<div class="main">
	<div class="container">
		<div class="row">

		
		<div class="col-xl-12 col-lg-12 col-sm-12">
		<div class="page_head">
		<div class="page_icon"><i class="fa fa-cog"></i></div>
		<div class="page_title"><h1>Hesap Ayarları</h1></div>
		</div>
		<div class="row">
		
		<div class="col-xl-4 col-lg-4 col-sm-4 col-12">
			
			<?php require_once('account_part.php'); ?>
		
		</div>
		
		<div class="col-xl-8 col-lg-8 col-sm-8 col-12">
		
			<div class="card">
			<div class="card-body">
				  <?php
				  if($_POST)
				  {
					  
					  if($_FILES['avatar']['name']=='')
					  {
							$avatar = USER['avatar'];
							$upload_error = '';
					  }
					  else
					  {
							$upload	=	m_image_uploader('avatar','user_'.m_sef(USER['username']).'_'.uniqid(),true,true,100,100);
							
							if($upload[0]!='')
							{
								$avatar = $upload[0];
							}
							else
							{
								$upload_error = 1;
								$avatar = USER['avatar'];
							}
					  }
					  if(m_u_p('password')=='')
					  {
						  $password = USER['password'];
					  }
					  else
					  {
						  $password = m_password(m_u_p('password'));
					  }
						if(m_u_p('gender')=='Erkek')
						{
							$gender = 'Erkek';
						}
						else
						{
							$gender = 'Kadın';
						}
					  $data = [
								'avatar' => $avatar,
								'phone' => m_u_p('phone'),
								'gender' => $gender,
								'email' => m_u_p('email'),
								'password' => $password
								
					  ];
					  
					  $query = $db->table('users')->where('id','=',USER['id'])->update($data);
					  
					 if($upload_error!='')
					 {
						 echo  m_alert('Hata',"Yüklemeye çalıştığınız Profil fotoğrafı 2 MB' dan daha büyük veya JPEG formatında değil. Lütfen tekrar yüklemeyi deneyiniz.");
					 }
					 
					  
					  
					  echo  m_alert('Başarılı','Hesap bilgileriniz başarıyla değiştirildi.');
				  }
				  ?>
				  <div><img class="lazyload user_setting_image" width="460" height="453" data-src="<?php echo m_user_avatar(m_user('gender'),m_user('avatar'),true); ?>"></div>
				 <form method="post" action="" enctype="multipart/form-data">
				 <div class="mb-3">
					<label class="form-label">Profil Fotoğrafı</label>
					<input class="form-control w-100" name="avatar" type="file">
				</div>
				  <div class="mb-3">
					<label class="form-label">Kullanıcı Adı</label>
					<input type="text" class="form-control" name="username" value="<?php echo m_user('username'); ?>" disabled>
				  </div>
				  <div class="mb-3">
					<label class="form-label">Email Adresiniz</label>
					<input type="email" class="form-control" name="email" value="<?php echo m_user('email'); ?>">
				  </div>
				  <div class="mb-3">
					<label class="form-label">Telefon Numaranız</label>
					<input type="number" class="form-control" name="phone" value="<?php echo m_user('phone'); ?>">
				  </div>
				  <div class="mb-3">
					<label class="form-label">Cinsiyet</label>
					<select class="form-select" name="gender">
							<option value="Erkek" <?php if(m_user('gender')=='Erkek') { echo 'selected="selected"'; } ?>>Erkek</option>
							<option value="Kadın" <?php if(m_user('gender')=='Kadın') { echo 'selected="selected"'; } ?>>Kadın</option>
					</select>
				  </div>
				  <div class="mb-3">
					<label class="form-label">Şifreniz</label>
					<input type="password" class="form-control" name="password" placeholder="Değiştirmek istemiyorsanız boş bırakın.">
				  </div>
				  <button type="submit" class="btn btn-default w-100 mb-3"><i class="fa fa-check-square"></i> Hesap Bilgilerini Güncelle</button>
				  </form>
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
					