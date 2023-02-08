<?php if(!defined('ADMIN_INCLUDED')) { exit; } ?>
<div class="content">

<?php
if($_POST)
{
	$n=0;
	foreach($_POST['id'] as $id)
	{
		$info = $db->table('brands')->where('id','=',$id)->get_vars();
		unlink(UPLOAD_DIR.'/images/'.basename($info['image']));
		unlink(UPLOAD_THUMB_DIR.'/'.basename($info['image']));
		$db->table('brands')->where('id','=',$id)->delete();
		$n++;
	}
	echo m_alert('Başarılı',''.$n.' Öğe başarıyla silindi.!');
}
?>


<div class="card">
		<div class="card-header header-elements-sm-inline">
			<h6 class="card-title">Resimsiz Markalar</h6>
			<div class="text-right" style="margin-right:10px;">
			<a href="<?php echo ADMIN_URL; ?>/index.php?page=brand_add"><span class="btn bg-success-400 btn-labeled btn-labeled-left"><b><i class="icon-add"></i></b> Marka Ekle</span></a>
			</div>
		</div>
		<div class="card-body">
		<input type="text" class="form-control ajax_table_search" placeholder="Aramak için yazınız.">
		</div>
		<form action="method" method="post">
		<div style="margin-left:20px">
		<div class="form-group form-check" style="float:left;margin-right:5px;padding-left:0px;">
			<span class="btn btn-sm btn-primary check_all"><i class="fa fa-check"></i> Tablodakileri Seç</span>
		</div>
		<div style="display:inline-block:margin-left:5px">
		<button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Seçilenleri Sil</button>
		</div>
		</div>
		
		<div class="ajax_table" rel="no_image_brands">
		<div class="ajax_table_loading"><i class="fa fa-spinner fa-spin fa-5x"></i></div>
		<div class="ajax_table_content">
		
		</div>
		</div>
		</form>
		
</div>

</div>



