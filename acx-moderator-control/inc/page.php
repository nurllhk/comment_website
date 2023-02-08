<?php if(!defined('ADMIN_INCLUDED')) { exit; } ?>
<?php
	$informations = $db->table('pages')->where('id','=',m_a_g('id'))->get();
	if($informations['total_count']=='0')
	{
		m_redirect(MADMIN_URL);
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
			<a href="<?php echo MADMIN_URL;?>/index.php?page=pages" class="navbar-nav-link">Sayfalar</a>
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
	'content' => m_a_p('content')
	];
	
	$query = $db->table('pages')->where('id','=',m_a_g('id'))->update($data);
	
	if($query)
	{
		echo m_alert('Başarılı','İşleminiz başarıyla gerçekleştirildi.');
	}
	else
	{
		echo m_alert('Hata','İşlem gerçekleştirilirken bir hata oluştu.');
	}
	
	$informations = $db->table('pages')->where('id','=',m_a_g('id'))->get();
	$info = $informations["data"][0];
}
?>
<form action="" method="post">
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Sayfa Adı:</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="title" value="<?php echo $info['title']; ?>" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Sayfa İçeriği:</label>
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
