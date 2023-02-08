<?php if(!defined('ADMIN_INCLUDED')) { exit; } ?>
<?php
	$informations =  $db->table('moderators')->where('id','=',m_moderator('id'))->get();
	if($informations['total_count']=='0')
	{
		m_redirect(MODERATOR_URL);
	}
	$info = $informations['data'][0];

?>   

<div class="content">
<div class="navbar navbar-dark navbar-expand-md navbar-component">
<div class="d-md-none">
</div>
<div class="collapse navbar-collapse" id="navbar-component">
	<ul class="navbar-nav">
		<li class="nav-item">
			<a href="<?php echo MODERATOR_URL;?>/index.php" class="navbar-nav-link">Anasayfa</a>
		</li>
		<li class="nav-item">
			<a href="#" class="navbar-nav-link"><i class="fa fa-share"></i></a>
		</li>
		<li class="nav-item">
			<a href="#" class="navbar-nav-link">Hesap Bilgilerim</a>
		</li>
	</ul>

</div>
</div>
<div class="card">
<div class="card-header bg-dark text-white header-elements-inline">
<h5 class="card-title">Yetkili Bilgileri</h5>
</div>

<div class="card-body">
<?php
if($_POST)
{
	if(m_a_p('password')=='')
	{
		$password = $bilgi['password'];
	}
	else
	{
		$password = m_password(m_a_p('password'));
	}
	
	$data = [
	'name' => m_a_p('name'),
	'lastname' => m_a_p('lastname'),
	'email' => m_a_p('email'),
	'password' => $password
	
	];
	
	$query = $db->table('admins')->where('id','=',m_moderator('id'))->update($data);
	
	if($query)
	{
		echo m_alert('Başarılı','İşleminiz başarıyla gerçekleştirildi.');
	}
	else
	{
		echo m_alert('Hata','İşlem gerçekleştirilirken bir hata oluştu.');
	}
	
	$informations =  $db->table('admins')->where('id','=',m_moderator('id'))->get();
	$info = $informations['data'][0];

}
?>
<form action="#" method="post">
		<div class="form-group row">
		<label class="col-lg-3 col-form-label">İsim:</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="name" value="<?php echo $info['name']; ?>" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Soyisim:</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="lastname" value="<?php echo $info['lastname']; ?>" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Email:</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="email" value="<?php echo $info['email']; ?>" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Şifre:</label>
		<div class="col-lg-9">
			<input type="password" class="form-control" name="password" value="" required>
		</div>
	</div>
	<div>
		<button type="submit" class="btn btn-primary">Kaydet <i class="icon-paperplane ml-2"></i></button>
	</div>
</form>
</div>
</div>
</div>
