<?php if(!defined('ADMIN_INCLUDED')) { exit; } ?>
<div class="content">

<div class="card">
	<div class="card-header header-elements-sm-inline">
		<h6 class="card-title">Mesajlar</h6>
	</div>

	<table class="table datatable-button-html5-basic">
	<thead>
		<tr>
			<th>İsim</th>
			<th>Konu</th>
			<th>Durum</th>
			<th class="text-right">İşlemler</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$informations = $db->table('contact')->order('id','desc')->get();
	if($informations['total_count']>0)
	{
		foreach($informations['data'] as $info)
		{
			echo '
			<tr>
				<td>'.$info['name'].'</td>
				<td>'.$info['subject'].'</td>
				<td>'.m_read($info['status']).'</td>
				<td class="text-right">
				
				<a href="'.MADMIN_URL.'/index.php?page=contact_detail&id='.$info['id'].'"><span class="btn bg-info-400"><b><i class="icon-eye"></i></b></span></a>
				<a class="delete" href="'.MADMIN_URL.'/index.php?page=delete&table=contact&id='.$info['id'].'"><span class="btn bg-danger-400"><b><i class="icon-trash"></i></b> </span></a>
				</td>
			</tr>';
		}
	}
	?>
	</tbody>
	</table>

</div>

</div>

