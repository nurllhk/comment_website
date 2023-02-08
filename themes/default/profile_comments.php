<?php
m_header();
$users = $db->table('users')->where('id','=',m_u_g('id'))->where('sef','=',m_u_g('sef'))->where('status','=',1)->get();
if($users['total_count']=='0')
{
	m_redirect(SITE_DOMAIN);
}
$user = $users['data'][0];
$username = $user['username'];
$user_link = m_permalink('user_profile',$user['sef'],$user['id']);
$user_image = m_user_avatar($user['gender'],$user['avatar'],true);
$user_status = m_user_status($user['last_login']);
$user_rank = m_user_level($user['user_level'],'icon');
$user_total_reviews = $db->table('reviews')->where('u_id','=',m_u_g('id'))->where('status','=',1)->count();
$comment_list = new m_review();
$result = $comment_list->list_user_reviews_comments($user['id']);
?>  
<div class="main">
<div class="container">
	<div class="row">

	
	<div class="col-xl-12 col-lg-12 col-sm-12">
	<div class="page_head">
	<div class="page_icon"><i class="fa fa-user"></i></div>
	<div class="page_title"><h1><?php echo $user['username']; ?></h1></div>
	</div>
	<?php echo m_ads('brand_header'); ?>
	<div class="user_box">
					<div class="user">
					<div class="user_image">
					<img src="<?php echo UPLOAD_URL.'/1x1.gif'; ?>" class="lazyload" width="40" height="40" data-src="<?php echo $user_image; ?>" alt="<?php echo $user['username']; ?>">
					<div class="user_status <?php echo $user_status; ?>"></div>
					</div>
					<div class="user_name">
					<?php echo $user['username']; ?>
					<?php echo $user_rank; ?>
					</div>
					</div>
					<div class="user_detail">
						<div class="user_detail_info">
						<i class="fa fa-calendar bg-info" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Katılım Zamanı"></i> <span><?php echo m_time_ago($user['register_date']) ?></span>
						</div>
						<div class="user_detail_info">
						<i class="fa fa-street-view bg-success" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Son Aktivite"></i> <span> <?php echo m_time_ago($user['last_login']) ?></span>
						</div>
						<div class="user_detail_info">
						<i class="fa fa-pen-square bg-dark" data-bs-toggle="tooltip" data-bs-placement="bottom" title="İncelemeler"></i> <span><?php echo m_number_format($user_total_reviews) ?></span>
						</div>
						
						<div class="user_actions">
						
							<?php echo friendship::user_profile_actions($user['id']); ?>
						
						</div>

					</div>
	</div>
	
	<ul class="user_static_tabs">
	  <li class="user_static_tabs_link active">
		<a href="<?php echo m_permalink('user_profile',$user['sef'],$user['id']); ?>" title="İncelemeler"><i class="fa fa-pen-square"></i> İncelemeler</a>
	  </li>
	  <li class="user_static_tabs_link">
		<a href="<?php echo m_permalink('user_profile_comments',$user['sef'],$user['id']); ?>" title="Yorumlar"><i class="fa fa-comments"></i> Yorumlar</a>
	  </li>
	</ul>
	
	<div class="page_head">
	<div class="page_icon"><i class="fa fa-comments"></i></div>
	<div class="page_title"><h2><?php echo $user['username']; ?> Tarafından Yapılan Son Yorumlar</h2></div>
	</div>
	
	<div class="row">
	
	
	<?php
			echo $result['html'];
	?>
	
	
	
	</div>
	<?php
	if($result['count']==0)
	{
		echo m_alert('Bilgi','Bu kullanıcının şuanda yaptığı bir yorum bulunmuyor.');
	}
	?>
	</div>
	<?php
		echo m_pagination($result['total_page'],$result['current_page'],m_permalink('user_profile_comments',$user['sef'],$user['id']));
	?>
	
	
	
	</div>
</div>
</div>

<?php
m_footer();
?>
