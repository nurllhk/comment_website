<?php if(!defined('ADMIN_INCLUDED')) { exit; } ?>
<div class="content">


<div class="card">
	<div class="card-header header-elements-sm-inline">
		<h6 class="card-title">Reklamlar</h6>
	</div>

	<table class="table datatable-button-html5-basic">
<thead>
	<tr>
		<th>Tanım</th>
		<th>Kısa Kod</th>
		<th>Durum</th>
		<th class="text-right">İşlemler</th>
	</tr>
</thead>
<tbody>
<?php
$informations = $db->table('ads')->order('id','desc')->get();
$no = 0;
foreach($informations["data"] as $info)
{
	echo '
	<tr>
		<td>'.$info['title'].'</td>
		<td>'.$info['s_code'].'</td>
		<td>'.m_status($info['status']).'</td>
		<td class="text-right">
		
		<a href="'.ADMIN_URL.'/index.php?page=edit_ads&id='.$info['id'].'"><span class="btn bg-info-400"><b><i class="icon-pencil"></i></b></span></a>

		</td>
	</tr>';
}
?>
</tbody>
</table>




</div>
</div>



