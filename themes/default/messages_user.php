<?php
	m_header();
	$users = $db->table('users')->where('id','=',m_u_g('id'))->where('id','!=',USER['id'])->where('status','=',1)->get();
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
	$user_last_seen = m_time_ago($user['last_login']);
?>
<div class="main">
	<div class="container">
	
		<div class="page_head">
		<div class="page_icon"><i class="fa fa-comment-dots"></i></div>
		<div class="page_title"><h1>Mesajlar</h1></div>
		</div>
		
		<?php echo m_ads('720_300'); ?>
		
		<div class="row">
		
			<div class="col-lg-4">
			
					<div class="chat_left_header">
					
						<div class="icon"><i class="fa fa-users"></i></div>
						<div class="title">Son Görüşmeler</div>
					
					</div>
					<div class="chat_users"></div>
				
			</div>
			
			<div class="col-lg-8">
					
					<div class="chat_right">
					
							<div class="chat_user chat_current_user_detail">
							
								<div class="avatar">
								<a href="<?php echo $user_link; ?>"><img src="<?php echo $user_image; ?>"></a>
								<div class="user_status <?php echo $user_status; ?>"></div>
								</div>
								<div class="chat_user_detail">
									<div class="username"><a href="<?php echo $user_link; ?>"><?php echo $username; ?></a></div>
									<div class="last_seen">Son Görülme: <span class="last_seen_info"><?php echo $user_last_seen; ?></span></div>
								</div>
								<div class="dropdown">
								  <button class="btn btn-secondary" type="button" id="chat_actions" data-bs-toggle="dropdown" aria-expanded="false">
									<i class="fas fa-ellipsis-v"></i>
								  </button>
								  <ul class="dropdown-menu" aria-labelledby="chat_actions">
									<?php
									$block_check = friendship::block_check(m_user('id'),$user['id']);
									if($block_check['you'])
									{
									?>
									<li><a class="dropdown-item chat_user_block_delete" href="javascript:void(0);"><i class="fa fa-ban text-danger"></i> Engeli Kaldır</a></li>
									<?php
									}
									else
									{
									?>
									<li><a class="dropdown-item chat_user_block" href="javascript:void(0);"><i class="fa fa-ban text-danger"></i> Engelle</a></li>
									<?php
									}
									?>
									<li><a class="dropdown-item	chat_delete" href="javascript:void(0);"><i class="fa fa-trash text-primary"></i> Konuşmayı Sil</a></li>
								  </ul>
								</div>
							
							</div>
							<div id="chat_messages" class="chat_messages"></div>
							<form class="chat_form_send">
								<input type="hidden" class="chat_current_user" name="id" value="<?php echo $user['id']; ?>">
								<?php
								if($block_check['you'])
								{
									echo '
										<div class="alert alert-info mt-2 mb-2"><i class="fa fa-info-circle"></i> Bu kişi engellediğinizden artık mesajlaşmaya devam edemezsiniz.</div>
										<a class="btn btn-sm btn-danger w-100 chat_user_block_delete" href="javascript:void(0);"><i class="fa fa-ban text-white"></i> Bu Kişinin Engelini Kaldırın</a>
									';
									
								}elseif($block_check['to'])
								{
									echo '<div class="alert alert-info mt-2 mb-2"><i class="fa fa-info-circle"></i> Bu kişi tarafından engellendiğinizden artık mesajlaşmaya devam edemezsiniz.</div>';
									
								}else
								{
								?>
								<div class="chat_form">
									<textarea class="form-control chat_form_content" id="chat_form_content" name="content" placeholder="mesajınızı yazın" autofocus></textarea>
									<div class="chat_form_smileys">
										<div class="dropdown">
										<span class="chat_form_smileys_dropdown" data-bs-toggle="dropdown" aria-expanded="false">&#128578;</span>
										<div class="dropdown-menu" aria-labelledby="messages_chat_smileys">
										<span class="chat_form_smiley" rel=":)">&#128578;</span>	
										<span class="chat_form_smiley" rel=":(">&#128577;</span>	
										<span class="chat_form_smiley" rel=":/">&#128557;</span>	
										<span class="chat_form_smiley" rel=":P">&#128540;</span>	
										<span class="chat_form_smiley" rel=";)">&#128521;</span>	
										<span class="chat_form_smiley" rel=":D">&#128514;</span>	
										<span class="chat_form_smiley" rel=":@">&#128545;</span>	
										</div>
										</div>
									</div>
								
								</div>
								<?php
								}
								?>
								
								
							</form>	
							
					</div>
				
			</div>
		
		</div>
		
	</div>
</div>
<?php
	m_footer();
?>
					