<?php if(!defined('ADMIN_INCLUDED')) { exit; } ?>
<?php
	$informations = $db->table('users')->where('id','=',m_a_g('id'))->get();
	if($informations['total_count']=='0')
	{
		m_redirect(ADMIN_URL);
	}
	$info = $informations['data'][0];
?>   

<div class="content">
<div class="navbar navbar-dark navbar-expand-md navbar-component">
<div class="d-md-none">
</div>
<div class="collapse navbar-collapse" id="navbar-component">

	<ul class="navbar-nav">
		<li class="nav-item">
			<a href="<?php echo ADMIN_URL;?>/index.php?page=users" class="navbar-nav-link">Kullanıcılar</a>
		</li>
		<li class="nav-item">
			<a href="#" class="navbar-nav-link"><i class="fa fa-share"></i></a>
		</li>
		<li class="nav-item">
			<a href="#" class="navbar-nav-link"><?php echo $info['username']; ?></a>
		</li>

	</ul>



</div>
</div>
<div class="navbar navbar-expand-lg navbar-light bg-light" style="padding-left:0px;">

<div class="text-center d-lg-none w-100">

	<button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-second">

		<i class="icon-menu7 mr-2"></i>

		Kullanıcı Bilgileri

	</button>

</div>
<div class="navbar-collapse collapse" id="navbar-second">
	<ul class="nav navbar-nav">
		<li class="nav-item">
			<a href="#user_information" class="navbar-nav-link active" data-toggle="tab">
				<i class="icon-menu7 mr-2"></i>
				Kullanıcı Bilgileri
			</a>
		</li>
		<li class="nav-item">
			<a href="#user_reviews" class="navbar-nav-link tab_datatable" data-toggle="tab">
				<i class="icon-pencil7 mr-2"></i>
				İncelemeler
				<span class="badge badge-pill bg-success position-static ml-auto ml-lg-2"><?php echo m_number_format($db->table('reviews')->where('u_id','=',$info['id'])->count()); ?></span>
			</a>
		</li>
		<li class="nav-item">
			<a href="#user_comments" class="navbar-nav-link tab_datatable" data-toggle="tab">
				<i class="icon-comment-discussion mr-2"></i>
				Yorumlar
				<span class="badge badge-pill bg-success position-static ml-auto ml-lg-2"><?php echo m_number_format($db->table('comments')->where('u_id','=',$info['id'])->count()); ?></span>
			</a>
		</li>
		<li class="nav-item">
			<a href="#user_referers" class="navbar-nav-link tab_datatable" data-toggle="tab">
				<i class="icon-user-plus mr-2"></i>
				Referanslar
				<span class="badge badge-pill bg-success position-static ml-auto ml-lg-2"><?php echo m_number_format($db->table('users')->where('referer','=',$info['id'])->count()); ?></span>
			</a>
		</li>
		<li class="nav-item">
			<a href="#user_balances" class="navbar-nav-link tab_datatable" data-toggle="tab">
				<i class="icon-equalizer2 mr-2"></i>
				Bakiye Geçmişi
				<span class="badge badge-pill bg-success position-static ml-auto ml-lg-2"><?php echo m_number_format($db->table('user_balances')->where('u_id','=',$info['id'])->count()); ?></span>
			</a>
		</li>
		<li class="nav-item">
			<a href="#user_withdrawals" class="navbar-nav-link tab_datatable" data-toggle="tab">
				<i class="icon-database mr-2"></i>
				Para Çekimleri
				<span class="badge badge-pill bg-success position-static ml-auto ml-lg-2"><?php echo m_number_format($db->table('withdrawals')->where('u_id','=',$info['id'])->count()); ?></span>
			</a>
		</li>

	</ul>

</div>

</div>

<div class="row">
<div class="col-xl-12">

<div class="tab-content w-100 order-2 order-md-1">

<div id="user_information" class="tab-pane fade active show">
<div class="card">
<div class="card-header  header-elements-inline">
<h5 class="card-title">Kullanıcı Bilgileri</h5>
</div>
<div class="card-body">

<?php
if($_POST)
{
		if($_FILES['avatar']['name']=='')
		{
				$avatar = $info['avatar'];
				$upload_error = '';
		}
		else
		{
				$upload	=	m_user_image_upload('avatar','user_'.m_sef(m_u_p('username')).'_'.uniqid(),true,true);
				
				if($upload['status']=='ok')
				{
					$avatar = $upload['file'];
				}
				else
				{
					$upload_error = 1;
					$avatar = $info['avatar'];
				}
		}
		if(m_a_p('password')=='')
		{
			  $password = $info['password'];
		}
		else
		{
			  $password = m_password(m_a_p('password'));
		}
		if(m_a_p('username')==$info['username'])
		{
			$user_sef = $info['sef'];
		}
		else
		{
			$user_sef = m_username_sef(m_a_p('username'));
		}
		if(m_a_p('ban')==0)
		{
			$banned_msg = '';
			$ban_finish_time = '';
		}
		else
		{
			$banned_msg = m_a_p('banned_msg');
			$ban_finish_time = m_a_p('ban_finish_time');
		}
		$data = [
		'username' => m_a_p('username'),
		'phone' => m_a_p('phone'),
		'email' => m_a_p('email'),
		'gender' => m_a_p('gender'),
		'balance' => m_a_p('balance'),
		'user_level' => m_a_p('user_level'),
		'banned_msg' => $banned_msg,
		'ban_finish_time' => $ban_finish_time,
		'sef' => $user_sef,
		'password' => $password,
		'avatar' => $avatar,
		'editor' => m_a_p('editor'),
		'status' => m_a_p('status')
		
		];
		
		$query = $db->table('users')->where('id','=',m_a_g('id'))->update($data);
		
		if($query)
		{
			if($upload['file']!='')
			{
				unlink(UPLOAD_DIR.'/images/'.$info['avatar']);
				unlink(UPLOAD_THUMB_DIR.'/'.$info['avatar']);
			}
			echo m_alert('Başarılı','İşleminiz başarıyla gerçekleştirildi.');
		}
		else
		{
			if($upload[0]!='')
			{
				unlink(UPLOAD_DIR.'/images/'.$upload['file']);
				unlink(UPLOAD_THUMB_DIR.'/'.$upload['avatar']);
			}
			echo m_alert('Hata','İşlem gerçekleştirilirken bir hata oluştu.');
		}
		if($upload_error!='')
		{
			 echo  m_alert('Hata',"Yüklemeye çalıştığınız Profil fotoğrafı 2 MB' dan daha büyük veya JPEG formatında değil. Lütfen tekrar yüklemeyi deneyiniz.");
		}
		
		$informations = $db->table('users')->where('id','=',m_a_g('id'))->get();
		$info = $informations['data'][0];
	
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
		<label class="col-lg-3 col-form-label">Editör:</label>
		<div class="col-lg-9">
			<div class="form-check form-check-inline">
				<label class="form-check-label">
					<input type="radio" class="form-input-styled" name="editor" value="1" <?php if($info['editor']==1) { echo 'checked'; } ?> data-fouc>
					Aktif
				</label>
			</div>

			<div class="form-check form-check-inline">
				<label class="form-check-label">
					<input type="radio" class="form-input-styled" name="editor" value="0" <?php if($info['editor']==0) { echo 'checked'; } ?> data-fouc>
					Pasif
				</label>
			</div>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Ban:</label>
		<div class="col-lg-9">
			<div class="form-check form-check-inline">
				<label class="form-check-label">
					<input type="radio" class="form-input-styled ban_change" name="ban" value="1" <?php if($info['banned_msg']!='') { echo 'checked'; $ban_show=''; } ?> data-fouc>
					Evet
				</label>
			</div>

			<div class="form-check form-check-inline">
				<label class="form-check-label">
					<input type="radio" class="form-input-styled ban_change" name="ban" value="0" <?php if($info['banned_msg']=='') { echo 'checked'; $ban_show='display:none;'; } ?> data-fouc>
					Hayır
				</label>
			</div>
		</div>
	</div>
	<div class="ban_information" style="<?php echo $ban_show; ?>">
		<div class="form-group row">
			<label class="col-lg-3 col-form-label">Banlanma Nedeni</label>
			<div class="col-lg-9">
				<input type="text" class="form-control" name="banned_msg" value="<?php echo $info['banned_msg']; ?>">
			</div>
		</div>
		<div class="form-group row">
			<label class="col-lg-3 col-form-label">Ban Bitiş Tarihi</label>
			<div class="col-lg-9">
				<input type="text" class="form-control ban_finish_time" name="ban_finish_time" value="<?php echo $info['ban_finish_time']; ?>">
			</div>
		</div>
		<div class="form-group row">
		<label class="col-lg-3 col-form-label">Bitiş Tarihi Seçin:</label>
		<div class="col-lg-9">
			<select class="form-control ban_date">
			<option value="">Lütfen bitiş tarihi seçiniz</option>
			<option value="0">Sınırsız</option>
			<option value="30">30 Dk</option>
			<option value="60">1 Saat</option>
			<option value="120">2 Saat</option>
			<option value="180">3 Saat</option>
			<option value="240">4 Saat</option>
			<option value="1140">1 Gün</option>
			<option value="2280">2 Gün</option>
			<option value="3420">3 Gün</option>
			<option value="4560">4 Gün</option>
			<option value="10080">1 Hafta</option>
			<option value="14400">10 Gün</option>
			<option value="20160">2 Hafta</option>
			</select>
		</div>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Kayıt Tarihi</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" value="<?php echo m_date_to_tr($info['register_date']); ?>" disabled>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Referer Key</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" value="<?php echo $info['referer_key']; ?>" disabled>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Kayıt IP</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" value="<?php echo $info['register_ip']; ?>" disabled>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Son Giriş</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" value="<?php echo m_date_to_tr($info['last_login']); ?>" disabled>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Son Ip Adresi</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" value="<?php echo $info['last_ip']; ?>" disabled>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Kullanıcı Bakiyesi</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="balance" value="<?php echo $info['balance']; ?>" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Kullanıcı Seviye Puanı</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="user_level" value="<?php echo $info['user_level']; ?>" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Kullanıcı Adı</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="username" value="<?php echo $info['username']; ?>" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Kullanıcı Avatar:</label>
		<div class="col-lg-9">
			<img src="<?php echo m_user_avatar($info['gender'],$info['avatar'],true); ?>" class="img-thumbnail" style="width:100px;height:100px">
			<br>
			<br>
			<input type="file" class="form-control" name="avatar">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Cinsiyet:</label>
		<div class="col-lg-9">
			<select class="form-control" name="gender">
			<option value="Erkek" <?php if($info['gender']=='Erkek') { echo 'selected="selected"'; } ?>>Erkek</option>
			<option value="Kadın" <?php if($info['gender']=='Kadın') { echo 'selected="selected"'; } ?>>Kadın</option>
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Email</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="email" value="<?php echo $info['email']; ?>" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Telefon</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="phone" value="<?php echo $info['phone']; ?>">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Şifre</label>
		<div class="col-lg-9">
			<input type="password" class="form-control" name="password" value="">
		</div>
	</div>

	<div>
		<button type="submit" class="btn btn-primary">Kaydet <i class="icon-paperplane ml-2"></i></button>
	</div>
</form>




</div>
</div>
</div>


<div id="user_reviews" class="tab-pane fade">
<div class="card">
	<div class="card-header header-elements-sm-inline">
		<h6 class="card-title">Kullanıcı İncelemeleri</h6>
	</div>

	<table class="table datatable-button-html5-basic">
	<thead>
		<tr>
			<th>Başlık</th>
			<th>Görüntülenme</th>
			<th>Durum</th>
			<th>Tarih</th>
			<th class="text-right">İşlemler</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$user_reviews = $db->table('reviews')->where('u_id','=',$info['id'])->order('id','desc')->get();
	if($user_reviews['total_count']>0)
	{
		foreach($user_reviews['data'] as $review)
		{
			echo '
			<tr>
				<td>'.$review['title'].'</td>
				<td>'.m_number_format($review['views']).'</td>
				<td>'.m_review_status($review['status']).'</td>
				<td>'.m_date_to_tr($review['date']).'</td>
				<td class="text-right">
				
				<a href="'.ADMIN_URL.'/index.php?page=review_detail&id='.$review['id'].'" target="_blank"><span class="btn bg-info-400"><b><i class="icon-eye"></i></b></span></a>
				</td>
			</tr>';
		}
	}
	?>
	</tbody>
	</table>

</div>
</div>

<div id="user_comments" class="tab-pane fade">
<div class="card">
	<div class="card-header header-elements-sm-inline">
		<h6 class="card-title">Kullanıcı Yorumları</h6>
	</div>

	<table class="table datatable-button-html5-basic">
	<thead>
		<tr>
			<th>Tarih</th>
			<th>Durum</th>
			<th class="text-right">İşlemler</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$user_comments = $db->table('comments')->where('u_id','=',$info['id'])->order('id','desc')->get();
	if($user_comments['total_count']>0)
	{
		foreach($user_comments['data'] as $comment)
		{
			echo '
			<tr>
				<td>'.m_date_to_tr($comment['date']).'</td>
				<td>'.m_comment_status($comment['status']).'</td>
				<td class="text-right">
				
				<a href="'.ADMIN_URL.'/index.php?page=comment_detail&id='.$comment['id'].'" target="_blank"><span class="btn bg-info-400"><b><i class="icon-eye"></i></b></span></a>
				</td>
			</tr>';
		}
	}
	?>
	</tbody>
	</table>

</div>
</div>

<div id="user_referers" class="tab-pane fade">
<div class="card">
	<div class="card-header header-elements-sm-inline">
		<h6 class="card-title">Kullanıcı Referansları</h6>
	</div>

	<table class="table datatable-button-html5-basic">
	<thead>
		<tr>
			<th>Kullanıcı</th>
			<th>Kayıt IP</th>
			<th>Kayıt Tarihi</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$user_referers = $db->table('users')->where('referer','=',$info['id'])->where('status','=','1')->order('id','desc')->get();
	if($user_referers['total_count']>0)
	{
		foreach($user_referers['data'] as $referer)
		{
			echo '
			<tr>
				<td>'.$referer['username'].'</td>
				<td>'.$referer['register_ip'].'</td>
				<td>'.m_date_to_tr($referer['register_date']).'</td>
			</tr>';
		}
	}
	?>
	</tbody>
	</table>

</div>
</div>

<div id="user_balances" class="tab-pane fade">

<div class="card mt-2 mb-2">
<div class="card-header bg-primary header-elements-sm-inline">
		<h6 class="card-title">Filtrele</h6>
</div>
<div class="card-body">
<select class="balance_filter form-control select2 mb-2 mt-2">
					<option value="">Bakiye Geçmişini Filtrele</option>
					<option value="İnceleme Ödemesi">İnceleme Ödemesi</option>
					<option value="Haftanın Kategorisi İnceleme Ödemesi">Haftanın Kategorisi İnceleme Ödemesi</option>
					<option value="İnceleme Görüntülenme">İnceleme Görüntülenme</option>
					<option value="Sitede Kalma Kazancı">Sitede Kalma Kazancı</option>
					<option value="Referans Para Çekimi">Referans Para Çekimi</option>
					<option value="Para Çekimi">Para Çekimi</option>
</select>
</div>
</div>

<div class="card">
	<div class="card-header header-elements-sm-inline">
		<h6 class="card-title">Kullanıcı Bakiye Geçmişi</h6>
	</div>
	
	<table id="balance_table" class="table datatable-column-search-selects datatable-button-html5-basic">
	<thead>
		<tr>
		
			<th>Tarih</th>
			<th>İşlem</th>
			<th>İşlem ID</th>
			<th>Tutar</th>
			<th>Önceki Bakiye</th>
			<th>Son Bakiye</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$user_balances = $db->table('user_balances')->where('u_id','=',$info['id'])->order('id','desc')->limit(5000)->get();
	if($user_balances['total_count']>0)
	{
		foreach($user_balances['data'] as $balance)
		{
			echo '
			<tr>
				<td>'.m_date_to_tr($balance['date']).'</td>
				<td>'.$balance['description'].'</td>
				<td>'.$balance['data_id'].'</td>
				<td>'.m_currency($balance['amount']).' <i class="fa fa-lira-sign"></i></td>
				<td>'.m_currency($balance['before_balance']).' <i class="fa fa-lira-sign"></i></td>
				<td>'.m_currency($balance['last_balance']).' <i class="fa fa-lira-sign"></i></td>
			</tr>';
		}
	}
	?>
	</tbody>
	</table>

</div>
</div>


<div id="user_withdrawals" class="tab-pane fade">
<div class="card">
	<div class="card-header header-elements-sm-inline">
		<h6 class="card-title">Kullanıcı Para Çekimleri</h6>
	</div>

	<table class="table datatable-button-html5-basic">
	<thead>
		<tr>
		
			<th>Tarih</th>
			<th>Tutar</th>
			<th>Durum</th>
			<th class="text-right">İşlemler</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$user_withdrawals = $db->table('withdrawals')->where('u_id','=',$info['id'])->order('id','desc')->get();
	if($user_withdrawals['total_count']>0)
	{
		foreach($user_withdrawals['data'] as $withdraw)
		{
			echo '
			<tr>
			
				<td>'.m_date_to_tr($withdraw['date']).'</td>
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

</div>
</div>
</div>
</div>



	