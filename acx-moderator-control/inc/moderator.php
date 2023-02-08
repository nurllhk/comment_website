<?php if(!defined('ADMIN_INCLUDED')) { exit; } ?>

<?php

	$informations = $db->table('moderators')->where('id','=',m_a_g('id'))->get();

	if($informations['total_count']=='0')
	{

		m_redirect(MADMIN_URL);

	}

	$info = $informations["data"][0];

?>MADMIN_URL

<div class="content">

<div class="navbar navbar-dark navbar-expand-md navbar-component">

<div class="d-md-none">

</div>

<div class="collapse navbar-collapse" id="navbar-component">

	<ul class="navbar-nav">

		<li class="nav-item">

			<a href="<?php echo MADMIN_URL;?>/index.php?page=moderators" class="navbar-nav-link">Moderatörler</a>

		</li>

		<li class="nav-item">

			<a href="#" class="navbar-nav-link"><i class="fa fa-share"></i></a>

		</li>

		<li class="nav-item">

			<a href="#" class="navbar-nav-link">Moderatör</a>

		</li>

	</ul>



</div>

</div>

<div class="card">

<div class="card-header bg-dark text-white header-elements-inline">

<h5 class="card-title">Moderatör Düzenle</h5>

</div>



<div class="card-body">

<?php

if($_POST)

{

	

	if(m_a_p('password')=='')

	{

		$password = $info['password'];

	}

	else

	{

		$password = m_password(m_a_p('password'));

	}

	

	$data = [

	'username' => m_a_p('username'),

	'name' => m_a_p('name'),

	'lastname' => m_a_p('lastname'),

	'email' => m_a_p('email'),

	'password' => $password

	

	];

	

	$query = $db->table('moderators')->where('id','=',$info['id'])->update($data);

	

	if($query)

	{

		echo m_alert('Başarılı','İşleminiz başarıyla gerçekleştirildi.');

	}

	else

	{

		echo m_alert('Hata','İşlem gerçekleştirilirken bir hata oluştu.');

	}

}

?>

<form action="" method="post" enctype="multipart/form-data">

	<div class="form-group row">

		<label class="col-lg-3 col-form-label">Durum:</label>

		<div class="col-lg-9">

			<div class="form-check form-check-inline">

				<label class="form-check-label">

					<input type="radio" class="form-input-styled" name="status" value="1" checked data-fouc>

					Aktif

				</label>

			</div>



			<div class="form-check form-check-inline">

				<label class="form-check-label">

					<input type="radio" class="form-input-styled" name="status" value="0" data-fouc>

					Pasif

				</label>

			</div>

		</div>

	</div>

	<div class="form-group row">

		<label class="col-lg-3 col-form-label">Kullanıcı Adı:</label>

		<div class="col-lg-9">

			<input type="text" class="form-control" name="username" value="<?php echo $info['username']; ?>" required>

		</div>

	</div>

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

			<input type="password" class="form-control" name="password">

		</div>

	</div>

	<div>

		<button type="submit" class="btn btn-primary">Kaydet <i class="icon-paperplane ml-2"></i></button>

	</div>

</form>

</div>

</div>

</div>

