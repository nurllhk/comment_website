<?php if(!defined('ADMIN_INCLUDED')) { exit; } ?>
<?php
	$informations = $db->table('withdrawals')->where('id','=',m_a_g('id'))->get();
	if($informations['total_count']=='0')
	{
		m_redirect(ADMIN_URL);
	}
	$info = $informations['data'][0];
	$referer = m_user('referer',$info['u_id']);
?>   
<div class="content">
<div class="navbar navbar-dark navbar-expand-md navbar-component">
<div class="d-md-none">
</div>
<div class="collapse navbar-collapse" id="navbar-component">
	<ul class="navbar-nav">
		<li class="nav-item">
			<a href="<?php echo ADMIN_URL;?>/index.php?page=withdrawals&status=0" class="navbar-nav-link">Para Çekimleri</a>
		</li>
		<li class="nav-item">
			<a href="#" class="navbar-nav-link"><i class="fa fa-share"></i></a>
		</li>
		<li class="nav-item">
			<a href="#" class="navbar-nav-link">Para Çekimi</a>
		</li>
	</ul>

</div>
</div>
<div class="card">
<div class="card-header bg-dark text-white header-elements-inline">
<h5 class="card-title">Para Çekimi Detayları</h5>
</div>
<div class="card-body">
<?php
if($_POST)
{
	if(m_a_p('status')==2 and $info['status']==0)
	{
		
		user_balances_add(true,$info['u_id'],$info['amount'],'withdraw_reject',$info['id'],'Para Çekimi İptali');
		m_user_notification_push('rejected_withdraw',$info['u_id']);	
	}
	if(m_a_p('status')==1 and $info['status']==0)
	{
		
		m_user_notification_push('approved_withdraw',$info['u_id']);	
		
	}
	if(m_a_p('status')==1 and $info['status']==0 and $referer!=0)
	{
		
		user_balances_add(true,$referer,str_replace(',','.',m_currency(m_percent($info['amount'],m_setting('referer_withdraw_amount')))),'referer_withdraw_amount',$info['id'],'Referans Para Çekimi');
		
	}
	$data = [
			'status' => m_a_p('status'),
			'admin_note' => m_a_p('admin_note')
			
			];
	$query = $db->table('withdrawals')->where('id','=',m_a_g('id'))->update($data);
	if($query)
	{
		echo m_alert('Başarılı','İşleminiz başarıyla gerçekleştirildi.');
	}
	else
	{
		echo m_alert('Hata','İşlem gerçekleştirilirken bir hata oluştu.');
	}
	$informations = $db->table('withdrawals')->where('id','=',m_a_g('id'))->get();
	$info = $informations['data'][0];
}
?>
<form action="" method="post" enctype="multipart/form-data">
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Tarih</label>
		<div class="col-lg-9">
			<?php echo m_date_to_tr($info['date']); ?>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Kullanıcı</label>
		<div class="col-lg-9">
			<a href="<?php echo ADMIN_URL; ?>/index.php?page=user&id=<?php echo $info['u_id']; ?>" target="_blank"><?php echo m_user('username',$info['u_id']); ?></a>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Tutar</label>
		<div class="col-lg-9">
			<?php echo $info['amount']; ?> <i class="fa fa-lira-sign"></i>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Banka Alıcı</label>
		<div class="col-lg-9">
			<?php echo $info['bank_buyer']; ?>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Banka IBAN</label>
		<div class="col-lg-9">
			<?php echo $info['bank_iban']; ?>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Alıcı Telefon Numarası</label>
		<div class="col-lg-9">
			<?php echo $info['buyer_phone']; ?>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Alıcı TC Kimlik Numarası</label>
		<div class="col-lg-9">
			<?php echo $info['buyer_identity_number']; ?>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Alıcı Doğum Yılı</label>
		<div class="col-lg-9">
			<?php echo $info['buyer_birth_year']; ?>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Yönetici Notu</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="admin_note" value="<?php echo $info['admin_note']; ?>">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Durum</label>
		<div class="col-lg-9">
			<select name="status" class="select2">
			<?php
			$withdraw_status[0]['id'] = '0';
			$withdraw_status[0]['name'] = 'Onay Bekliyor';
			
			$withdraw_status[1]['id'] = '1';
			$withdraw_status[1]['name'] = 'Onaylandı';
			
			$withdraw_status[2]['id'] = '2';
			$withdraw_status[2]['name'] = 'Reddedildi';
			foreach($withdraw_status as $status)
			{
				if($info['status']==$status['id'])
				{
				$selected=' selected="selected"';
				}
				else
				{
				$selected='';
				}
				echo '<option value="'.$status['id'].'" '.$selected.'>'.$status['name'].'</option>';
			}
			?>
			</select>
		</div>
	</div>
	<div>
		<button type="submit" class="btn btn-primary">Kaydet <i class="icon-paperplane ml-2"></i></button>
	</div>
</form>
</div>
</div>

<div class="card">
	<div class="card-header header-elements-sm-inline">
		<h6 class="card-title">Kullanıcının Diğer Para Çekimleri</h6>
	</div>

	<table class="table datatable-button-html5-basic">
	<thead>
		<tr>
		
			<th>Tarih</th>
			<th>Alıcı Adı</th>
			<th>Alıcı TC</th>
			<th>Tutar</th>
			<th>Durum</th>
			<th class="text-right">İşlemler</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$user_withdrawals = $db->table('withdrawals')->where('u_id','=',$info['u_id'])->where('id','!=',$info['id'])->order('id','desc')->get();
	if($user_withdrawals['total_count']>0)
	{
		foreach($user_withdrawals['data'] as $withdraw)
		{
			echo '
			<tr>
			
				<td>'.m_date_to_tr($withdraw['date']).'</td>
				<td>'.$withdraw['bank_buyer'].'</td>
				<td>'.$withdraw['buyer_identity_number'].'</td>
				<td>'.m_currency($withdraw['amount']).' <i class="fa fa-lira-sign"></i></td>
				<td>'.m_withdraw_status($withdraw['status']).'</td>
				<td class="text-right">
				
				<a href="'.ADMIN_URL.'/index.php?page=withdraw_detail&id='.$withdraw['id'].'" target="_blank"><span class="btn bg-info-400"><b><i class="icon-eye"></i></b></span></a>
				</td>
			</tr>';
		}
	}
	?>
	</tbody>
	</table>

</div>



</div>
