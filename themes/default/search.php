<?php
	m_header();
	if(mb_strlen(m_a_g('q'),'UTF-8')<3)
	{
		m_redirect(SITE_DOMAIN);
	}
?>   
<div class="main">
<div class="container">
	<div class="row">

	
	<div class="col-xl-12 col-lg-12 col-sm-12">
	<div class="page_head">
	<div class="page_icon"><i class="fa fa-search"></i></div>
	<div class="page_title"><h1>Arama Sonuçları</h1></div>
	</div>
	<div class="row">
	
	<?php
			$review_list = new m_review();
			$review_list->template 					= 'default';
			$review_list->template_col 				= 'col-xl-4 col-lg-4 col-sm-12';
			$review_list->query_options 			= "where title LIKE '%".m_u_g('q')."%' and status='1'";
			$review_list->order 					= "order by id desc";
			$review_list->paginate 					= 24;
			$result = $review_list->list_products();
			echo $result['html'];
	?>
	
	
	
	</div>
	<?php
	if($result['count']==0)
	{
		echo m_alert('Bilgi','Bu arama için şuanda bir ürün bulunmuyor.');
	}
	?>
	</div>
	<?php echo m_pagination($result['total_page'],$result['current_page'],m_permalink('search_q',m_u_g('q'))); ?>  
	
	
	</div>
</div>
</div>
<?php
	m_footer();
?>