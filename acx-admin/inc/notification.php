<?php if(!defined('ADMIN_INCLUDED')) { exit; } ?>
<div class="content">
<div class="navbar navbar-dark navbar-expand-md navbar-component">
<div class="d-md-none">
</div>
<div class="collapse navbar-collapse" id="navbar-component">
	<ul class="navbar-nav">
		<li class="nav-item">
			<a href="<?php echo ADMIN_URL;?>/index.php" class="navbar-nav-link">Anasayfa</a>
		</li>
		<li class="nav-item">
			<a href="#" class="navbar-nav-link"><i class="fa fa-share"></i></a>
		</li>
		<li class="nav-item">
			<a href="#" class="navbar-nav-link">Bildirimler</a>
		</li>
	</ul>

</div>
</div>
<div class="card">
<div class="card-header bg-dark text-white header-elements-inline">
<h5 class="card-title">Bildirim Gönder</h5>
</div>

<div class="card-body">
<?php
if($_POST)
{
	if(m_a_p('user')==0)
	{
		$users = $db->table('users')->where('status','=','1')->order('username','asc')->get();
		foreach($users['data'] as $user)
		{
				$data = [
				'u_id' => $user['id'],
				'type' => 'admin',
				'title' => m_a_p('title'),
				'guid' => m_a_p('guid')
				];
				
				$query = $db->table('user_notifications')->insert($data);
		}
	}
	else
	{
		
		$data = [
		'u_id' => m_a_p('user'),
		'type' => 'admin',
		'title' => m_a_p('title'),
		'guid' => m_a_p('guid')
		];
		
		$query = $db->table('user_notifications')->insert($data);
	
	}
					
	if($query)
	{
		echo m_alert('Başarılı','İşleminiz başarıyla gerçekleştirildi.');
	}
	else
	{
		echo m_alert('Hata','İşlem gerçekleştirilirken bir hata oluştu.');
	}
}
?>
<form action="" method="post">
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Kullanıcı:</label>
		<div class="col-lg-9">
			<select class="form-control select2" name="user">
			<option value="0">Tüm Kullanıcılar</option>
			<?php
			$users = $db->table('users')->where('status','=','1')->order('username','asc')->get();
			foreach($users['data'] as $user)
			{
					echo '<option value="'.$user['id'].'">'.$user['username'].'</option>';
			}
			?>
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Ayrıntı Linki:</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="guid" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Bildirim İçeriği ( Link kullanmayın ):</label>
		<div class="col-lg-9">
			<textarea name="title" class="summernote"></textarea>
		</div>
	</div>
	<div class="alert alert-info"><i class="fa fa-info-circle"></i> Gönderilen bildirimlerin geri dönüşü yoktur, dikkatlice kontrol ediniz.</div>
	<div>
		<button type="submit" class="btn btn-primary">Ekle <i class="icon-paperplane ml-2"></i></button>
	</div>
</form>
</div>
</div>
</div>
