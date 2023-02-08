<?php
	m_header();
	$wait_reviews = $db->table('reviews')->where('u_id','=',USER['id'])->where('status','=',3)->count();
?>
<div class="main">
	<div class="container">
		<div class="page_head">
		<div class="page_icon"><i class="fa fa-exclamation-triangle"></i></div>
		<div class="page_title"><h1>Bekleyen Düzenleme Talepleri</h1></div>
		</div>
		
	
		
		<div class="mt-3">
	
		
		<div class="card mb-2">
			<div class="card-body">
			
			
			<div class="text-center"><i class="fa fa-exclamation-triangle fa-4x mb-3"></i></div>
			<div class="alert alert-danger mb-2"><i class="fa fa-info-circle"></i> Mevcut incelemelerinizde düzenleme talep edilen incelemeleriniz ( <?php echo $wait_reviews; ?> ) bulunuyor. Bu incelemeleri düzenlemeden yeni inceleme oluşturamazsınız.</div>
			<div class="alert alert-info mb-2"><i class="fa fa-question-circle"></i> Hesabınızdaki, İncelemelerim bölümünden "Düzenleme Bekliyor" incelemelerinizi filtreleyerek ulaşabilirsiniz.</div>
		
			
			</div>
		
		</div>
		
	
	</div>
</div>
</div>
		

<?php
	m_footer();
?>
					