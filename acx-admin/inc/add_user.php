<?php if(!defined('ADMIN_INCLUDED')) { exit; } ?>
<div class="content">
<div class="navbar navbar-dark navbar-expand-md navbar-component">
<div class="d-md-none">
</div>
<div class="collapse navbar-collapse" id="navbar-component">
	<ul class="navbar-nav">
		<li class="nav-item">
			<a href="<?php echo ADMIN_URL;?>/index.php?page=users" class="navbar-nav-link">Kullanıcılar</a>
		</li>
		<li class="nav-item">
			<a href="#" class="navbar-nav-link"><i class="fa fa-share"></i></a>
		</li>
		<li class="nav-item">
			<a href="#" class="navbar-nav-link">Kullanıcı</a>
		</li>
	</ul>

</div>
</div>
<div class="card">
<div class="card-header bg-dark text-white header-elements-inline">
<h5 class="card-title">Kullanıcı Ekle</h5>
</div>

<div class="card-body">
<?php
if($_POST)
{
		
			if(m_u_p('username')=='' or m_u_p('password')=='' or m_u_p('email')=='' or m_u_p('gender')=='')
			{
				
				echo m_alert('Hata','Lütfen tüm alanları doldurun.');
			}
			else
			{
				if(preg_match('/^[a-zA-Z0-9_.-ğüşıöçĞÜŞİÖÇ]*$/',m_u_p('username')) and preg_match('#([a-zA-ZğüşıöçĞÜŞİÖÇ])#si',m_u_p('username')) and mb_strlen(m_u_p('username'))<=14 and mb_strlen(m_u_p('username'))>=6)
				{
					if($db->table('users')->where('username','=',m_u_p('username'))->where('username_wait','=',m_u_p('username'))->count()==0)
					{
						if($db->table('users')->where('email','=',m_u_p('email'))->count()==0)
						{
								if($_FILES['avatar']['name']=='')
								{
										$avatar = '';
										$upload_error = '';
								}
								else
								{
										$upload	=	m_image_uploader('avatar','user_'.m_sef(m_a_p('username')).'_'.uniqid().'',true,true);
										
										if(!$upload[0]=='')
										{
											$avatar = $upload[0];
										}
										else
										{
											$upload_error = 1;
											$avatar = '';
										}
								}
								if(m_u_p('gender')=='Erkek')
								{
									$gender = 'Erkek';
								}
								else
								{
									$gender = 'Kadın';
								}
								$hash  = md5(uniqid());
								$data = [
								'referer_key' => uniqid(),
								'avatar' => $avatar,
								'username' => m_u_p('username'),
								'phone' => m_u_p('phone'),
								'email' => m_u_p('email'),
								'gender' => $gender,
								'password' => m_password(m_u_p('password')),
								'sef' => m_username_sef(m_u_p('username')),
								'register_date' => $db->now(),
								'register_ip' => m_ip(),
								'last_login' => $db->now(),
								'last_ip' => m_ip(),
								'status' => 1
								
								];
								$query = $db->table('users')->insert($data);
							
								if($query)
								{
									echo m_alert('Başarılı','Üyelik başarıyla oluşturuldu.');
								}
								else
								{
									
									echo m_alert('Hata','Üyelik oluşturulurken bir hata oluştu.');
								}
							
						}
						else
						{
							
							echo m_alert('Hata','Email adresi kullanılıyor. Lütfen tekrar deneyiniz.');
						}
					}
					else
					{
							
							echo m_alert('Hata','Kullanıcı adı kullanılıyor. Lütfen tekrar deneyiniz.');
					}
				}
				else
				{
					
					echo m_alert('Hata','Lütfen kullanıcı adınızda yalnızca harfleri (a-z), rakamları ve -_ işaretini kullanın. Kullanıcı adınız 6 ile 14 karakter arasında olmalı ve en az 1 harf olmalıdır.');
				}
			}
	
}
?>
<form action="" method="post" enctype="multipart/form-data">
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Kullanıcı Adı</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="username" required value="<?php echo m_a_p('username'); ?>">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Kullanıcı Avatar:</label>
		<div class="col-lg-9">
			<input type="file" class="form-control" name="avatar">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Cinsiyet:</label>
		<div class="col-lg-9">
			<select class="form-control" name="gender">
			<option value="Erkek">Erkek</option>
			<option value="Kadın">Kadın</option>
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Email</label>
		<div class="col-lg-9">
			<input type="email" class="form-control" name="email" required value="<?php echo m_a_p('email'); ?>">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Telefon</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="phone" value="<?php echo m_a_p('phone'); ?>">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Şifre</label>
		<div class="col-lg-9">
			<input type="password" class="form-control" name="password" required value="<?php echo m_a_p('password'); ?>">
		</div>
	</div>

	<div>
		<button type="submit" class="btn btn-primary">Ekle <i class="icon-paperplane ml-2"></i></button>
	</div>
</form>

</div>
</div>
</div>
