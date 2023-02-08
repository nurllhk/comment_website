<?php
	m_header();
?>
<div class="main">
	<div class="container">
		<div class="row">

		
		<div class="col-xl-12 col-lg-12 col-sm-12">
		<div class="page_head">
		<div class="page_icon"><i class="fa fa-user-friends"></i></div>
		<div class="page_title"><h1>Takip Edilenler</h1></div>
		</div>
		<div class="row">
		
		<div class="col-xl-4 col-lg-4 col-sm-4 col-12">
			
			<?php require_once('account_part.php'); ?>
		
		</div>
		
		<div class="col-xl-8 col-lg-8 col-sm-8 col-12">
		
			<div class="page_head">
			<div class="page_icon"><i class="fa fa-list"></i></div>
			<div class="page_title"><h2>Takip Ettiğiniz Kullanıcılar</h2></div>
			</div>
			
			<div class="friendship_list">
				<?php
				$informations = $db->query("select 
				u.id as u_id,
				u.username as u_username,
				u.gender as u_gender,
				u.last_login as u_last_login,
				u.avatar as u_avatar,
				u.user_level as u_user_level,
				u.sef as u_sef
				from user_followers uf
				inner join users u on uf.follow_user=u.id
				where uf.u_id='".USER['id']."' order by uf.id desc")->fetchAll(PDO::FETCH_ASSOC);
				
				if(count($informations)>0)
				{
					foreach($informations as $info)
					{
						$user = $info['u_id'];
						$username = $info['u_username'];
						$user_profile_link = m_permalink('user_profile',$info['u_sef'],$info['u_id']);
						$user_avatar = m_user_avatar($info['u_gender'],$info['u_avatar'],true);
						$user_status = m_user_status($info['u_last_login']);
						
						echo '
						<div class="friendship_user">
							
								<div class="avatar">
								<a href="'.$user_profile_link.'" target="_blank"><img src="'.$user_avatar.'"></a>
								<div class="user_status '.$user_status.'"></div>
								</div>
								<div class="friendship_user_detail">
									<a href="'.$user_profile_link.'" class="username" target="_blank">'.$username.'</a>
									<div class="user_actions">
										<div class="user_follow followed" data-user-id="'.$user.'">
											<div class="user_follow_icon"><i class="fa fa-check-square"></i></div>
											<div class="user_follow_text">Takip</div>
										</div>
										<a href="'.m_permalink('messages_user',$user).'" class="user_send_message">
											<div class="user_send_message_icon"><i class="fa fa-comment-dots"></i></div>
											<div class="user_send_message_text">Mesaj Gönder</div>
										</a>';
									
						echo'</div>
						</div>
						</div>';
						
					}
				}
				else
				{
					echo m_alert('Bilgi','Henüz takip ettiğiniz bir kişi bulunmuyor.');
				}
				?>
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
					