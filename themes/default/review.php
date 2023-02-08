<?php
	m_header();
	$reviews = $db->table('reviews')->where('id','=',m_u_g('id'))->where('sef','=',m_u_g('sef'))->where('status','=',1)->get();
	if($reviews['total_count']=='0')
	{
		m_redirect(SITE_DOMAIN);
	}
	$review = $reviews['data'][0];
	$product = $db->table('products')->where('id','=',$review['p_id'])->get_vars();
	$product_total_reviews = $db->table('reviews')->where('status','=',1)->where('p_id','=',$review['p_id'])->count();
	$product_schema_total_reviews = $product_total_reviews;
	$product_rating = $db->select('ROUND(AVG(rate),1) as rating')->table('reviews')->where('p_id','=',$review['p_id'])->get();
	$product_rating = $product_rating['data'][0]['rating'];
	$product_price_rating = $db->select('ROUND(AVG(price_rate)) as price_rating')->table('reviews')->where('status','=',1)->where('p_id','=',$product['id'])->get();
	$product_price_rating = $product_price_rating['data'][0]['price_rating'];
	$product_brand = $db->table('brands')->where('id','=',$product['b_id'])->get_vars();
	$product_category = m_review::product_last_category($product['c_id']);
	$user = $db->table('users')->where('id','=',$review['u_id'])->get_vars();
	$user_status = m_user_status($user['last_login']);
	$db->query("update products set views=views+1 where id='".$product['id']."'");
	$comments = $db->table('comments')->where('r_id','=',$review['id'])->where('status','=',1)->order('id','asc')->get();
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
      "review": {
        "@type": "Review",
        "reviewRating": {
          "@type": "Rating",
          "ratingValue": "<?php echo $review['rate']; ?>",
          "bestRating": "5"
        },
        "author": {
          "@type": "Person",
          "name": "<?php echo $user['username']; ?>"
        },
        "datePublished":"<?php echo date('c', strtotime($review['date'])); ?>",
        "headline":"<?php echo str_replace('"',"'",$review['title']); ?>",
        "reviewBody":"<?php echo review_body_schema($review['content']); ?>",
        "publisher":{
           "@type":"Organization",
           "name":"Açıklıyorum",
           "sameAs":"<?php echo SITE_DOMAIN; ?>"
        },
        "inLanguage":"tr"
      },
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
	<div class="page_icon"><i class="fa fa-pen-square"></i></div>
	<div class="page_title"><h1><?php echo $review['title']; ?></h1></div>
	</div>
	<div class="row">
	
	
	<div class="col-xl-12 col-lg-12 col-sm-12">
	<div class="product_page mb-3">
		<div class="row">
		<div class="col-xl-4 col-lg-4 col-sm-12 col-12">
		<div class="product_image"><a href="<?php echo m_permalink('product',$product['sef'],$product['id']); ?>" title="<?php echo $product['title']; ?>"><img src="<?php echo UPLOAD_URL.'/1x1.gif'; ?>" class="lazyload" width="213" height="213" data-src="<?php echo m_image_url($product['image']); ?>" title="<?php echo $product['title']; ?>"></a></div>
		</div>
		<div class="col-xl-8 col-lg-8 col-sm-12 col-12">
		<div class="product_detail">
		<div class="product_name"><h2><a href="<?php echo m_permalink('product',$product['sef'],$product['id']); ?>" title="<?php echo $product['title']; ?>"><?php echo $product['title']; ?></a></h2></div>
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
		<i class="fa fa-pen-square bg-dark" data-bs-toggle="tooltip" data-bs-placement="bottom" title="İncelemeler"></i><span><?php echo m_number_format($product_total_reviews); ?></span>
		</div>
		</div>
		</div>
		</div>
	</div>
	
	
		
	<div class="review_box review_detail">
		<div class="user">
				<div class="user_image">
				<a href="<?php echo m_permalink('user_profile',$user['sef'],$user['id']); ?>" title="<?php echo $user['username']; ?>"><img src="<?php echo UPLOAD_URL.'/1x1.gif'; ?>" class="lazyload" width="40" height="40" data-src="<?php echo m_user_avatar($user['gender'],$user['avatar'],true); ?>" alt="<?php echo $user['username']; ?>"></a>
				<div class="user_status <?php echo $user_status; ?>"></div>
				</div>
				<div class="user_name">
				<a href="<?php echo m_permalink('user_profile',$user['sef'],$user['id']); ?>" title="<?php echo $user['username']; ?>"><?php echo $user['username']; ?></a>
				<?php echo m_user_level($user['user_level'],'icon'); ?>
				</div>
				<div class="date"><?php echo m_time_ago($review['date']); ?></div>
		</div>
		
		<?php echo m_ads('review_page'); ?>
		
		<div class="review">
				<div class="review_title">
				<h3><?php echo $review['title']; ?></h3>
				</div>
				<div class="review_content mb-3">
				<?php 
				  $review_content = preg_replace('#<span style="(.*?)"#si','<span ',$review['content']);
				  $review_content = preg_replace('#<p style="(.*?)"#si','<p ',$review_content);
				  $review_content = preg_replace('#<img src="(.*?)"(.*?)>#si','<a href="$1" data-fancybox="group_'.$review['id'].'" title="'.$review['title'].'"><img src="'.UPLOAD_URL.'/1x1.gif" alt="'.$review['title'].'" class="lazyload" data-src="$1"$2></a> ',$review_content);
				  
				  echo $review_content; 
				
				?>
				</div>
		</div>
		<div class="review_meta">
			<?php
			if($review['recommend']==1)
			{
				$r_color = 'fa-thumbs-up text-success';
				$r_title = 'tavsiye ediyor';
			}
			else
			{
				$r_color = 'fa-thumbs-down text-danger';
				$r_title = 'tavsiye etmiyor';
			}
			if($review['price_rate']==1)
			{
				$pr_color = 'fa-thumbs-up text-success';
			}
			else
			{
				$pr_color = 'fa-thumbs-down text-danger';
			}
			?>
			<div class="rate">
            <i class="fa fa-star text-warning"></i>
            <div><?php echo $review['rate']; ?>.0</div>
			</div>
			<div class="recommend">
            <i class="fa <?php echo $r_color; ?>"></i>
            <div><?php echo $r_title; ?></div>
			</div>
			<div class="true_price">
            <i class="fa <?php echo $pr_color; ?>"></i>
            <div>fiyat / performans</div>
			</div>
		</div>
		<div class="review_footer">
				<div class="review_like" data-id="<?php echo $review['id']; ?>"><i class="fa fa-thumbs-up bg-success"></i><span><?php echo m_number_format($review['liked']); ?></span></div>
				<div class="review_comments"><i class="fa fa-comments bg-primary"></i><span><?php echo m_number_format($comments['total_count']); ?></span></div>
				<div class="review_dislike" data-id="<?php echo $review['id']; ?>"><i class="fa fa-thumbs-down bg-danger"></i><span><?php echo m_number_format($review['unliked']); ?></span></div>
		</div>
		</div>
		</div>
		
		
		<div class="col-xl-12 col-lg-12 col-sm-12">
		
		<?php echo m_ads('review_page'); ?>
		
		

		
		
		<div class="page_head">
		     
				<div class="page_icon"><i class="fa fa-comments"></i></div>
				<div class="page_title"><h4>Yorumlar</h4></div>
		</div>
		<div class="review_comments_list">
			<?php
			if($comments['total_count']>0)
			{
				
				foreach($comments['data'] as $comment)
				{
					if($comment['answered_u_id']==0)
					{
						$comment_answered_user = '';
					}
					else
					{
						$comment_answered_user = '<b>@'.m_user('username',$comment['answered_u_id']).' adlı kullanıcıya cevaben;</b> <br><br>';
					}
					$c_user = $db->table('users')->where('id','=',$comment['u_id'])->get_vars();
					$c_user_status = m_user_status($c_user['last_login']);
					echo '
				  <div id="review_comment_'.$comment['id'].'" class="review_comment">
					<div class="user">
					<div class="user_image">
					<a href="'.m_permalink('user_profile',$c_user['sef'],$c_user['id']).'" title="'.$c_user['username'].'"><img class="lazyload" width="40" height="40" data-src="'.m_user_avatar($c_user['gender'],$c_user['avatar'],true).'" alt="'.$c_user['username'].'"></a>
					<div class="user_status '.$c_user_status.'"></div>
					</div>
					<div class="user_name">
					<a href="'.m_permalink('user_profile',$c_user['sef'],$c_user['id']).'" title="'.$c_user['username'].'">'.$c_user['username'].'</a>
					'.m_user_level($c_user['user_level'],'icon').'
					</div>
					<div class="date">
					'.m_time_ago($comment['date']).'
					</div>
					</div>
					<div class="comment">
					<p>'.$comment_answered_user.' '.$comment['content'].'</p>
					</div>
					<div class="comment_actions">
					<span class="comment_like" data-id="'.$comment['id'].'"><i class="fa fa-thumbs-up text-success"></i> <span class="total">'.$comment['liked'].'</span></span> 
					<span class="comment_dislike" data-id="'.$comment['id'].'"><i class="fa fa-thumbs-down text-danger"></i> <span class="total">'.$comment['unliked'].'</span></span> 
					<span class="comment_reply" data-answered-user="'.$c_user['id'].'" data-answered-username="'.$c_user['username'].'"><i class="fa fa-reply text-primary"></i> Cevapla</span> 
					</div>
				</div>';
				}
			}
			if($comments['total_count']==0)
			{
				echo '<div class="p-3">'.m_alert('Bilgi','Bu inceleme hakkında yorum bulunmuyor.').'</div>';
			}
			?>
				<form action="#write_comment" id="add_comment" method="post">
				   
				<div class="write_comment">
					<?php
					if(m_user_check())
					{
					?>
					<input type="hidden" name="type" value="add_comment">
					<input type="hidden" name="r_id" value="<?php echo $review['id']; ?>">
					<input type="hidden" name="answered_u_id" class="answered_u_id" value="0">
					<textarea class="form-control comment_textarea" name="content" placeholder="Bu inceleme hakkında ne düşünüyorsunuz ?"></textarea>
					<button type="submit" class="btn btn-default btn-sm"><i class="fa fa-paper-plane"></i> Gönder</button>
					
					<?php
					}
					else
					{
					?>
					<textarea class="form-control" name="comment" placeholder="Yorum yazmak için üye olmanız gerekmekte, lütfen giriş yapınız."></textarea>
					<?php
					}
					?>
				</div>
				</form>
				
		</div>
		</div>
		
		<div class="col-xl-12 col-lg-12 col-sm-12">
		
		<div class="page_head">
				<div class="page_icon"><i class="fa fa-th-large"></i></div>
				<div class="page_title"><h5>Diğer Kullananların Yorumları</h5></div>
		</div>
		<div class="row">
			
			
			<?php
			$review_list = new m_review();
			$review_list->template 					= 'default';
			$review_list->template_col 				= 'col-xl-4 col-lg-4 col-sm-12';
			$review_list->include_user 				= true;
			$review_list->query_options 			= "where r.p_id='".$review['p_id']."' and r.id!='".$review['id']."' and r.status='1'";
			$review_list->order 					= "order by r_date desc";
			$review_list->limit 					= 3;
			$result = $review_list->list_reviews();
			echo $result['html'];
			?>
			
			
			
		</div>
		<?php
		if($result['count']==0)
		{
			echo m_alert('Bilgi','Bu ürün için farklı bir inceleme bulunmuyor.');
		}
		?>
		
		</div>
		
		
	
	
	
	</div>
	</div>
	
	
	
	</div>
</div>
</div>
	
<?php
	m_footer();
?>
