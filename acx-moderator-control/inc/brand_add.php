<?php if(!defined('ADMIN_INCLUDED')) { exit; } ?>
<div class="content">
<div class="navbar navbar-dark navbar-expand-md navbar-component">
<div class="d-md-none">
</div>
<div class="collapse navbar-collapse" id="navbar-component">
	<ul class="navbar-nav">
		<li class="nav-item">
			<a href="<?php echo MADMIN_URL;?>/index.php?page=brands" class="navbar-nav-link">Markalar</a>
		</li>
		<li class="nav-item">
			<a href="#" class="navbar-nav-link"><i class="fa fa-share"></i></a>
		</li>
		<li class="nav-item">
			<a href="#" class="navbar-nav-link">Marka</a>
		</li>
	</ul>

</div>
</div>
<div class="card">
<div class="card-header bg-dark text-white header-elements-inline">
<h5 class="card-title">Marka Ekle</h5>
</div>

<div class="card-body">
<?php
if($_POST)
{
	if($_FILES['image']['name']=='')
	{
		$image = '';
	}
	else
	{
		$upload=m_image_uploader('image','brand_'.m_sef(m_a_p('title')).'_'.uniqid().'',true);
		$image = $upload[0];
	}
	$data = [
	'title' => m_a_p('title'),
	'image' => $image,
	'seo_content' => m_a_p('seo_content'),
	'sef' => m_sef(m_a_p('title')),
	'status' => 1,
	];
	
	$query = $db->table('brands')->insert($data);
					
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
		<label class="col-lg-3 col-form-label">Marka Resmi:</label>
		<div class="col-lg-9">
			<input type="file" class="form-control" name="image">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Marka Adı:</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="title" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Seo İçeriği:</label>
		<div class="col-lg-9">
			<textarea name="seo_content" class="summernote"><?php echo $info['seo_content']; ?></textarea>
		</div>
	</div>
	<div>
		<button type="submit" class="btn btn-primary">Ekle <i class="icon-paperplane ml-2"></i></button>
	</div>
</form>
</div>
</div>
</div>
