<?php if(!defined('ADMIN_INCLUDED')) { exit; } ?>
<?php
	$informations = $db->table('brands')->where('id','=',m_a_g('id'))->get();
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
			<a href="<?php echo ADMIN_URL;?>/index.php?page=brands" class="navbar-nav-link">Markalar</a>
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
<h5 class="card-title">Marka Düzenle</h5>
</div>

<div class="card-body">
<?php
if($_POST)
{
	if($_FILES['image']['name']=="")
	{
		$image = $info['image'];
	}
	else
	{
		
		$upload=m_image_uploader('image','brand_'.m_sef(m_a_p('title')).'_'.uniqid().'',true);
		$image=$upload[0];
	}
	$data = [
	'title' => m_a_p('title'),
	'seo_content' => m_a_p('seo_content'),
	'image' => $image,
	'sef' => m_sef(m_a_p('title')),
	'status' => m_a_p('status')
	];
	
	$query = $db->table('brands')->where('id','=',m_a_g('id'))->update($data);
	
	if($query)
	{
		if($upload[0]!='')
		{
			unlink(UPLOAD_DIR.'/images/'.$info['image']);
		}
		echo m_alert('Başarılı','İşleminiz başarıyla gerçekleştirildi.');
	}
	else
	{
		if($upload[0]!='')
		{
			unlink(UPLOAD_DIR.'/images/'.$upload[0]);
		}
		echo m_alert('Hata','İşlem gerçekleştirilirken bir hata oluştu.');
	}
	
	$informations = $db->table('brands')->where('id','=',m_a_g('id'))->get();
	$info = $informations["data"][0];
}
?>
<form action="" method="post" enctype="multipart/form-data">
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
		<label class="col-lg-3 col-form-label">Marka Resmi:</label>
		<div class="col-lg-9">
			<a href="<?php echo m_image_url($info['image']); ?>" data-popup="lightbox"><img src="<?php echo m_image_url($info['image']); ?>" class="img-thumbnail" style="width:100px;height:100px"></a>
			<br>
			<br>
			<input type="file" class="form-control" name="image">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Marka Adı:</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="title" value="<?php echo $info['title']; ?>" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Seo İçeriği:</label>
		<div class="col-lg-9">
			<textarea name="seo_content" class="summernote"><?php echo $info['seo_content']; ?></textarea>
		</div>
	</div>


	<div>
		<button type="submit" class="btn btn-primary">Kaydet <i class="icon-paperplane ml-2"></i></button>
	</div>
</form>
</div>
</div>
</div>
