<?php if(!defined('ADMIN_INCLUDED')) { exit; } ?>
<?php
if(m_a_g('status')==0)
{
	$title = 'Onay Bekleyen Para Çekimleri';
}
if(m_a_g('status')==1)
{
	$title = 'Onaylanmış Para Çekimleri';
}
if(m_a_g('status')==2)
{
	$title = 'Reddedilmiş Para Çekimleri';
}

?>
<div class="content">

<div class="card">
	<div class="card-header header-elements-sm-inline">
		<h6 class="card-title"><?php echo $title; ?></h6>
	</div>

	<table class="table datatable-button-html5-basic">
	<thead>
		<tr>
			<th>Kullanıcı</th>
			<th>Tutar</th>
			<th>Tarih</th>
			<th>Durum</th>
			<th class="text-right">İşlemler</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$informations = $db->table('withdrawals')->where('status','=',m_a_g('status'))->order('id','desc')->get();
	if($informations['total_count']>0)
	{
		foreach($informations['data'] as $info)
		{
			echo '
			<tr>
				<td>'.m_user('username',$info['u_id']).'</td>
				<td>'.m_currency($info['amount']).' <i class="fa fa-lira-sign"></i></td>
				<td>'.m_date_to_tr($info['date']).'</td>
				<td>'.m_withdraw_status($info['status']).'</td>
				<td class="text-right">
				
				<a href="'.MADMIN_URL.'/index.php?page=withdraw_detail&id='.$info['id'].'"><span class="btn bg-info-400"><b><i class="icon-eye"></i></b></span></a>
				<a class="delete" href="'.MADMIN_URL.'/index.php?page=delete&table=withdrawals&id='.$info['id'].'"><span class="btn bg-danger-400"><b><i class="icon-trash"></i></b> </span></a>
				</td>
			</tr>';
		}
	}
	?>
	</tbody>
	</table>

</div>

</div>

