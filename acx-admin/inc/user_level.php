<?php if(!defined('ADMIN_INCLUDED')) { exit; } ?>
<?php
	$informations = $db->table('user_levels')->where('id','=',m_a_g('id'))->get();
	if($informations['total_count']=='0')
	{
		m_redirect(ADMIN_URL);
	}
	$info = $informations["data"][0];
?>   
<div class="content">
<div class="navbar navbar-dark navbar-expand-md navbar-component">
<div class="d-md-none">
</div>
<div class="collapse navbar-collapse" id="navbar-component">
	<ul class="navbar-nav">
		<li class="nav-item">
			<a href="<?php echo ADMIN_URL;?>/index.php?page=user_levels" class="navbar-nav-link">Kullanıcı Seviyeleri</a>
		</li>
		<li class="nav-item">
			<a href="#" class="navbar-nav-link"><i class="fa fa-share"></i></a>
		</li>
		<li class="nav-item">
			<a href="#" class="navbar-nav-link">Sayfa</a>
		</li>
	</ul>

</div>
</div>
<div class="card">
<div class="card-header bg-dark text-white header-elements-inline">
<h5 class="card-title">Sayfa Düzenle</h5>
</div>

<div class="card-body">
<?php
if($_POST)
{
	$data = [
	'title' => m_a_p('title'),
	'need_level' => m_a_p('need_level'),
	'level_color' => m_a_p('level_color'),
	'level_icon' => m_a_p('level_icon'),
	'fee_per_review' => m_a_p('fee_per_review'),
	'view_amount' => m_a_p('view_amount')
	];
	
	$query = $db->table('user_levels')->where('id','=',m_a_g('id'))->update($data);
	
	if($query)
	{
		echo m_alert('Başarılı','İşleminiz başarıyla gerçekleştirildi.');
	}
	else
	{
		echo m_alert('Hata','İşlem gerçekleştirilirken bir hata oluştu.');
	}
	
	$informations = $db->table('user_levels')->where('id','=',m_a_g('id'))->get();
	$info = $informations["data"][0];
}
?>
<form action="" method="post">
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Seviye Adı:</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="title" value="<?php echo $info['title']; ?>" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Seviye Gereken Puan:</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="need_level" value="<?php echo $info['need_level']; ?>" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Seviye Renk:</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="level_color" value="<?php echo $info['level_color']; ?>" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Seviye Icon:</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="level_icon" value="<?php echo $info['level_icon']; ?>" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Para Kazanmaya Açılan Her İnceleme İçin Ücret:</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="fee_per_review" value="<?php echo $info['fee_per_review']; ?>" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Görüntülenme Başı Kazanç:</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="view_amount" value="<?php echo $info['view_amount']; ?>" required>
		</div>
	</div>
	


	<div>
		<button type="submit" class="btn btn-primary">Kaydet <i class="icon-paperplane ml-2"></i></button>
	</div>
</form>
</div>
</div>
</div>
