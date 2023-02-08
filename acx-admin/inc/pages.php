<?php if(!defined('ADMIN_INCLUDED')) { exit; } ?>
<div class="content">

<div class="card">
	<div class="card-header header-elements-sm-inline">
		<h6 class="card-title">Sayfalar</h6>
	</div>

	<table class="table datatable-button-html5-basic">
	<thead>
		<tr>
			<th>Sayfa Adı</th>
			<th>Durum</th>
			<th class="text-right">İşlemler</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$informations = $db->table('pages')->order('id','desc')->get();
	if($informations['total_count']>0)
	{
		foreach($informations['data'] as $info)
		{
			echo '
			<tr>
				<td>'.$info['title'].'</td>
				<td>'.m_status($info['status']).'</td>
				<td class="text-right">
				
				<a href="'.ADMIN_URL.'/index.php?page=page&id='.$info['id'].'"><span class="btn bg-info-400"><b><i class="icon-pencil"></i></b></span></a>

				</td>
			</tr>';
		}
	}
	?>
	</tbody>
	</table>

</div>

</div>

