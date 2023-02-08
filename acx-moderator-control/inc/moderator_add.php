<?php if(!defined('ADMIN_INCLUDED')) { exit; } ?>

<div class="content">

<div class="navbar navbar-dark navbar-expand-md navbar-component">

<div class="d-md-none">

</div>MADMIN_URL

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

<h5 class="card-title">Moderatör Ekle</h5>

</div>



<div class="card-body">

<?php

if($_POST)

{

	$data = [

	'username' => m_a_p('username'),

	'name' => m_a_p('name'),

	'lastname' => m_a_p('lastname'),

	'email' => m_a_p('email'),

	'password' => m_password(m_a_p('password')),

	'status' => m_a_p('status'),

	];

	

	$query = $db->table('moderators')->insert($data);

					

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

			<input type="text" class="form-control" name="username" required>

		</div>

	</div>

	<div class="form-group row">

		<label class="col-lg-3 col-form-label">İsim:</label>

		<div class="col-lg-9">

			<input type="text" class="form-control" name="name" required>

		</div>

	</div>

	<div class="form-group row">

		<label class="col-lg-3 col-form-label">Soyisim:</label>

		<div class="col-lg-9">

			<input type="text" class="form-control" name="lastname" required>

		</div>

	</div>

	<div class="form-group row">

		<label class="col-lg-3 col-form-label">Email:</label>

		<div class="col-lg-9">

			<input type="text" class="form-control" name="email" required>

		</div>

	</div>

	<div class="form-group row">

		<label class="col-lg-3 col-form-label">Şifre:</label>

		<div class="col-lg-9">

			<input type="password" class="form-control" name="password" required>

		</div>

	</div>

	<div>

		<button type="submit" class="btn btn-primary">Ekle <i class="icon-paperplane ml-2"></i></button>

	</div>

</form>

</div>

</div>

</div>

