<?php if(!defined('ADMIN_INCLUDED')) { exit; } ?>
<div class="content">
<div class="navbar navbar-dark navbar-expand-md navbar-component">
<div class="d-md-none">
</div>
<div class="collapse navbar-collapse" id="navbar-component">
	<ul class="navbar-nav">
		<li class="nav-item">
			<a href="<?php echo MODERATOR_URL;?>/index.php" class="navbar-nav-link">Anasayfa</a>
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
<h5 class="card-title">Yorum Gönder</h5>
</div>

<div class="card-body">
<?php
if($_POST)
{
	if(m_u_p('r_id')==0 or trim(m_u_p('content'))=='')
	{
		echo m_alert('Hata','İnceleme seçiniz ve yorumu boş bırakmayınız!.');
	}
	else
	{
		$data = [
		'r_id' =>  m_u_p('r_id'),
		'u_id' =>  m_u_p('u_id'),
		'content' => m_u_p('content'),
		'status' => 1
		
		];
		$query = $db->table('comments')->insert($data);		
		if($query)
		{
			$review = $db->table('reviews')->where('id','=',m_u_p('r_id'))->get_vars();
			
			m_user_notification_push('comment',$review['id']);		
			echo m_alert('Başarılı','Yorum başarıyla gönderildi, inceleme sahibine bildirim gönderildi.');
			
			echo '
			<a href="'.m_permalink('review',$review['sef'],$review['id']).'" target="_blank" class="btn btn-sm btn-primary">Yorum Yapılan İncelemeyi Görmek İçin Tıklayın</a>';
		}
		else
		{
			echo m_alert('Hata','İşlem gerçekleştirilirken bir hata oluştu.');
		}
	}
}
?>
<form action="" method="post">
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Yorum Yapılacak İnceleme ( Son 30 İnceleme Arasından Herhangi Bir Editör Tarafından Yorum Yapılmamış İncelemeler ):</label>
		<div class="col-lg-9">
			
			<select class="form-control select2 add_comment_review" name="r_id">
			<option value="0">İnceleme Seçiniz</option>
			<?php
			$editors = $db->table('users')->where('status','=','1')->where('editor','=','1')->order('id','asc')->get();
			$editor_ids = array();
			foreach($editors['data'] as $editor)
			{
				array_push($editor_ids,$editor['id']);
			}
			$editor_ids = implode(',',$editor_ids);
			$reviews = $db->table('reviews')->where('status','=','1')->order('date','desc')->limit(30)->get();
			foreach($reviews['data'] as $review)
			{
					
					$count = $db->table('comments')->where('r_id','=',$review['id'])->where_set('u_id','IN',' ('.$editor_ids.') ')->count();
					
					if($count==0)
					{
						echo '<option value="'.$review['id'].'">'.$review['title'].'</option>';
					}
			}
			?>
			</select>
			<br>
			<br>
			<div class="add_comment_review_detail"><b>İnceleme seçtiğinizde incelemenin ürününe ait bilgiler burada yer alacak</b></div>
			
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Yorumcu (  Rastgele Getirildi - Ama Farklı Seçilebilir ) :</label>
		<div class="col-lg-9">
			<select class="form-control select2" name="u_id">
			<?php
			$users = $db->table('users')->where('status','=','1')->where('editor','=','1')->order('rand()','')->get();
			foreach($users['data'] as $user)
			{
					echo '<option value="'.$user['id'].'">'.$user['username'].'</option>';
			}
			?>
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Yorum:</label>
		<div class="col-lg-9">
			<textarea name="content" class="form-control"></textarea>
		</div>
	</div>
	<div>
		<button type="submit" class="btn btn-primary">Ekle <i class="icon-paperplane ml-2"></i></button>
	</div>
</form>
</div>
</div>
</div>
