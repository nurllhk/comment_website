<?php
	m_header();
	if(m_u_g('type')=='positive')
	{
		$title = 'En Olumlu İncelemeler';
		$order = 'desc';
		$url = 'olumlu-incelemeler';
		$type = 'positive';
		$order_where = "rate>3";
		$icon = 'fa-thumbs-up';
	}
	else
	{
		$title = 'En Olumsuz İncelemeler';
		$order = 'asc';
		$url = 'olumsuz-incelemeler';
		$type = 'negative';
		$order_where = "rate<3";
		$icon = 'fa-thumbs-down';
	}
?>   
<div class="main">
<div class="container">
	<div class="row">

	
	<div class="col-xl-12 col-lg-12 col-sm-12">
	<div class="page_head">
	<div class="page_icon"><i class="fa <?php echo $icon; ?>"></i></div>
	<div class="page_title"><h1><?php echo $title; ?></h1></div>
	</div>
	<div class="row">
	  
	
	<?php
			$review_list = new m_review();
			$review_list->template 					= 'default';
			$review_list->template_col 				= 'col-xl-4 col-lg-4 col-sm-12';
			$review_list->include_user 				= true;
			$review_list->include_product 			= true;
			$review_list->query_options 			= "where $order_where and r.status='1'";
			$review_list->order 					= "order by date desc";
			$review_list->paginate 					= 12;
			$result = $review_list->list_reviews();
			echo $result['html'];
	?>
	
	
	
	</div>
	<?php
	if($result['count']==0)
	{
		echo m_alert('Bilgi','Şuanda bir inceleme bulunmuyor.');
	}
	?>
	</div>
	<?php
		echo m_pagination($result['total_page'],$result['current_page'],m_permalink('pn_reviews',$url));
	?>
	
	
	</div>
</div>
</div>
<?php
	m_footer();
?>