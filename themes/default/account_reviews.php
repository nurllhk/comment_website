<?php
	m_header();
	$user_wait_revise_reviews = $db->table('reviews')->where('u_id','=',USER['id'])->where('status','=',3)->count();
?>   
<div class="main">
	<div class="container">
		<div class="row">

		
		<div class="col-xl-12 col-lg-12 col-sm-12">
		<div class="page_head">
		<div class="page_icon"><i class="fa fa-pen-square"></i></div>
		<div class="page_title"><h1>İncelemelerim</h1></div>
		</div>
		<div class="row">
		
		<div class="col-xl-4 col-lg-4 col-sm-4 col-12">
			
			<?php require_once('account_part.php'); ?>
		
		</div>
		
		<div class="col-xl-8 col-lg-8 col-sm-8 col-12">
			
		<div class="card mb-3">
		<div class="card-header text-white"><i class="fa fa-search"></i> Filtreleme</div>
		<div class="card-body">
			<form class="user_reviews_search_form">
			<div class="mb-3">
					<label class="form-label">Durum</label>
					<select class="form-select" name="status">
							<option value="">Tüm İncelemeler</option>
							<option value="1">Yayınlandı</option>
							<option value="4">Yayınlanmayı Bekliyor</option>
							<option value="3">Düzenleme Bekliyor</option>
							<option value="0">Onay Bekliyor</option>
							<option value="2">Reddedildi</option>
					</select>
			</div>
			<div class="mb-3">
					<label class="form-label">Arama</label>
					<input type="text" class="form-control" name="q" placeholder="Seçili durumdaki incelemelerinizde arayın, yazın ve enterlayın.">
			</div>
			</form>
		</div>
		</div>
		<?php
		if($user_wait_revise_reviews>0)
		{
			echo '<div class="alert alert-primary mb-3"><i class="fa fa-pen-square"></i> '.$user_wait_revise_reviews.' adet incelemeniz düzenleme bekliyor, inceleme eklemeye devam edebilmek için incelemenizi düzenleyiniz.</div>';
		}
		?>
		
			<div class="user_reviews_list mb-3">
			</div>
		
		
		
		
		
		</div>
		
		
		
		</div>
		</div>
		
		
		
		</div>
	</div>
</div>
<?php
	m_footer();
?>
					