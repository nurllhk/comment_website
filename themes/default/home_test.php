<?php
m_header();
?>  
<div class="main">
		<div class="container">
			
			<div class="row">
			<div class="col-xl-12 col-lg-12 col-sm-12">
			<div class="product_categories_list">
			<div class="product_categories">
				<?php
				$informations = $db->table('categories')->where('status','=',1)->where('c_id','=',0)->order('rank','asc')->get();
				foreach($informations['data'] as $info)
				{
					echo '
					<div class="category">
						<div class="category_image"><a href="'.m_permalink('category',$info['sef'],$info['id']).'" title="'.$info['title'].'"><img src="'.UPLOAD_URL.'/1x1.gif" class="lazyload" width="64" height="64" data-src="'.m_image_url($info['image']).'" alt="'.$info['title'].'"></a></div>
						<div class="category_name"><a href="'.m_permalink('category',$info['sef'],$info['id']).'" title="'.$info['title'].'">'.$info['title'].'</a></div>
					</div>';
				}
				?>
			</div>
			<div class="product_categories_prev"><i class="fa fa-angle-left"></i></div>
			<div class="product_categories_next"><i class="fa fa-angle-right"></i></div>
			</div>
			
			
			
			</div>
			</div>
			
			<div class="page_head">
			<div class="page_icon"><i class="fa fa-star"></i></div>
			<div class="page_title"><h1>Kullanıcı Yorumları</h1></div>
			</div>
			
			
			<div class="row">
			
			<?php
			$review_list = new m_review();
			$review_list->template 					= 'default';
			$review_list->template_col 				= 'col-xl-4 col-lg-4 col-sm-12';
			$review_list->include_user 				= true;
			$review_list->include_product 			= true;
			$review_list->query_options 			= "where r.home_view='1' and r.status='1'";
			$review_list->order 					= "order by r_date desc";
			$review_list->limit 					= 2;
			$result = $review_list->list_reviews();
			echo $result['html'];
			?>
			
			
			
			<div class="col-xl-4 col-lg-4 col-sm-12">
			<div class="page_head">
			<div class="page_icon"><i class="fa fa-shopping-cart"></i></div>
			<div class="page_title">Haftanın Ürünü</div>
			</div>
			<div class="reviews_summary mt-3 mb-25">
				<?php
				$informations = $db->table('products')->where('id','=',m_setting('week_product'))->get();
				foreach($informations['data'] as $info)
				{
					$product_title = $info['title'];
					$product_link = m_permalink('product',$info['sef'],$info['id']);
					$product_category = m_review::product_last_category($info['c_id']);
					$product_image = m_image_url($info['image']);
					$product_rating = $db->select('ROUND(AVG(rate),1) as rating')->table('reviews')->where('status','=',1)->where('p_id','=',$info['id'])->get();
					$product_rating = $product_rating['data'][0]['rating'];
					if($product_rating=='')
					{
						$product_rating = '1.0';
					}
					echo '
					<div class="product">
					<div class="product_image">
					<a href="'.$product_link.'" title="'.$product_title.'"><img src="'.UPLOAD_URL.'/1x1.gif" class="lazyload" width="60" height="60" data-src="'.$product_image.'" alt="'.$product_title.'"></a>
					</div>
					<div class="product_detail">
					<div class="product_name">
					<a href="'.$product_link.'" title="'.$product_title.'">'.$product_title.'</a>
					</div>
					<div class="product_category"><i class="fa fa-info-circle bg-info"></i><a href="'.$product_category['link'].'" title="'.$product_category['title'].'">'.$product_category['title'].'</a></div>
					<div class="product_rating"><i class="fa fa-star bg-warning"></i><span>'.$product_rating.'</span></div>
					</div>
					</div>';
				}
				?>
			</div>
			<div class="page_head">
			<div class="page_icon"><i class="fa fa-tags"></i></div>
			<div class="page_title">Haftanın Markası</div>
			</div>
			<div class="reviews_summary mt-3 mb-25">
				<?php
				$informations = $db->table('brands')->where('id','=',m_setting('week_brand'))->get();
				foreach($informations['data'] as $info)
				{
					$brand_title = $info['title'];
					$brand_link = m_permalink('brand',$info['sef'],$info['id']);
					$brand_image = m_image_url($info['image']);
					$brand_rating = $db->select('ROUND(AVG(rate),1) as rating')->table('reviews')->where('status','=',1)->where('b_id','=',$info['id'])->get();
					$brand_rating = $brand_rating['data'][0]['rating'];
					if($brand_rating=='')
					{
						$brand_rating = '1.0';
					}
	
					echo '
					<div class="brand">
					<div class="brand_image">
					<a href="'.$brand_link.'" title="'.$brand_title.'"><img src="'.UPLOAD_URL.'/1x1.gif" class="lazyload" width="95" height="95" data-src="'.$brand_image.'" alt="'.$brand_title.'"></a>
					</div>
					<div class="brand_detail">
					<div class="brand_name">
					<a href="'.$brand_link.'" title="'.$brand_title.'">'.$brand_title.'</a>
					</div>
					<div class="brand_rating"><i class="fa fa-star bg-warning"></i><span>'.$brand_rating.'</span></div>
					</div>
					</div>';
				}
				?>
			</div>
			<div class="page_head">
			<div class="page_icon"><i class="fa fa-star"></i></div>
			<div class="page_title">Haftanın Yazarı</div>
			</div>
			<div class="reviews_summary mt-3 mb-25">
				<?php
				$informations = $db->table('users')->where('id','=',m_setting('week_user'))->get();
				foreach($informations['data'] as $info)
				{
					$username = $info['username'];
					$user_link = m_permalink('user_profile',$info['sef'],$info['id']);
					$user_image = m_user_avatar($info['gender'],$info['avatar'],true);
					$user_status = m_user_status($info['last_login']);
					$user_level = m_user_level($info['user_level'],'icon');
					
					echo '
					<div class="user">
					<div class="user_image">
					<a href="'.$user_link.'" title="'.$username.'"><img src="'.UPLOAD_URL.'/1x1.gif" class="lazyload" width="40" height="40" data-src="'.$user_image.'" alt="'.$username.'"></a>
					<div class="user_status '.$user_status.'"></div>
					</div>
					<div class="user_name">
					<a href="'.$user_link.'" title="'.$username.'">'.$username.'</a>
					'.$user_level.'
					</div>
					</div>';
				}
				?>
			</div>
			</div>
			</div>
			
			<div class="row mt-2">
			<?php
			$review_list = new m_review();
			$review_list->template 					= 'default';
			$review_list->template_col 				= 'col-xl-4 col-lg-4 col-sm-12';
			$review_list->include_user 				= true;
			$review_list->include_product 			= true;
			$review_list->query_options 			= "where r.home_view='1' and r.status='1'";
			$review_list->order 					= "order by r_date desc";
			$review_list->limit 					= '2,6';
			$result = $review_list->list_reviews();
			echo $result['html'];
			?>
			</div>
			
			<div class="page_head">
			<div class="page_icon"><i class="fa fa-comments"></i></div>
			<div class="page_title"><h2>Bu Ay En Çok Tartışılan İncelemeler</h2></div>
			</div>
			
			
			<div class="row">
			
			<?php
			$review_list = new m_review();
			$review_list->template 					= 'default';
			$review_list->template_col 				= 'col-xl-4 col-lg-4 col-sm-12';
			$review_list->include_user 				= true;
			$review_list->include_product 			= true;
			$review_list->query_options 			= "where r.status='1'";
			$review_list->order 					= "order by r_month_comment_count desc, r_liked desc";
			$review_list->limit 					= 2;
			$result = $review_list->list_reviews();
			echo $result['html'];
			?>
			
			
			
			<div class="col-xl-4 col-lg-4 col-sm-12">
			<?php
			$informations = $db->query("select
			u.gender as u_gender,
			u.avatar as u_avatar,
			u.last_login as u_last_login,
			u.username as u_username,
			u.user_level as u_user_level,
			u.id as u_id,
			r.id as r_id,
			r.sef as r_sef,
			c.id as c_id,
			c.date as c_date,
			c.content as c_content
			from comments c
			inner join reviews r 
			on r.id=c.r_id
			inner join users u
			on u.id=c.u_id
			where c.status='1' order by c.id desc limit 3")->fetchAll(PDO::FETCH_ASSOC);
			foreach($informations as $info)
			{
				$username = $info['u_username'];
				$review_link = m_permalink('review',$info['r_sef'],$info['r_id']);
				$user_link = m_permalink('user_profile',$info['u_sef'],$info['u_id']);
				$user_image = m_user_avatar($info['u_gender'],$info['u_avatar'],true);
				$user_status = m_user_status($info['u_last_login']);
				$user_level = m_user_level($info['u_user_level'],'icon');
				$comment = $info['c_content'];
				if(mb_strlen($comment,'UTF-8')>50)
				{
					$comment = mb_substr($comment,0,50,'UTF-8').'...';
				}
				$comment_id = $info['c_id'];
			?>
			<div class="comment_summary">
				
					<div class="user">
					<div class="user_image">
					<a href="<?php echo $user_link; ?>" title="<?php echo $username; ?>"><img src="<?php echo UPLOAD_URL; ?>/1x1.gif" class="lazyload" width="40" height="40" data-src="<?php echo $user_image; ?>" alt="<?php echo $username; ?>"></a>
					<div class="user_status <?php echo $user_status; ?>"></div>
					</div>
					<div class="user_name">
					<a href="<?php echo $user_link; ?>" title="<?php echo $username; ?>"><?php echo $username; ?></a>
					<?php echo $user_level; ?>
					</div>
					</div>
					<div class="comment">
						<?php echo $comment; ?>
					</div>
					<a href="<?php echo $review_link; ?>#review_comment_<?php echo $comment_id; ?>" class="read_more"><i class="fa fa-eye me-2"></i> İncelemeyi ve Yorumu Görüntüle</a>
			</div>
			<?php
			}
			?>
			
			</div>
			
			<?php
			$review_list = new m_review();
			$review_list->template 					= 'default';
			$review_list->template_col 				= 'col-xl-4 col-lg-4 col-sm-12';
			$review_list->include_user 				= true;
			$review_list->include_product 			= true;
			$review_list->query_options 			= "where r.status='1'";
			$review_list->order 					= "order by r_month_comment_count desc, r_liked desc";
			$review_list->limit 					= '2,3';
			$result = $review_list->list_reviews();
			echo $result['html'];
			?>
			
			</div>
			
			
			
			
			
			<div class="page_head">
			<div class="page_icon"><i class="fa fa-clock"></i></div>
			<div class="page_title"><h3>Son Eklenen İncelemeler</h3></div>
			</div>
			<div class="row">
			
			
			
			<?php
			$review_list = new m_review();
			$review_list->template 					= 'default';
			$review_list->template_col 				= 'col-xl-4 col-lg-4 col-sm-12';
			$review_list->include_user 				= true;
			$review_list->include_product 			= true;
			$review_list->query_options 			= "where r.home_view!='1' and r.status='1'";
			$review_list->order 					= "order by r_date desc";
			$review_list->limit 					= 12;
			$result = $review_list->list_reviews();
			echo $result['html'];
			?>
			
			
			
			</div>
			<div class="row">
			<div class="col-xl-12 col-lg-12 col-sm-12">
			<div class="row other_reviews mb-3"></div>
			<a href="javascript:void(0);"><span class="btn btn-default btn-sm w-100 mb-3 other_reviews_btn" data-page="2"><i class="fa fa-ellipsis-h"></i> Daha fazla göster</span></a>
			</div>
			<?php
			$seo_content = m_setting('home_seo_content');
			if($seo_content!='')
			{
			?>
			<div class="col-xl-12 col-lg-12 col-sm-12">
				<div class="list-group mb-5">
					<div class="list-group-item">
					<?php echo $seo_content; ?>
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
