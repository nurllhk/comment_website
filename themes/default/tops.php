<?php
	m_header();
?>  
<div class="main">
	<div class="container">
		<div class="row">
		<div class="col-xl-12 col-lg-12 col-sm-12 col-12">
		<div class="page_head">
		<div class="page_icon"><i class="fa fa-users"></i></div>
		<div class="page_title"><h1>En İyi Kullanıcılar</h1></div>
		</div>
		<div class="mt-3">
		<div class="row">
		
		<div class="col-xl-12 col-lg-12 col-sm-12">
		
		<div class="card mb-3">
		<div class="card-header card_tab_header">
			  <ul class="nav nav-tabs card-header-tabs" id="pills-tab" role="tablist">
			  <li class="nav-item">
				<a class="nav-link active" href="#bu-hafta" data-bs-toggle="pill" data-bs-target="#bu-hafta">Bu Hafta</a>
			  </li>
			  <li class="nav-item">
			   <a class="nav-link" href="#bu-ay" data-bs-toggle="pill" data-bs-target="#bu-ay">Bu Ay</a>
			  </li>
			  <li class="nav-item">
			   <a class="nav-link" href="#bu-yil" data-bs-toggle="pill" data-bs-target="#bu-yil">Bu Yıl</a>
			  </li>
			  </ul>
		</div>
		</div>
		
		 
		<div class="tab-content" id="v-pills-tabContent">
			<div class="tab-pane fade show active" id="bu-hafta" role="tabpanel">
			<div class="row">
			<?php
				$informations = $db->query("SELECT u.id,u.last_login,u.user_level,u.sef,u.username,u.gender,u.avatar,total_reviews,total_views,total_liked,total_reviews*0.10*total_views as rating FROM users u INNER JOIN ( SELECT u_id, SUM(views) as total_views, SUM(liked) as total_liked, COUNT(*) as total_reviews FROM reviews where status='1' and YEARWEEK(date)= YEARWEEK(CURDATE()) GROUP BY u_id ) r ON r.u_id = u.id ORDER BY rating DESC, total_reviews DESC limit 24")->fetchAll(PDO::FETCH_ASSOC);
				foreach($informations as $info)
				{
					$username = $info['username'];
					$user_link = m_permalink('user_profile',$info['sef'],$info['id']);
					$user_image = m_user_avatar($info['gender'],$info['avatar'],true);
					$user_status = m_user_status($info['last_login']);
					$user_rank = m_user_level($info['user_level'],'icon');
					echo '
					<div class="col-xl-4 col-lg-4 col-sm-12">
					<div class="user_box">
					<div class="user">
					<div class="user_image">
					<a href="'.$user_link.'" title="'.$username.'"><img src="'.UPLOAD_URL.'/1x1.gif" class="lazyload" width="40" height="40" data-src="'.$user_image.'" alt="'.$username.'"></a>
					<div class="user_status '.$user_status.'"></div>
					</div>
					<div class="user_name">
					<a href="'.$user_link.'" title="'.$username.'">'.$username.'</a>
					'.$user_rank.'
					</div>
					</div>
					<div class="user_detail">
						<div class="user_detail_info"><i class="fa fa-pen-square bg-dark" data-bs-toggle="tooltip" data-bs-placement="bottom" title="İncelemeler"></i> <span>'.m_number_format($info['total_reviews']).'</span></div>
						<div class="user_detail_info"><i class="fa fa-thumbs-up bg-success" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Beğeni Puanı"></i> <span>'.m_number_format($info['total_liked']).'</span></div>
						<div class="user_detail_info"><i class="fa fa-info-circle bg-info" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Genel Toplam"></i> <span>'.m_number_format(str_replace('.','',$info['rating'])).'</span></div>
					</div>
					</div>
					</div>';
				}
			?>
			</div>
			
			
			</div>
			<div class="tab-pane" id="bu-ay" role="tabpanel">
			<div class="row">
			<?php
				$informations = $db->query("SELECT u.id,u.last_login,u.user_level,u.sef,u.username,u.gender,u.avatar,total_reviews,total_views,total_liked,total_reviews*0.10*total_views as rating FROM users u INNER JOIN ( SELECT u_id, SUM(views) as total_views, SUM(liked) as total_liked, COUNT(*) as total_reviews FROM reviews where status='1' and MONTH(date) = MONTH(CURRENT_DATE())
AND YEAR(date) = YEAR(CURRENT_DATE()) GROUP BY u_id ) r ON r.u_id = u.id ORDER BY rating DESC, total_reviews DESC limit 24")->fetchAll(PDO::FETCH_ASSOC);
				foreach($informations as $info)
				{
					$username = $info['username'];
					$user_link = m_permalink('user_profile',$info['sef'],$info['id']);
					$user_image = m_user_avatar($info['gender'],$info['avatar'],true);
					$user_status = m_user_status($info['last_login']);
					$user_rank = m_user_level($info['user_level'],'icon');
					echo '
					<div class="col-xl-4 col-lg-4 col-sm-12">
					<div class="user_box">
					<div class="user">
					<div class="user_image">
					<a href="'.$user_link.'" title="'.$username.'"><img src="'.UPLOAD_URL.'/1x1.gif" class="lazyload" width="40" height="40" data-src="'.$user_image.'" alt="'.$username.'"></a>
					<div class="user_status '.$user_status.'"></div>
					</div>
					<div class="user_name">
					<a href="'.$user_link.'" title="'.$username.'">'.$username.'</a>
					'.$user_rank.'
					</div>
					</div>
					<div class="user_detail">
						<div class="user_detail_info"><i class="fa fa-pen-square bg-dark" data-bs-toggle="tooltip" data-bs-placement="bottom" title="İncelemeler"></i> <span>'.m_number_format($info['total_reviews']).'</span></div>
						<div class="user_detail_info"><i class="fa fa-thumbs-up bg-success" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Beğeni Puanı"></i> <span>'.m_number_format($info['total_liked']).'</span></div>
						<div class="user_detail_info"><i class="fa fa-info-circle bg-info" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Genel Toplam"></i> <span>'.m_number_format(str_replace('.','',$info['rating'])).'</span></div>
					</div>
					</div>
					</div>';
				}
			?>
			</div>
			</div>
			<div class="tab-pane" id="bu-yil" role="tabpanel">
			<div class="row">
			<?php
				$informations = $db->query("SELECT u.id,u.last_login,u.user_level,u.sef,u.username,u.gender,u.avatar,total_reviews,total_views,total_liked,total_reviews*0.10*total_views as rating FROM users u INNER JOIN ( SELECT u_id, SUM(views) as total_views, SUM(liked) as total_liked, COUNT(*) as total_reviews FROM reviews where status='1' and YEAR(date) = YEAR(CURRENT_DATE()) GROUP BY u_id ) r ON r.u_id = u.id ORDER BY rating DESC, total_reviews DESC limit 24")->fetchAll(PDO::FETCH_ASSOC);
				foreach($informations as $info)
				{
					$username = $info['username'];
					$user_link = m_permalink('user_profile',$info['sef'],$info['id']);
					$user_image = m_user_avatar($info['gender'],$info['avatar'],true);
					$user_status = m_user_status($info['last_login']);
					$user_rank = m_user_level($info['user_level'],'icon');
					echo '
					<div class="col-xl-4 col-lg-4 col-sm-12">
					<div class="user_box">
					<div class="user">
					<div class="user_image">
					<a href="'.$user_link.'" title="'.$username.'"><img src="'.UPLOAD_URL.'/1x1.gif" class="lazyload" width="40" height="40" data-src="'.$user_image.'" alt="'.$username.'"></a>
					<div class="user_status '.$user_status.'"></div>
					</div>
					<div class="user_name">
					<a href="'.$user_link.'" title="'.$username.'">'.$username.'</a>
					'.$user_rank.'
					</div>
					</div>
					<div class="user_detail">
						<div class="user_detail_info"><i class="fa fa-pen-square bg-dark" data-bs-toggle="tooltip" data-bs-placement="bottom" title="İncelemeler"></i> <span>'.m_number_format($info['total_reviews']).'</span></div>
						<div class="user_detail_info"><i class="fa fa-thumbs-up bg-success" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Beğeni Puanı"></i> <span>'.m_number_format($info['total_liked']).'</span></div>
						<div class="user_detail_info"><i class="fa fa-info-circle bg-info" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Genel Toplam"></i> <span>'.m_number_format(str_replace('.','',$info['rating'])).'</span></div>
					</div>
					</div>
					</div>';
				}
			?>
			</div>
			</div>
		</div>
		
		
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