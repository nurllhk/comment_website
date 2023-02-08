<?php
	m_header();
?>  
<div class="main">
	<div class="container">
		<div class="row">
		<div class="col-xl-12 col-lg-12 col-sm-12 col-12">
		<div class="page_head">
		<div class="page_icon"><i class="fa fa-pen-square"></i></div>
		<div class="page_title"><h1>İnceleme Ekle</h1></div>
		</div>
		<div class="mt-3">
		<div class="row">
		
		<div class="col-xl-12 col-lg-12 col-sm-12">
		
		<div class="card">
		<div class="card-header card_tab_header">
			  <ul class="nav nav-tabs card-header-tabs" id="pills-tab" role="tablist">
			  <li class="nav-item">
				<a class="nav-link" href="<?php echo m_permalink('add_product'); ?>">Yeni Ekle</a>
			  </li>
			  
			  <li class="nav-item">
			   <a class="nav-link active" href="<?php echo m_permalink('add_review'); ?>">Önce Sitede Bul</a>
			  </li>
			  </ul>
		</div>
		  <div class="card-body">  

				  <div class="alert alert-info"><i class="fa fa-info-circle"></i> Web sitemizde yarım milyondan daha fazla ürün bulunmaktadır, lütfen eklemeden önce kontrol edin.</div>
				  <form method="post" action="" class="mb-3">
					<div class="form-group">
					  <label class="form-label">Ürün / Hizmet Adı</label>
					  <input type="text" class="form-control review_product_search" placeholder="Aramak için yazınız. ( En az 4 karakter )">
					</div>
					<div class="review_product_results">
						<div class="product__result-cover">
						<ul>
						</ul>
						</div>
					</div>
				  </form>
				  <a href="<?php echo m_permalink('add_product'); ?>" class="btn btn-default btn-sm"><i class="fa fa-plus-circle"></i> Aradığınız ürünü bulamadınızmı ? Bunu sitemize ekleyin!</a>
				 
		<!-- <div id="ezoic-pub-ad-placeholder-141"> </div> -->	
		  </div>
		</div>
		<div id="ezoic-pub-ad-placeholder-112"> </div>
		
		
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