<?php
m_header();
header("HTTP/1.0 404 Not Found");
?>   
<div class="main">
	<div class="container">
		<div class="row">
		<div class="col-xl-12 col-lg-12 col-sm-12 col-12">
		<div class="page_head">
		<div class="page_icon"><i class="fa fa-info-circle"></i></div>
		<div class="page_title"><h1>Sayfa Bulunamadı</h1></div>
		</div>
		<div class="mt-3">
		<div class="row">
		
		<div class="col-xl-12 col-lg-12 col-sm-12">
		
		<div class="content_box">
		
		<?php echo m_alert('Hata','Üzgünüz belirttiğiniz sayfayı bulamadık, eğer bir ürün veya inceleme arıyorsanız arama yapabilirsiniz.'); ?>
		
		</div>
		
		
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
