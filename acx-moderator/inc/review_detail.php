<?php if(!defined('ADMIN_INCLUDED')) { exit; } ?>
<?php

	$informations = $db->table('reviews')->where('id','=',m_a_g('id'))->get();
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
			<a href="<?php echo MODERATOR_URL;?>/index.php?page=reviews&status=0" class="navbar-nav-link">İncelemeler</a>
		</li>
		<li class="nav-item">
			<a href="#" class="navbar-nav-link"><i class="fa fa-share"></i></a>
		</li>
		<li class="nav-item">
			<a href="#" class="navbar-nav-link">İnceleme</a>
		</li>
	</ul>

</div>
</div>

<form action="" method="post" enctype="multipart/form-data">

<div class="row">

<div class="col-lg-8">

<div class="card">
<div class="card-header bg-dark text-white header-elements-inline">
<h5 class="card-title">İnceleme Düzenle</h5>
</div>

<div class="card-body">
<?php
if($_POST)
{
		$status = $info['status'];
		$wait_publish_date = $info['wait_publish_date'];
		
		$rejected_type = $info['rejected_type'];
		
			
		if(m_a_p('rejected_type')!='')
		{
			$rejected_type = m_a_p('rejected_type');
		}
		
		
		if(m_a_p('status')==4)
		{
			$last_wait_publish_date = $db->table('reviews')->where('status','=',4)->order('wait_publish_date')->limit(1)->get();
			if($last_wait_publish_date['total_count']>0)
			{
				$wait_publish_date = strtotime($last_wait_publish_date['data'][0]['wait_publish_date']);
			}
			else
			{
				$wait_publish_date = time();
			}
			$wait_publish_date = strtotime("+ 10 minutes",$wait_publish_date);
			$wait_publish_date = m_time_db_format($wait_publish_date);
			
			email_send(m_user('email',$info['u_id']),'İncelemeniz Onaylandı',email_inceleme_onay(m_user('username',$info['u_id']),$info['title'],m_permalink('account_page','incelemeler')));
			m_user_notification_push('approved_review',$info['id']);	

			$status = 4;
			
		}
		if(m_a_p('status')==2)
		{
			$db->query("update users set rejected_reviews=rejected_reviews+1 where id='".$info['u_id']."'");
			$copy_reviews = $db->table('rejected_types')->where('id','=',m_a_p('rejected_type'))->get_vars()['copy'];
			if($copy_reviews==1)
			{
				$db->query("update users set copy_reviews=copy_reviews+1 where id='".$info['u_id']."'");
			}
			email_send(m_user('email',$info['u_id']),'İncelemeniz Reddedildi',email_inceleme_red(m_user('username',$info['u_id'])));
			m_user_notification_push('rejected_review',$info['id']);
			
			$status = 2;
			
		}
		
		if(m_a_p('status')==3)
		{
			$db->query("update users set rejected_reviews=rejected_reviews+1 where id='".$info['u_id']."'");
			$copy_reviews = $db->table('rejected_types')->where('id','=',m_a_p('rejected_type'))->get_vars()['copy'];
			if($copy_reviews==1)
			{
				$db->query("update users set copy_reviews=copy_reviews+1 where id='".$info['u_id']."'");
			}
			email_send(m_user('email',$info['u_id']),'İncelemeniz Düzenleme Bekliyor',email_inceleme_duzenleme(m_user('username',$info['u_id'])));
			m_user_notification_push('wait_revise_review',$info['id']);
			
			$status = 3;
			
		}
		
		if(m_a_p('status')==0)
		{
			$status = 0;
			
		}
		
		
		
		
		
		if(m_a_p('status')==4)
		{
			$content = m_content_tmp_replace(m_a_p('content'));
		}
		else
		{
			$content = m_a_p('content');
		}
		
		
		$data = [
		'p_id' => m_a_p('p_id'),
		'rate' => m_a_p('rate'),
		'rejected_type' => $rejected_type,
		'approved_point' => m_a_p('approved_point'),
		'first_point' => m_a_p('first_point'),
		'word_point' => m_a_p('word_point'),
		'spelling_point' => m_a_p('spelling_point'),
		'image_point' => m_a_p('image_point'),
		'original_image_point' => m_a_p('original_image_point'),
		'paragraph_point' => m_a_p('paragraph_point'),
		'title' => m_a_p('title'),
		'content' => $content,
		'sef' => m_sef(m_a_p('title')),
		'wait_publish_date' => $wait_publish_date,
		'status' => $status,
		
		];
		
		$query = $db->table('reviews')->where('id','=',m_a_g('id'))->update($data);
		
		$informations = $db->table('reviews')->where('id','=',m_a_g('id'))->get();
		$info = $informations['data'][0];
		if($query)
		{
			m_moderator_action_add('review',$info['id'],$status);
			echo m_alert('Başarılı','İşleminiz başarıyla gerçekleştirildi.');
		}
		else
		{
			echo m_alert('Hata','İşlem gerçekleştirilirken bir hata oluştu.');
		}
	
}
?>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Tarih:</label>
		<div class="col-lg-9">
			<?php echo m_date_to_tr($info['date']); ?>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Başlık</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="title" value="<?php echo $info['title']; ?>" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Puan ( Maksimum 5 )</label>
		<div class="col-lg-9">
			<input type="number" class="form-control" name="rate" value="<?php echo $info['rate']; ?>" max="5" required>
		</div>
	</div>
	<button type="button" class="btn btn-success btn-block mt-1 mb-1 plagiarism_checker">SADECE YAZIYI KOPYALA <i class="icon-search4 ml-2 "></i></button>
	<div class="form-group row">
		<label class="col-lg-12 col-form-label">İnceleme Detayı:</label>
		<div class="col-lg-12">
		<button type="button" class="btn btn-primary btn-block mt-1 mb-1" data-toggle="modal" data-target="#review_image_editor">GÖRSEL EKLE-DEĞİŞTİR <i class="icon-images ml-2 "></i></button>
			
			<textarea name="content" class="summernote review_editor"><?php echo $info['content']; ?></textarea>
			<div class="review_editor_clone" style="display:none;"></div>
			<div style="float:right;margin-top:12px">
			<span class="btn btn-sm btn-secondary review_content_count">0</span>
			</div>
		</div>
	</div>
	
	<div class="form-group row">
		<label class="col-lg-3">Fotoğrafların Ortalama Kalitesi:</label>
		<div class="col-lg-9">
		<?php
		$image_check = true;
		preg_match_all('@src="(.*?)"@si',$info['content'],$images);
		foreach($images[1] as $image_url)
		{
			$image_path = ROOT_FOLDER.'/'.str_replace('https://www.acikliyorum.com/','',$image_url);
			
			if(file_exists($image_path) and strstr($image_url,'https://www.acikliyorum.com/'))
			{
				$sizes = getimagesize($image_path);
				
				if($sizes and $sizes[0]<400)
				{
					$image_check = false;
				}
			}
			
			
		}
		if($image_check)
		{
			echo '<span class="btn btn-sm btn-success"><i class="fa fa-check-circle"></i> İyi</span>';
		}
		else
		{
			echo '<span class="btn btn-sm btn-danger"><i class="fa fa-times"></i> Kötü</span>';
		}
		?>
		
		</div>
	</div>
	
	<div class="form-group row">
		<label class="col-lg-3">Durum:</label>
		<div class="col-lg-9"><?php echo m_review_status($info['status']); ?></div>
	</div>
	<?php
	if($info['status']==4)
	{
	?>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Yayınlanacağı Tarih</label>
		<div class="col-lg-9">
			<?php echo m_date_to_tr($info['wait_publish_date']); ?>
		</div>
	</div>
	<?php
	}
	?>
	<div class="form-group row">
		<label class="col-lg-3">Ödeme - Puan İşlendimi ?:</label>
		<div class="col-lg-9"><?php echo m_yes_no($info['pay_and_point_completed']); ?></div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3">Haftanın Kategorisi ?:</label>
		<div class="col-lg-9"><?php echo m_yes_no($info['week_category']); ?></div>
	</div>
	<?php
	if($info['rejected_type']>0)
	{
	?>
	<div class="form-group row">
		<label class="col-lg-6">SON Düzenleme Talebi / RED Nedeni:</label>
		<div class="col-lg-6">
			<?php echo $db->table('rejected_types')->where('id','=',$info['rejected_type'])->get_var('title'); ?>
		</div>
	</div>
	<?php
	}
	?>
	<?php
	if($info['revised']>0)
	{
		echo m_alert('Bilgi','Bu inceleme düzenleme talebi sonrası kullanıcı tarafından güncellendi. <br><br><b>Düzenlenme Adeti:</b> '.$info['revised'].'');
	}
	?>
	<?php
	if($info['status']==0)
	{
	?>
	<div class="form-group row">
		<label class="col-lg-6 col-form-label">Düzenleme Talebi / Red Nedeni Seçin</label>
		<div class="col-lg-6">
			<select class="form-control select2" name="rejected_type">
			<option value="0">Belirlenmedi</option>
			<?php
			$rejected_types = $db->table('rejected_types')->order('rt_rank','asc')->get();
			foreach($rejected_types['data'] as $rejected_type)
			{
				if($info['rejected_type']==$rejected_type['id'])
				{
					$selected='selected';
				}
				else
				{
					$selected='';
					
				}
				echo '<option value="'.$rejected_type['id'].'" '.$selected.'>'.$rejected_type['title'].'</option>';
			}
			?>
			</select>
		</div>
	</div>
	<button type="submit" class="btn btn-success btn-sm btn-block mb-2" name="status" value="4" style="text-align:left;padding-left:30%;"><i class="fa fa-check-square"></i> ONAYLA VE YAYIN PLANLA</button>
	<button type="submit" class="btn btn-info btn-sm btn-block mb-2" name="status" value="3" style="text-align:left;padding-left:30%;"><i class="fa fa-check-square"></i> DÜZENLEME TALEP ET</button>
	<button type="submit" class="btn btn-danger btn-sm btn-block mb-2" name="status" value="2" style="text-align:left;padding-left:30%;"><i class="fa fa-times-circle"></i> REDDET</button>
	<?php
	}
	?>
	<?php
	if($info['status']==1 or $info['status']==2 or $info['status']==3)
	{
	?>
	<button type="submit" class="btn btn-warning btn-sm btn-block mb-2" name="status" value="0" style="text-align:left;padding-left:30%;"><i class="fa fa-bullseye"></i> ONAY BEKLİYOR MODUNA AL</button>
	<?php
	}
	?>
	<?php
	if($info['status']==4)
	{
	?>
	<button type="submit" class="btn btn-warning btn-sm btn-block mb-2" name="status" value="0" style="text-align:left;padding-left:30%;"><i class="fa fa-times"></i> YAYINLANMA PLANINI İPTAL ET VE ONAY BEKLİYOR MODUNA AL</button>
	<?php
	}
	?>

	
	<div>
	<button type="submit" class="btn btn-primary btn-block mt-5"><i class="icon-paperplane ml-2"></i> Durum Değiştirmeden Kaydet </button>
	</div>

</div>
</div>

</div>

<div class="col-lg-4">

<div class="card">
<div class="card-header bg-dark text-white header-elements-inline">
<h5 class="card-title">Özgünlük Sonuçları</h5>
</div>

<div class="card-body">

	<?php
	if($info['plagiarism']==0)
	{
		echo m_alert('Bilgi','Kontrol henüz tamamlanmadı.');
	}
	else
	{
		echo '<span class="btn bg-success-400 btn-labeled btn-labeled-left mb-2 content_actions text-left"><b><i class="icon-checkmark"></i></b> Özgün: <span class="font-weight-bold">%'.$info['original_content'].'</span></span>
		
		<span class="btn bg-warning-400 btn-labeled btn-labeled-left mb-2 content_actions text-left"><b><i class="icon-close2"></i></b> Kopya: <span class="font-weight-bold">%'.$info['copy_content'].'</span></span>
		';
	}
	?>
	
	<button type="button" class="btn btn-primary btn-block mt-1 mb-1" data-toggle="modal" data-target="#plagiarism_result">İnceleme İntihal Detayları <i class="icon-search4 ml-2 "></i></button>


</div>
</div>

<div class="card">
<div class="card-header bg-dark text-white header-elements-inline">
<h5 class="card-title">Kullanıcı Bilgileri</h5>
</div>

<div class="card-body">

	<div class="form-group row">
		<label class="col-lg-6">Kullanıcı:</label>
		<div class="col-lg-6">
			<a href="<?php echo MODERATOR_URL; ?>/index.php?page=user&id=<?php echo $info['u_id']; ?>" target="_blank"><?php echo m_user('username',$info['u_id']); ?></a>
		</div>
	</div>
	<?php
		if(m_user('editor',$info['u_id'])==1)
		{
			echo '<span class="btn btn-success btn-block">EDİTÖR ÜYELİĞİ!</span> <br>';
		}
	?>
	<div class="form-group row">
		<div class="col-lg-12">
			<span class="btn btn-sm btn-success"><i class="fa fa-check-square"></i> Onaylı: <?php echo $db->table('reviews')->where('u_id','=',$info['u_id'])->where('status','=',1)->count(); ?></span> 
			<span class="btn btn-sm btn-warning"><i class="fa fa-exclamation-triangle"></i> Kopya: <?php echo m_user('copy_reviews',$info['u_id']); ?></span>
			<span class="btn btn-sm btn-danger"><i class="fa fa-times"></i> Red: <?php echo m_user('rejected_reviews',$info['u_id']); ?></span>
		</div>
	</div>


</div>
</div>

<div class="card">
<div class="card-header bg-dark text-white header-elements-inline">
<h5 class="card-title">Ürün - İnceleme Bilgileri</h5>
</div>

<div class="card-body">

	<div class="form-group row">
		<label class="col-lg-3">Ürün:</label>
		<div class="col-lg-9">
			<select class="form-control product_select_search" name="p_id" id="product_id">
			<?php
			$products = $db->table('products')->where('id','=',$info['p_id'])->order('title','asc')->limit(1)->get();
			foreach($products['data'] as $product)
			{
			
				if($info['p_id']==$product['id'])
				{
					$selected=' selected="selected"';
				}
				else
				{
					$selected='';
				}
				echo '<option value="'.$product['id'].'"'.$selected.'>'.$product['title'].'</option>';
				
			}
			?>
			</select>
			<?php
			if($products['data'][0]['add_user']!=0)
			{
			?>
			<span class="mt-1 mb-1 btn btn-danger btn-sm btn-block">Ürün Kullanıcı Tarafından Eklendi!</span>
			<?php
			}
			?>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-6">Ürün Linki:</label>
		<div class="col-lg-6">
			<a href="<?php echo ''.MODERATOR_URL.'/index.php?page=product&id='.$info['p_id'].''; ?>" target="_blank">Ürünü Düzenle</a>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-6">İnceleme Linki:</label>
		<div class="col-lg-6">
			<a href="<?php echo ''.SITE_DOMAIN.'/yorumlari/'.$info['id'].'/'.$info['sef'].''; ?>" target="_blank">İncelemeyi Gör</a>
		</div>
	</div>


</div>
</div>



<div class="card">
<div class="card-header bg-dark text-white header-elements-inline">
<h5 class="card-title">Puanlar</h5>
</div>

<div class="card-body">

	<div class="form-group row">
		<label class="col-lg-8 col-form-label">Onaylanmış İnceleme Puanı:</label>
		<div class="col-lg-4">
			<input type="number" class="form-control" name="approved_point" value="<?php echo $info['approved_point']; ?>" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-8 col-form-label">İlk İnceleme Puanı:</label>
		<div class="col-lg-4">
			<input type="number" class="form-control" name="first_point" value="<?php echo $info['first_point']; ?>" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-8 col-form-label">Kelime Oranı Puanı:</label>
		<div class="col-lg-4">
			<input type="number" class="form-control" name="word_point" value="<?php echo $info['word_point']; ?>" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-8 col-form-label text-danger font-weight-bold">İmla Puanı:</label>
		<div class="col-lg-4">
			<input type="number" class="form-control" name="spelling_point" value="<?php echo $info['spelling_point']; ?>" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-8 col-form-label">Fotoğraf Başına Puanı:</label>
		<div class="col-lg-4">
			<input type="number" class="form-control" name="image_point" value="<?php echo $info['image_point']; ?>" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-8 col-form-label text-danger font-weight-bold">Kalite Fotoğraf Puanı:</label>
		<div class="col-lg-4">
			<input type="number" class="form-control" name="original_image_point" value="<?php echo $info['original_image_point']; ?>" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-8 col-form-label text-danger font-weight-bold">Paragraf ve Fotoğraf Düzeni Puanı:</label>
		<div class="col-lg-4">
			<input type="number" class="form-control" name="paragraph_point" value="<?php echo $info['paragraph_point']; ?>" required>
		</div>
	</div>


</div>
</div>

</div>


</div>

</form>

</div>

<div id="plagiarism_result" class="modal fade" tabindex="-1">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">İnceleme İntihal Sonuçları</h5>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>

							<div class="modal-body">
							<?php echo $info['plagiarism_result']; ?>
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-primary" data-dismiss="modal">Kapat</button>
							</div>
						</div>
					</div>
</div>

<div id="review_image_editor" class="modal fade" tabindex="-1">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">İnceleme Resim İşlemleri</h5>
								<button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>

							<div class="modal-body">
							<form class="review_image_editor_ajax" enctype="multipart/form-data">
							<input type="hidden" name="type" value="review_image_editor_ajax">
								<h6 class="font-weight-bold">Yüklenecek Resim</h6>
								<input type="file" class="form-control text_search mb-3" name="image">
								<h6 class="font-weight-bold">Kaçıncı Resim Değiştirilecek ?</h6>
								<div class="input-group mb-2">
										<span class="input-group-prepend">
											<span class="input-group-text"><i class="fa fa-images"></i></span>
										</span>
										<select class="form-control review_image_number" name="source">
											<option value="0">1</option>
											<option value="1">2</option>
											<option value="2">3</option>
											<option value="3">4</option>
										</select>
										
								</div>
								<button type="submit" class="btn btn-sm btn-success btn-block"><i class="fa fa-plus-circle"></i> Yükle ve Değiştir</button>
							</form>
							
							
							
								
							</div>

							<div class="modal-footer">
								<button type="button" class="btn btn-primary" data-dismiss="modal">Kapat</button>
							</div>
						</div>
					</div>
</div>

