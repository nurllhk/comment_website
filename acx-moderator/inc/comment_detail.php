<?php if(!defined('ADMIN_INCLUDED')) { exit; } ?>
<?php
	$informations = $db->table('comments')->where('id','=',m_a_g('id'))->get();
	if($informations['total_count']=='0')
	{
		m_redirect(MODERATOR_URL);
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
			<a href="<?php echo MODERATOR_URL;?>/index.php?page=comments&status=0" class="navbar-nav-link">Yorumlar</a>
		</li>
		<li class="nav-item">
			<a href="#" class="navbar-nav-link"><i class="fa fa-share"></i></a>
		</li>
		<li class="nav-item">
			<a href="#" class="navbar-nav-link">Yorumlar</a>
		</li>
	</ul>

</div>
</div>
<div class="card">
<div class="card-header bg-dark text-white header-elements-inline">
<h5 class="card-title">Yorum Düzenle</h5>
</div>

<div class="card-body">
<?php
if($_POST)
{


		$data = [
		'content' => m_a_p('content'),
		'liked' => m_a_p('liked'),
		'unliked' => m_a_p('unliked'),
		'status' => m_a_p('status')
		
		];
		
		$query = $db->table('comments')->where('id','=',m_a_g('id'))->update($data);
		if($info['status']==0 and m_a_p('status')==1)
		{
			m_user_notification_push('comment',$info['r_id']);
			if($info['answered_u_id']!=0)
			{
								m_user_notification_push('comment_answer',$info['id']);
			}
		}
		$informations = $db->table('comments')->where('id','=',m_a_g('id'))->get();
		$info = $informations['data'][0];
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
<form action="" method="post" enctype="multipart/form-data">
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">İnceleme:</label>
		<div class="col-lg-9">
			<a href="<?php echo MODERATOR_URL; ?>/index.php?page=review_detail&id=<?php echo $info['r_id']; ?>" target="_blank"><?php echo $db->table('reviews')->where('id','=',$info['r_id'])->get_var('title'); ?></a>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Kullanıcı:</label>
		<div class="col-lg-9">
			<a href="<?php echo MODERATOR_URL; ?>/index.php?page=user&id=<?php echo $info['u_id']; ?>" target="_blank"><?php echo m_user('username',$info['u_id']); ?></a>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Tarih:</label>
		<div class="col-lg-9">
			<?php echo m_date_to_tr($info['date']); ?>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Beğenildi:</label>
		<div class="col-lg-9">
			<input type="number" class="form-control" name="liked" value="<?php echo $info['liked']; ?>" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Beğenilmedi:</label>
		<div class="col-lg-9">
			<input type="number" class="form-control" name="unliked" value="<?php echo $info['unliked']; ?>" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Yorum:</label>
		<div class="col-lg-9">
			<textarea name="content" class="form-control" style="height:200px"><?php echo $info['content']; ?></textarea>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Durum</label>
		<div class="col-lg-9">
			<select name="status" class="select2">
				<?php
			$comment_status[0]['id'] = '0';
			$comment_status[0]['name'] = 'Onay Bekliyor';
			
			$comment_status[1]['id'] = '1';
			$comment_status[1]['name'] = 'Onaylandı';
			foreach($comment_status as $status)
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
</div>
