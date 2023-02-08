<?php
	m_header();
	$categories = $db->table('categories')->where('id','=',m_u_g('id'))->where('sef','=',m_u_g('sef'))->where('status','=',1)->get();
	if($categories['total_count']=='0')
	{
		m_redirect(SITE_DOMAIN);
	}
	$category = $categories['data'][0];
	$order_title = 'Liste';
?>   
<div class="main">
<div class="container">
	<div class="row">

	
	<div class="col-xl-12 col-lg-12 col-sm-12">
	<div class="page_head">
	<div class="page_icon"><i class="fa fa-list"></i></div>
	<div class="page_title"><h1><?php if($category['c_id']!=0) { echo $db->table('categories')->where('id','=',$category['c_id'])->get_var('title').' - '; } ?><?php echo $category['title']; ?> Ürün Listesi</h1></div>
	</div>
	<?php echo m_ads('brand_header'); ?>
	<div class="row">
		
		<div class="col-xl-7 col-lg-7 col-sm-7 col-7">
		<?php
		$informations = $db->table('categories')->where('c_id','=',$category['id'])->where('status','=',1)->order('title','asc')->get();
		if($informations['total_count']>0)
		{
		?>
			<div class="product_sub_categories">
			<div class="dropdown">
				<button type="button" class="btn btn-default dropdown-toggle" data-bs-toggle="dropdown">
				  <i class="fa fa-ellipsis-v"></i> Alt Kategoriler
				</button>
				<ul class="dropdown-menu">
				  <?php
					foreach($informations['data'] as $info)
					{
				  ?>
					<li><a href="<?php echo m_permalink('category',$info['sef'],$info['id']); ?>" title="<?php echo $info['title']; ?>" class="dropdown-item"><?php echo $info['title']; ?></a></li>
				  <?php
					}
				  ?>
				</ul>
			</div>
			</div>
		<?php
		}
		?>
		</div>
		<div class="col-xl-5 col-lg-5 col-sm-5 col-5">
			<div class="sortable">
			<div class="dropdown">
				<button type="button" class="btn btn-default dropdown-toggle" data-bs-toggle="dropdown">
				  <i class="fa fa-sort"></i> <?php echo $order_title; ?>
				</button>
				<ul class="dropdown-menu">
				  <li><a href="<?php echo m_permalink('category',$category['sef'],$category['id']); ?>" title="Tarihe Göre Listele" class="dropdown-item">Tarih</a></li>
				  <li><a href="<?php echo m_permalink('category',$category['sef'],$category['id']); ?>/sira/puan" title="Puana Göre Listele" class="dropdown-item">Puan</a></li>
				  <li><a href="<?php echo m_permalink('category',$category['sef'],$category['id']); ?>/liste" title="Ürünleri Listele" class="dropdown-item">Liste</a></li>
				</ul>
			</div>
			</div>
		</div>
	</div>
	<div class="row">
	
	<?php
			$review_list = new m_review();
			$review_list->template 					= 'default';
			$review_list->template_col 				= 'col-xl-4 col-lg-4 col-sm-12';
			$review_list->query_options 			= "where c_id LIKE '%[".$category['id']."]%' and status='1'";
			$review_list->order 					= "order by id desc";
			$review_list->paginate 					= 24;
			$result = $review_list->list_products();
			echo $result['html'];
	?>
	
	
	
	</div>
	<?php
	if($result['count']==0)
	{
		echo m_alert('Bilgi','Bu kategori için şuanda bir ürün bulunmuyor.');
	}
	?>
	</div>
	<?php
		echo m_pagination($result['total_page'],$result['current_page'],m_permalink('category',$category['sef'],$category['id']).'/liste');
	?>
	<?php
	if($category['seo_content']!='')
	{
	?>
	<div class="col-xl-12 col-lg-12 col-sm-12">
		<div class="list-group mb-5">
			<div class="list-group-item">
			<?php echo $category['seo_content']; ?>
			</div>
		</div>
	</div>
	<?php
	}
	?>
	
	
	
	</div>
</div>
</div>
<?php
	m_footer();
?>