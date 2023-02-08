<?php
	m_header();
	$brands = $db->table('brands')->where('id','=',m_u_g('id'))->where('sef','=',m_u_g('sef'))->where('status','=',1)->get();
	if($brands['total_count']=='0')
	{
		m_redirect(SITE_DOMAIN);
	}
	$brand = $brands['data'][0];
	
	
	$brand_rating = $db->select('ROUND(AVG(rate),1) as rating')->table('reviews')->where('status','=',1)->where('b_id','=',$brand['id'])->get();
	$brand_rating = $brand_rating['data'][0]['rating'];
	if($brand_rating=='')
	{
		$brand_rating = '1.0';
	}
	
	if(m_u_g('order')=='')
	{
		$order = 'r_date desc';
		$order_title = 'Tarih';
	}
	else
	{
		$order = 'r_rate desc';
		$order_title = 'Puan';
	}
	
	$review_list = new m_review();
	$review_list->template 					= 'default';
	$review_list->template_col 				= 'col-xl-4 col-lg-4 col-sm-12';
	$review_list->include_user	 			= true;
	$review_list->include_product 			= true;
	$review_list->query_options 			= "where p.b_id='".$brand['id']."' and r.status='1'";
	$review_list->order 					= "order by ".$order."";
	$review_list->paginate 					= 12;
	$result = $review_list->list_reviews();
	$brand_schema_total_reviews = $result['total_count'];
	if($brand_schema_total_reviews==0)
	{
		$brand_schema_total_reviews = 1;
	}
?>   
<script type="application/ld+json">
	{
		"@context": "https://schema.org/",
		"@type": "LocalBusiness",
		"name": "<?php echo str_replace('"',"'",$brand['title']); ?>",
		"image": [
		"<?php echo m_image_url($brand['image']); ?>"
		 ],
		"aggregateRating": {
		"@type": "AggregateRating",
		"ratingValue": "<?php echo $brand_rating; ?>",
		"reviewCount": "<?php echo $brand_schema_total_reviews; ?>"
		}
	}
</script>
<div class="main">
<div class="container">
	<div class="row">

	
	<div class="col-xl-12 col-lg-12 col-sm-12">
	<div class="page_head">
	<div class="page_icon"><i class="fa fa-tags"></i></div>
	<div class="page_title"><h1><?php echo $brand['title']; ?> Kullanıcı Yorumları</h1> </div>
	</div>
	<?php echo m_ads('brand_header'); ?>
	<div class="brand_page">
		<div class="brand_image"><img src="<?php echo UPLOAD_URL.'/1x1.gif'; ?>" class="lazyload" width="95" height="95" data-src="<?php echo m_image_url($brand['image']); ?>" alt="<?php echo $brand['title']; ?>"></div>
		<div class="brand_detail">
		<div class="brand_name"><?php echo $brand['title']; ?></div>
		<div class="brand_rating"><i class="fa fa-star bg-warning"></i><span><?php echo $brand_rating; ?></span></div>
		<div class="brand_reviews">
		<i class="fa fa-pen-square bg-dark" data-bs-toggle="tooltip" data-bs-placement="bottom" title="İncelemeler"></i><span><?php echo m_number_format($result['total_count']); ?></span>
		</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xl-8 col-lg-8 col-sm-8 col-8">
			<div class="page_head">
			<div class="page_icon"><i class="fa fa-comments"></i></div>
			<div class="page_title"><h2>Kullananların Yorumları</h2></div>
			</div>
		</div>
		<div class="col-xl-4 col-lg-4 col-sm-4 col-4">
			<div class="sortable">
			<div class="dropdown">
				<button type="button" class="btn btn-default dropdown-toggle" data-bs-toggle="dropdown">
				  <i class="fa fa-sort"></i> <?php echo $order_title; ?>
				</button>
				<ul class="dropdown-menu">
				  <li><a href="<?php echo m_permalink('brand',$brand['sef'],$brand['id']); ?>" title="Tarihe Göre Listele" class="dropdown-item">Tarih</a></li>
				  <li><a href="<?php echo m_permalink('brand',$brand['sef'],$brand['id']); ?>/sira/puan" title="Puana Göre Listele" class="dropdown-item">Puan</a></li>
				  <li><a href="<?php echo m_permalink('brand',$brand['sef'],$brand['id']); ?>/liste" title="Ürünleri Listele" class="dropdown-item">Liste</a></li>
				</ul>
			</div>
			</div>
		</div>
	</div>
	<div class="row">
	
	
	<?php
			echo $result['html'];
	?>
	
	
	
	</div>
	<?php
	if($result['total_count']==0)
	{
		echo m_alert('Bilgi','Bu marka hakkında şuanda bir inceleme bulunmuyor, eğer markanın kullanıcıysanız bir inceleme eklemeyi deneyebilirsiniz.');
	}
	?>
	<?php
	if(m_u_g('order')=='')
	{
		echo m_pagination($result['total_page'],$result['current_page'],m_permalink('brand',$brand['sef'],$brand['id']));
	}
	else
	{
		echo m_pagination($result['total_page'],$result['current_page'],m_permalink('brand',$brand['sef'],$brand['id']).'/sira/puan');
	}
	?>
	</div>
	
	
	
	</div>
</div>
</div>
<?php
	m_footer();
?>