<?php
	m_header();
?>   
<div class="main">
	<div class="container">
	
		<div class="page_head">
		<div class="page_icon"><i class="fa fa-exclamation-triangle"></i></div>
		<div class="page_title"><h1>Yönetim Bildirimleri</h1></div>
	
		</div>
		<div class="content mt-2 mb-2">
			<div id="ezoic-pub-ad-placeholder-112"> </div>
		<?php
			$informations = $db->table('user_notifications')->where('u_id','=',USER['id'])->where('type','=','admin')->order('date','desc')->get();
			if($informations['total_count']==0)
			{
				echo m_alert('Bilgi','Şuanda bir yönetim bildirimi bulunmuyor.');
			}
		?>
		<?php
		foreach($informations['data'] as $info)
		{
			$read = '';
			if($info['status']==1)
			{
				$read = 'notification_read';
			}
			$time_ago = m_time_ago($info['date']);
			if($info['type']=='admin')
			{
				$icon = 'fa fa-info-circle';
			}
			$guid = $info['guid'];
			$title = $info['title'];
		?>
		<a href="<?php echo $guid; ?>" class="account_notification <?php echo $read; ?>">
			<div class="account_notification_icon"><i class="<?php echo $icon; ?>"></i></div>
			<div class="account_notification_notify">
				<div class="account_notification_notify_detail"><?php echo $title; ?></div>
				<div class="account_notification_date"><i class="fa fa-clock"></i> <span><?php echo $time_ago; ?></span></div>
			</div>
		</a>
		<?php
		}
		?>
		
		</div>
		
		<div class="page_head">
		<div class="page_icon"><i class="fa fa-bell"></i></div>
		<div class="page_title"><h1>Bildirimler</h1></div>
		</div>
		<div class="content mt-2">
		    	<div id="ezoic-pub-ad-placeholder-112"> </div>
		    
				  
		<?php
			$informations = $db->table('user_notifications')->where('u_id','=',USER['id'])->where('type','!=','admin')->order('date','desc')->pagination(10)->get();
			if($informations['total_count']==0)
			{
				echo m_alert('Bilgi','Şuanda bir bildiriminiz bulunmuyor.');
			}
		?>
		<?php
		foreach($informations['data'] as $info)
		{
			$read = '';
			if($info['status']==1)
			{
				$read = 'notification_read';
			}
			$time_ago = m_time_ago($info['date']);
			if($info['type']=='comment')
			{
				$icon = 'fa fa-comments';
			}
			if($info['type']=='like')
			{
				$icon = 'fa fa-thumbs-up';
			}
			if($info['type']=='unlike')
			{
				$icon = 'fa fa-thumbs-down';
			}
			if($info['type']=='comment_answer')
			{
				$icon = 'fa fa-reply';
			}
			if($info['type']=='comment_like')
			{
				$icon = 'fa fa-thumbs-up';
			}
			if($info['type']=='comment_unlike')
			{
				$icon = 'fa fa-thumbs-down';
			}
			if($info['type']=='approved_review')
			{
				$icon = 'fa fa-calendar-check';
			}
			if($info['type']=='published_review')
			{
				$icon = 'fa fa-check-square';
			}
			if($info['type']=='follow_published_review')
			{
				$icon = 'fa fa-chalkboard-teacher';
			}
			if($info['type']=='wait_revise_review')
			{
				$icon = 'fa fa-pen-square';
			}
			if($info['type']=='rejected_review')
			{
				$icon = 'fa fa-exclamation-circle';
			}
			if($info['type']=='approved_withdraw')
			{
				$icon = 'fa fa-money-bill-wave';
			}
			if($info['type']=='rejected_withdraw')
			{
				$icon = 'fa fa-exclamation-triangle';
			}
			if($info['type']=='answered_support' or $info['type']=='closed_support')
			{
				$icon = 'fa fa-headset';
			}
			if($info['type']=='follow')
			{
				$icon = 'fa fa-user-friends';
			}
			$guid = $info['guid'];
			$title = $info['title'];
		?>
		<a href="<?php echo $guid; ?>" class="account_notification <?php echo $read; ?>">
			<div class="account_notification_icon"><i class="<?php echo $icon; ?>"></i></div>
			<div class="account_notification_notify">
				<div class="account_notification_notify_detail"><?php echo $title; ?></div>
				<div class="account_notification_date"><i class="fa fa-clock"></i> <span><?php echo $time_ago; ?></span></div>
			</div>
		</a>
		<?php
		}
		?>
		
		<?php
		echo m_pagination($informations['total_page'],$informations['current_page'],m_permalink('account_notifications'));
		?>
		
		
		</div>
		
	</div>
</div>
<?php
	$db->query("update user_notifications set status='1' where u_id='".USER['id']."'");
	m_footer();
?>
					