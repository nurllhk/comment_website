<?php if(!defined('ADMIN_INCLUDED')) { exit; } ?>

<?php

	$informations = $db->table('support')->where('to_admin','=',1)->where('id','=',m_a_g('id'))->get();
MADMIN_URL
	if($informations['total_count']=='0')

	{

		m_redirect(MADMIN_URL);

	}

	$info = $informations['data'][0];

	$support_messages = $db->table('support_messages')->where('s_id','=',$info['id'])->get();
MADMIN_URL
?>   

<div class="content">

<div class="navbar navbar-dark navbar-expand-md navbar-component">

<div class="d-md-none">

</div>

<div class="collapse navbar-collapse" id="navbar-component">

	<ul class="navbar-nav">

		<li class="nav-item">

			<a href="<?php echo MADMIN_URL;?>/index.php?page=support&status=0" class="navbar-nav-link">Destek Talepleri</a>

		</li>

		<li class="nav-item">

			<a href="#" class="navbar-nav-link"><i class="fa fa-share"></i></a>

		</li>

		<li class="nav-item">

			<a href="#" class="navbar-nav-link">Destek Talebi</a>

		</li>

	</ul>



</div>

</div>



<?php

if($_POST)

{

	if(m_a_p('type')=='close')

	{

		$data = [

		'status' => 2,

		'update_date' => $db->now()

		

		];

		MADMIN_URL

		$query = $db->table('support')->where('id','=',m_a_g('id'))->update($data);

		

		m_user_notification_push('closed_support',$info['u_id']);

		

		echo m_alert('Başarılı','İşleminiz başarıyla gerçekleştirildi.');

	}

	if(m_a_p('type')=='message')

	{

		if(m_a_p('content')=='')

		{

			echo m_alert('Hata','Lütfen cevabı boş bırakmayın.');

		}

		else

		{

			$data = [

					's_id' => $info['id'],

					'author_role' => 1,

					'author_id' => 1,

					'content' => m_a_p('content')

					

					];

					

			$id = $db->table('support_messages')->insert($data);

			

			$data = [

			'status' => 1,

			'update_date' => $db->now(),

			

			];

			$query = $db->table('support')->where('id','=',m_a_g('id'))->update($data);

			

			m_user_notification_push('answered_support',$info['u_id']);

			

			echo m_alert('Başarılı','İşleminiz başarıyla gerçekleştirildi.');

		}

	}

	$informations = $db->table('support')->where('id','=',m_a_g('id'))->get();

	if($informations['total_count']=='0')

	{

		m_redirect(MADMIN_URL);

	}

	$info = $informations['data'][0];

	$support_messages = $db->table('support_messages')->where('s_id','=',$info['id'])->get();

	

}

?>







<div class="row">



<div class="col-lg-8">



<div class="card">

<div class="card-header bg-primary text-white header-elements-inline">

<h5 class="card-title"><?php echo $info['title']; ?></h5>

</div>



<div class="card-body">



	

	<?php echo $info['content']; ?>

	

</div>

</div>



<?php

if($support_messages['total_count']>0)

{

	foreach($support_messages['data'] as $message)

	{

		if($message['author_role']==1)

		{

			$author = m_admin('name',$message['author_id']).' '.m_admin('lastname',$message['author_id']);

			$card_bg = 'bg-dark text-white';

		}

		else

		{MADMIN_URL

			$author = 'Kullanıcı';

			$card_bg = 'bg-primary text-white';

		}

?>





<div class="card mb-3">

<div class="card-header <?php echo $card_bg; ?>"><?php echo $author; ?></div>

<div class="card-body">

	

	<?php echo $message['content']; ?>

	

</div>

<div class="card-footer text-right">
MADMIN_URL
	<i class="fa fa-clock"></i> <?php echo m_time_ago($message['update_date']); ?>

</div>

</div>



<?php

	}

}

?>



<div class="card mb-2">

<div class="card-header bg-warning text-white header-elements-inline">

<h5 class="card-title">Hazır Şablon Kullanarak Cevapla</h5>

</div>



<div class="card-body">

	<select class="select2 support_template_select">

	<option value="0">Lütfen Seçiniz</option>

	<?php

			$support_templates = $db->table('support_templates')->order('title','asc')->get();

			foreach($support_templates['data'] as $support_template)

			{

				echo '<option value="'.$support_template['id'].'">'.$support_template['title'].'</option>';

			}

	?>

	</select>

	<?php

			$support_templates = $db->table('support_templates')->order('title','asc')->get();

			foreach($support_templates['data'] as $support_template)

			{

				echo '<div class="support_template_'.$support_template['id'].'" style="display:none;">'.$support_template['content'].'</div>';

			}

	?>

	

</div>

</div>



<div class="card mb-2">

<div class="card-header bg-dark text-white header-elements-inline">

<h5 class="card-title">Cevap Yazın</h5>

</div>



<div class="card-body">

	<form action="" method="post" enctype="multipart/form-data">

		<input type="hidden" name="type" value="message">

		<textarea name="content" class="summernote"></textarea>

	

		<div>

		<button type="submit" class="btn btn-primary">Cevabı Gönder <i class="icon-paperplane ml-2"></i></button>

		</div>

	</form>

	

</div>

</div>



</div>



<div class="col-lg-4">



<form action="" method="post" enctype="multipart/form-data">

		<input type="hidden" name="type" value="close">

		<div>

		<button type="submit" class="btn btn-danger btn-block">Talebi Kapatın</button>

		</div>

</form>



<div class="card">

<div class="card-header bg-dark text-white header-elements-inline">

<h5 class="card-title">Diğer Detaylar</h5>

</div>



<div class="card-body">



	

	<ol class="list-group mb-2">

	  <li class="list-group-item d-flex justify-content-between align-items-start">

		<div class="ms-2 me-auto">

		  <div class="fw-bold"><i class="fa fa-calendar text-success me-3"></i> Oluşturulma Tarihi</div>

		  <?php echo m_time_ago($info['creation_date']); ?>

		</div>

	  </li>

	  <li class="list-group-item d-flex justify-content-between align-items-start">

		<div class="ms-2 me-auto">

		  <div class="fw-bold"><i class="fa fa-clock text-success me-3"></i> Güncelleme</div>

		  <?php echo m_time_ago($info['update_date']); ?>

		</div>

	  </li>

	  <li class="list-group-item d-flex justify-content-between align-items-start">

		<div class="ms-2 me-auto">

		  <div class="fw-bold"><i class="fa fa-question-circle text-success me-3"></i> Bölüm</div>

		  <?php echo $info['type']; ?>

		</div>

	  </li>

	  <?php

		  if($info['review_id']!=0)

		  {

			$review_detail = $db->table('reviews')->where('id','=',$info['review_id'])->get();

			if($review_detail['total_count']>0)

			{

				$review_info = $review_detail['data'][0];

		  ?>

		  <li class="list-group-item d-flex justify-content-between align-items-start">

			<div class="ms-2 me-auto">

			  <div class="fw-bold"><i class="fa fa-pen-square text-success me-3"></i> İlgili İnceleme</div>

			  <a href="<?php echo MADMIN_URL; ?>/index.php?page=review_detail&id=<?php echo $review_info['id']; ?>" target="_blank"><?php echo $review_info['title']; ?></a>

			</div>

		  </li>

	  <?php

			}

		  }

	  ?>

	  <li class="list-group-item d-flex justify-content-between align-items-start">

		<div class="ms-2 me-auto">

		  <div class="fw-bold"><i class="fa fa-info-circle text-success me-3"></i> Durum</div>

		  <?php echo m_support_status($info['status']); ?>

		</div>

	  </li>

	</ol>





</div>

</div>



<div class="card">

<div class="card-header bg-dark text-white header-elements-inline">

<h5 class="card-title">Kullanıcı Bilgileri</h5>

</div>



<div class="card-body">



	<div class="form-group row">

		<label class="col-lg-6 col-form-label">Kullanıcı:</label>

		<div class="col-lg-6">

			<a href="<?php echo MADMIN_URL; ?>/index.php?page=user&id=<?php echo $info['u_id']; ?>" target="_blank"><?php echo m_user('username',$info['u_id']); ?></a>

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

			<span class="btn btn-sm btn-danger"><i class="fa fa-times"></i> Reddedilen: <?php echo m_user('rejected_reviews',$info['u_id']); ?></span>

		</div>

	</div>





</div>

</div>







</div>





</div>







</div>





