<?php
	m_header();
	$products = $db->table('products')->where('id','=',m_u_g('id'))->where('sef','=',m_u_g('sef'))->where('status','=',1)->get();
	if($products['total_count']=='0')
	{
		m_redirect(SITE_DOMAIN);
	}
	$product = $products['data'][0];
	$product_rating = $db->select('ROUND(AVG(rate),1) as rating')->table('reviews')->where('status','=',1)->where('p_id','=',$product['id'])->get();
	$product_rating = $product_rating['data'][0]['rating'];
	$product_price_rating = $db->select('ROUND(AVG(price_rate)) as price_rating')->table('reviews')->where('status','=',1)->where('p_id','=',$product['id'])->get();
	$product_price_rating = $product_price_rating['data'][0]['price_rating'];
	$review_list = new m_review();
	$review_list->template 					= 'default';
	$review_list->template_col 				= 'col-xl-4 col-lg-4 col-sm-12';
	$review_list->include_user 				= true;
	$review_list->query_options 			= "where r.p_id='".$product['id']."' and r.status='1'";
	$review_list->order 					= "order by r.date desc";
	$review_list->paginate 					= 12;
	$result = $review_list->list_reviews();
	$product_schema_total_reviews = $result['total_count'];
	if($product_schema_total_reviews==0)
	{
		$product_schema_total_reviews = 1;
	}
	if($product_rating=='')
	{
		$product_rating = '1.0';
	}
	if($product_price_rating=='')
	{
		$product_price_rating = '<i class="fa fa-question-circle text-info"></i>';
	}
	else
	{
		if($product_price_rating==1)
		{
			$product_price_rating = '<i class="fa fa-thumbs-up text-success"></i>';
		}
		else
		{
			$product_price_rating = '<i class="fa fa-thumbs-down text-danger"></i>';
		}
	}
	
	$product_brand = $db->table('brands')->where('id','=',$product['b_id'])->get_vars();
	$product_category = m_review::product_last_category($product['c_id']);
	$db->query("update products set views=views+1 where id='".$product['id']."'");
?>

<script type="application/ld+json">
	{
		"@context": "https://schema.org/",
		"@type": "Product",
		"name": "<?php echo str_replace('"',"'",$product['title']); ?>",
		"image": [
		"<?php echo m_image_url($product['image']); ?>"
		],
		
		<?php
		if($product_brand['title']=='')
		{
		?>
		
		<?php
		}
		else
		{
		?>
		"brand": {
		"@type": "Brand",
		"name": "<?php echo $product_brand['title']; ?>"
		},
		
		<?php
		}
		?>
		
		"aggregateRating": {
		"@type": "AggregateRating",
		"ratingValue": "<?php echo $product_rating; ?>",
		"reviewCount": "<?php echo $product_schema_total_reviews; ?>"
		}
	}
</script>
<div class="main">
<div class="container">
	<div class="row">

	
	<div class="col-xl-12 col-lg-12 col-sm-12">
	<div class="page_head">
	<div class="page_icon"><i class="fa fa-shopping-cart"></i></div>
	<div class="page_title"><h1><?php echo $product['title']; ?></h1></div>
	</div>
	<?php echo m_ads('brand_header'); ?>
	<div class="product_page">
		<div class="row">
		<div class="col-xl-4 col-lg-4 col-sm-12 col-12">
		<div class="product_image"><img src="<?php echo UPLOAD_URL.'/1x1.gif'; ?>" class="lazyload" width="213" height="213" data-src="<?php echo m_image_url($product['image']); ?>" title="<?php echo $product['title']; ?>"></div>
		</div>
		<div class="col-xl-8 col-lg-8 col-sm-12 col-12">
		<div class="product_detail">
		<div class="product_name"><?php echo $product['title']; ?></div>
		<div class="product_category">
		<i class="fa fa-info-circle bg-info" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Kategori"></i>
		<a href="<?php echo $product_category['link']; ?>" title="<?php echo $product_category['title']; ?>"><?php echo $product_category['title']; ?></a>
		</div>
		<?php
		if($product_brand['title']!='')
		{
		?>
		<div class="product_brand">
		<i class="fa fa-tags bg-info" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Marka"></i>
		<a href="<?php echo m_permalink('brand',$product_brand['sef'],$product_brand['id']); ?>" title="<?php echo $product_brand['title']; ?>"><?php echo $product_brand['title']; ?></a>
		</div>
		<?php
		}
		?>
		<div class="product_rating">
		<i class="fa fa-star bg-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Puan"></i><span><?php echo $product_rating; ?></span>
		</div>
		<div class="product_true_price">
		<i class="fa fa-search-dollar bg-success" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Fiyat / Performans"></i><span><?php echo $product_price_rating; ?></span>
		</div>
		<div class="product_reviews">
		<i class="fa fa-pen-square bg-dark" data-bs-toggle="tooltip" data-bs-placement="bottom" title="İncelemeler"></i><span><?php echo m_number_format($result['total_count']); ?></span>
		</div>
		<a href="<?php echo m_permalink('add_review_detail',$product['id']); ?>" title="İnceleme Ekle"><span class="btn btn-default btn-sm"><i class="fa fa-pen-square"></i> İnceleme Ekle</a>
		</div>
		</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-sm-8 col-12">
			<div class="page_head">
			<div class="page_icon"><i class="fa fa-comments"></i></div>
			<div class="page_title"><h2><?php echo $product['title']; ?> Yorumları</h2></div>
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
		echo m_alert('Bilgi','Bu ürün için şuanda bir inceleme bulunmuyor.');
	}
	?>
	</div>
	<?php
		echo m_pagination($result['total_page'],$result['current_page'],m_permalink('product',$product['sef'],$product['id']));
	?>
	
	
	
	</div>
</div>
</div>
<?php
	m_footer();
?>
					