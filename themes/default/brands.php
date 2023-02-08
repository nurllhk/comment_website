<?php
	m_header();
	$informations = $db->query("SELECT b.*, rating, total_reviews FROM brands b LEFT JOIN ( SELECT b_id, ROUND(AVG(rate),1) as rating, COUNT(*) as total_reviews FROM reviews where status='1' GROUP BY b_id ) r ON r.b_id = b.id ORDER BY rating DESC, total_reviews DESC")->fetchAll(PDO::FETCH_ASSOC);
	$total_count = count($informations);
	$c_per_page = 24;
	$page_count = ceil($total_count/$c_per_page);
	$current_page = (integer)m_u_g(DB_PAGINATION_GET) ? (integer)m_u_g(DB_PAGINATION_GET) : 1;
	$current_limit=($current_page - 1) * $c_per_page;
	$informations = $db->query("SELECT b.*, rating, total_reviews FROM brands b LEFT JOIN ( SELECT b_id, ROUND(AVG(rate),1) as rating, COUNT(*) as total_reviews FROM reviews where status='1' GROUP BY b_id ) r ON r.b_id = b.id ORDER BY rating DESC, total_reviews DESC limit ".$current_limit.",".$c_per_page."")->fetchAll(PDO::FETCH_ASSOC);
?>   
<div class="main">
	<div class="container">
		<div class="row">

		
		<div class="col-xl-12 col-lg-12 col-sm-12">
		<div class="page_head">
		<div class="page_icon"><i class="fa fa-tags"></i></div>
		<div class="page_title"><h1>Markalar</h1></div>
		</div>
		<div class="row">
		
		<?php
		$brand_rank = $current_limit+1;
		foreach($informations as $info)
		{
			if($info['total_reviews']=='')
			{
				$info['total_reviews'] = 0;
			}
			$brand_title = $info['title'];
			$brand_image = m_image_url($info['image']);
			$brand_link = m_permalink('brand',$info['sef'],$info['id']);
			if($info['rating']=='')
			{
				$info['rating'] = '1.0';
			}
			echo '
			<div class="col-xl-4 col-lg-4 col-sm-12">
				<div class="brand_box">
							<div class="brand_image">
							<a href="'.$brand_link.'" title="'.$brand_title.'"><img src="'.UPLOAD_URL.'/1x1.gif" class="lazyload" width="95" height="95" data-src="'.$brand_image.'" title="'.$brand_title.'"></a>
							</div>
							<div class="brand_detail">
							<div class="brand_name">
							<a href="'.$brand_link.'" title="'.$brand_title.'">'.$brand_title.'</a>
							</div>
							<div class="brand_rating"><i class="fa fa-star bg-warning"></i><span>'.$info['rating'].'</span></div>
							<div class="brand_reviews"><i class="fa fa-pen-square bg-dark"></i><span>'.number_format($info['total_reviews'],0,',','.').' İnceleme</span></div>
							</div>
					';
					if($brand_rank<11)
					{
					echo '
					<div class="brand_rank">'.$brand_rank.'</div>';
					}
					echo'
				</div>
			</div>';
			$brand_rank++;
		}
		?>
		
		
		
		</div>
		
		<?php
			echo m_pagination($page_count,$current_page,m_permalink('brands'));
		?>
		
		</div>
		
		
		
		</div>
	</div>
</div>

<?php
	m_footer();
?>