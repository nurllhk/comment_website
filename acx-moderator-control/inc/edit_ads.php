<?php if(!defined('ADMIN_INCLUDED')) { exit; } ?>
<?php
	$informations = $db->table('ads')->where('id','=',m_a_g('id'))->get();
	if($informations['total_count']=="0")
	{
		m_redirect(MADMIN_URL);
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
			<a href="<?php echo MADMIN_URL;?>/index.php?page=ads" class="navbar-nav-link">Reklamlar</a>
		</li>
		<li class="nav-item">
			<a href="#" class="navbar-nav-link"><i class="fa fa-mail-forward"></i></a>
		</li>
		<li class="nav-item">
			<a href="#" class="navbar-nav-link">Reklam</a>
		</li>
	</ul>

</div>
</div>


<div class="row">
<div class="col-xl-12">


<form action="" method="post" enctype="multipart/form-data">
<div class="card">
<div class="card-header bg-dark text-white header-elements-inline">
<h5 class="card-title">Reklam Düzenle</h5>
</div>

<div class="card-body">
<?php
if($_POST)
{
	
	$data = [
	'title' => m_a_p('title'),
	's_code' => m_a_p('s_code'),
	'desktop_code' => m_a_p('desktop_code'),
	'mobile_code' => m_a_p('mobile_code'),
	'status' => m_a_p('status')
	];
	$query = $db->table('ads')->where('id','=',m_a_g('id'))->update($data);
	if($query)
	{
		echo m_alert('Başarılı','İşleminiz başarıyla gerçekleştirildi.');
	}
	else
	{
		
		echo m_alert('Hata','İşlem gerçekleştirilirken bir hata oluştu.');
	}
	$informations = $db->table('ads')->where('id','=',m_a_g('id'))->get();
	$info = $informations['data'][0];
}
?>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Durum:</label>
		<div class="col-lg-9">
			<div class="form-check form-check-inline">
				<label class="form-check-label">
					<input type="radio" class="form-input-styled" name="status" value="1" <?php if($info['status']==1) { echo 'checked'; } ?> data-fouc>
					Aktif
				</label>
			</div>

			<div class="form-check form-check-inline">
				<label class="form-check-label">
					<input type="radio" class="form-input-styled" name="status" value="0" <?php if($info['status']==0) { echo 'checked'; } ?> data-fouc>
					Pasif
				</label>
			</div>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Tanım:</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="title" value="<?php echo $info["title"]; ?>">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Kısa Kod:</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="s_code" value="<?php echo $info["s_code"]; ?>">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Masaüstü Reklam Kodu:</label>
		<div class="col-lg-9">
			<textarea class="form-control" name="desktop_code" style="width:100%;height:100px;"><?php echo $info["desktop_code"]; ?></textarea>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Mobil Reklam Kodu:</label>
		<div class="col-lg-9">
			<textarea class="form-control" name="mobile_code" style="width:100%;height:100px;"><?php echo $info["mobile_code"]; ?></textarea>
		</div>
	</div>


	<div>
		<button type="submit" class="btn btn-primary">Kaydet <i class="icon-paperplane ml-2"></i></button>
	</div>
</form>



</div>


</div>
</div>

</div>
</div>

	