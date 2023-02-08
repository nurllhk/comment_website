<?php if(!defined('ADMIN_INCLUDED')) { exit; } ?>

<?php

	$informations = $db->table('rejected_types')->where('id','=',m_a_g('id'))->get();
MADMIN_URL
	if($informations['total_count']=='0')

	{

		m_redirect(MADMIN_URL);

	}

	$info = $informations["data"][0];

?>   MADMIN_URL

<div class="content">

<div class="navbar navbar-dark navbar-expand-md navbar-component">

<div class="d-md-none">

</div>

<div class="collapse navbar-collapse" id="navbar-component">

	<ul class="navbar-nav">

		<li class="nav-item">

			<a href="<?php echo MADMIN_URL;?>/index.php?page=rejected_types" class="navbar-nav-link">Red Nedenleri</a>

		</li>

		<li class="nav-item">

			<a href="#" class="navbar-nav-link"><i class="fa fa-share"></i></a>

		</li>

		<li class="nav-item">

			<a href="#" class="navbar-nav-link">Red Nedeni</a>

		</li>

	</ul>



</div>

</div>

<div class="card">

<div class="card-header bg-dark text-white header-elements-inline">

<h5 class="card-title">Red Nedeni Düzenle</h5>

</div>



<div class="card-body">

<?php

if($_POST)

{

	$data = [

	'copy' => m_a_p('copy'),

	'title' => m_a_p('title'),

	'content' => m_a_p('content'),

	'icon' => m_a_p('icon'),

	'rt_rank' => m_a_p('rt_rank')

	];

	

	$query = $db->table('rejected_types')->where('id','=',m_a_g('id'))->update($data);

	

	if($query)

	{

		echo m_alert('Başarılı','İşleminiz başarıyla gerçekleştirildi.');

	}

	else

	{

		echo m_alert('Hata','İşlem gerçekleştirilirken bir hata oluştu.');

	}

	

	$informations = $db->table('rejected_types')->where('id','=',m_a_g('id'))->get();

	$info = $informations["data"][0];

}

?>

<form action="" method="post">

	<div class="form-group row">

		<label class="col-lg-3 col-form-label">Kopya İçin Kullanım ( Sadece 1 Neden Kopya İçin Kullanılır ):</label>

		<div class="col-lg-9">

			<div class="form-check form-check-inline">

				<label class="form-check-label">

					<input type="radio" class="form-input-styled" name="copy" value="1" <?php if($info['copy']==1) { echo 'checked'; } ?> data-fouc>

					Evet

				</label>

			</div>



			<div class="form-check form-check-inline">

				<label class="form-check-label">

					<input type="radio" class="form-input-styled" name="copy" value="0" <?php if($info['copy']==0) { echo 'checked'; } ?> data-fouc>

					Hayır

				</label>

			</div>

		</div>

	</div>

	<div class="form-group row">

		<label class="col-lg-3 col-form-label">İkon:</label>

		<div class="col-lg-9">

			<div class="form-check form-check-inline">

				<label class="form-check-label">

					<input type="radio" class="form-input-styled" name="icon" value="fa fa-clone" <?php if($info['icon']=='fa fa-clone') { echo 'checked'; } ?> checked data-fouc>

					<i class="fa fa-clone"></i>

				</label>

			</div>

			<div class="form-check form-check-inline">

				<label class="form-check-label">

					<input type="radio" class="form-input-styled" name="icon" value="fa fa-images" <?php if($info['icon']=='fa fa-images') { echo 'checked'; } ?> data-fouc>

					<i class="fa fa-images"></i>

				</label>

			</div>

			<div class="form-check form-check-inline">

				<label class="form-check-label">

					<input type="radio" class="form-input-styled" name="icon" value="fa fa-photo-video" <?php if($info['icon']=='fa fa-photo-video') { echo 'checked'; } ?> data-fouc>

					<i class="fa fa-photo-video"></i>

				</label>

			</div>

			<div class="form-check form-check-inline">

				<label class="form-check-label">

					<input type="radio" class="form-input-styled" name="icon" value="fa fa-image" <?php if($info['icon']=='fa fa-image') { echo 'checked'; } ?> data-fouc>

					<i class="fa fa-image"></i>

				</label>

			</div>

			<div class="form-check form-check-inline">

				<label class="form-check-label">

					<input type="radio" class="form-input-styled" name="icon" value="fa fa-keyboard" <?php if($info['icon']=='fa fa-keyboard') { echo 'checked'; } ?> data-fouc>

					<i class="fa fa-keyboard"></i>

				</label>

			</div>

			<div class="form-check form-check-inline">

				<label class="form-check-label">

					<input type="radio" class="form-input-styled" name="icon" value="fa fa-text-width" <?php if($info['icon']=='fa fa-text-width') { echo 'checked'; } ?> data-fouc>

					<i class="fa fa-text-width"></i>

				</label>

			</div>

			<div class="form-check form-check-inline">

				<label class="form-check-label">

					<input type="radio" class="form-input-styled" name="icon" value="fa fa-remove-format" <?php if($info['icon']=='fa fa-remove-format') { echo 'checked'; } ?> data-fouc>

					<i class="fa fa-remove-format"></i>

				</label>

			</div>

			<div class="form-check form-check-inline">

				<label class="form-check-label">

					<input type="radio" class="form-input-styled" name="icon" value="fa fa-exclamation-circle" <?php if($info['icon']=='fa fa-exclamation-circle') { echo 'checked'; } ?> data-fouc>

					<i class="fa fa-exclamation-circle"></i></i>

				</label>

			</div>

			<div class="form-check form-check-inline">

				<label class="form-check-label">

					<input type="radio" class="form-input-styled" name="icon" value="fa fa-window-maximize" <?php if($info['icon']=='fa fa-window-maximize') { echo 'checked'; } ?> data-fouc>

					<i class="fa fa-window-maximize"></i></i>

				</label>

			</div>

		</div>

	</div>

	<div class="form-group row">

		<label class="col-lg-3 col-form-label">Kısa İsim:</label>

		<div class="col-lg-9">

			<input type="text" class="form-control" name="title" value="<?php echo $info['title']; ?>" required>

		</div>

	</div>

	<div class="form-group row">

		<label class="col-lg-3 col-form-label">Görünüm Sırası:</label>

		<div class="col-lg-9">

			<input type="number" class="form-control" name="rt_rank" value="<?php echo $info['rt_rank']; ?>" required>

		</div>

	</div>

	<div class="form-group row">

		<label class="col-lg-3 col-form-label">Açıklama:</label>

		<div class="col-lg-9">

			<textarea name="content" class="summernote"><?php echo $info['content']; ?></textarea>

		</div>

	</div>





	<div>

		<button type="submit" class="btn btn-primary">Kaydet <i class="icon-paperplane ml-2"></i></button>

	</div>

</form>

</div>

</div>

</div>

