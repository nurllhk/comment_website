<?php
include('../init.php');

$informations = $db->table('reviews')->where('status','=',4)->where_set('wait_publish_date','<=','NOW()')->order('wait_publish_date','asc')->get();

foreach($informations['data'] as $info)
{
			$data = [
			'add_user' => 0,
			'status' => 1
			];
			$query = $db->table('products')->where('id','=',$info['p_id'])->update($data);
			
			
			$data = [
			'pay_review' => 1,
			'status' => 1,
			'date' => $db->now()
			
			];
			
			$query = $db->table('reviews')->where('id','=',$info['id'])->update($data);
			
			
			if($info['pay_and_point_completed']==0)
			{
				if(m_setting('fee_per_review_status')==1)
				{
					$level_fee_per_review = m_user_level(m_user('user_level',$info['u_id']),'fee_per_review');
					user_balances_add(true,$info['u_id'],$level_fee_per_review,'review_first_pay',$info['id'],'İnceleme Ödemesi');
				}
				
				if($info['week_category']==1)
				{
					$week_category_fee = m_setting('week_category_fee');
					user_balances_add(true,$info['u_id'],$week_category_fee,'review_week_category_pay',$info['id'],'Haftanın Kategorisi İnceleme Ödemesi');
				}
			
				$add_point = $info['approved_point']+$info['first_point']+$info['word_point']+$info['spelling_point']+$info['image_point']+$info['original_image_point']+$info['paragraph_point'];
				$db->query("update users set user_level=user_level+".$add_point." where id='".$info['u_id']."'");
				
				$data = [
				'pay_and_point_completed' => 1
				
				];
				
				$query = $db->table('reviews')->where('id','=',$info['id'])->update($data);
				
				$db->query("update moderator_actions set data_status='1' where data_status='4' and data_type='review' and data_id='".$info['id']."'");
				
			}
			
			
			
			
			
			email_send(m_user('email',$info['u_id']),'İncelemeniz Onaylandı',email_inceleme_yayin(m_user('username',$info['u_id']),$info['title'],m_permalink('review',$info['sef'],$info['id'])));
			m_user_notification_push('published_review',$info['id']);	
			
			
}