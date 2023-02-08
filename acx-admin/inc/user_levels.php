<?php if(!defined('ADMIN_INCLUDED')) { exit; } ?>
<div class="content">

<div class="card">
	<div class="card-header header-elements-sm-inline">
		<h6 class="card-title">Kullanıcı Seviyeleri</h6>
	</div>

	<table class="table datatable-button-html5-basic">
	<thead>
		<tr>
			<th>Seviye Adı</th>
			<th>Gereken Puan</th>
			<th>Ekleme Kazanç</th>
			<th>Gösterim Kazanç</th>
			<th class="text-right">İşlemler</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$informations = $db->table('user_levels')->order('id','asc')->get();
	if($informations['total_count']>0)
	{
		foreach($informations['data'] as $info)
		{
			echo '
			<tr>
				<td>'.$info['title'].'</td>
				<td>'.$info['need_level'].'</td>
				<td>'.m_currency($info['fee_per_review']).'</td>
				<td>'.m_currency($info['view_amount']).'</td>
				<td class="text-right">
				
				<a href="'.ADMIN_URL.'/index.php?page=user_level&id='.$info['id'].'"><span class="btn bg-info-400"><b><i class="icon-pencil"></i></b></span></a>

				</td>
			</tr>';
		}
	}
	?>
	</tbody>
	</table>

</div>

</div>

