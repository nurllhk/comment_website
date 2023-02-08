<?php if(!defined('ADMIN_INCLUDED')) { exit; } ?>
<div class="content">

<div class="card">

	<div class="card-header header-elements-sm-inline">
		<h6 class="card-title">Meta Tag Ayarları</h6>
	</div>
	<div class="text-right" style="margin-right:10px;">
		<a href="<?php echo ADMIN_URL; ?>/index.php?page=meta_add"><span class="btn bg-success-400 btn-labeled btn-labeled-left"><b><i class="icon-add"></i></b> Meta Tag Ekle</span></a>
	</div>

	<table class="table datatable-button-html5-basic">
	<thead>
		<tr>
			<th>Meta Adı</th>
			<th>Sayfa</th>
			<th class="text-right">İşlemler</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$informations = $db->table('meta_tags')->order('id','asc')->get();
	if($informations['total_count']>0)
	{
		foreach($informations['data'] as $info)
		{
			echo '
			<tr>
				<td>'.$info['title'].'</td>
				<td>'.$info['page_sef'].'</td>
				<td class="text-right">
				
				<a href="'.ADMIN_URL.'/index.php?page=meta&id='.$info['id'].'"><span class="btn bg-info-400"><b><i class="icon-pencil"></i></b></span></a>
				<a class="delete" href="'.ADMIN_URL.'/index.php?page=delete&table=meta_tags&id='.$info['id'].'"><span class="btn bg-danger-400"><b><i class="icon-trash"></i></b> </span></a>

				</td>
			</tr>';
		}
	}
	?>
	</tbody>
	</table>
	
</div>

</div>

