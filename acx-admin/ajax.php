<?php
require_once('../init.php');
if(!m_admin_check())
{
	m_redirect(ADMIN_URL.'/login.php');
}
if($_POST)
{
	switch(m_a_p('type'))
	{
		case 'chat_message_list':
		
						$memory_users = array();
						$users = $db->table('users')->get();

						foreach($users['data'] as $user)
						{
							foreach($user as $key => $value)
							{
								$memory_users[$user['id']][$key] = $value;
							}
						}


						$messages = $db->table('user_send')->order('id','asc')->get();

						$message_list = '';
						foreach($messages['data'] as $msg)
						{
							$user_from = $memory_users[$msg['user_from']];
							$user_to = $memory_users[$msg['user_to']];
							$content = htmlspecialchars_decode($msg['content'],ENT_QUOTES);
							$date = m_time_ago($msg['date']);
							$message_list.='
							<div class="card mb-2">
							<div class="card-body">
							<div class="row">
							<div class="col-lg-2 col-6 order-lg-1 order-1">
							
							<div class="user">
							<div class="avatar">
							<img src="'.m_user_avatar($user_from['gender'],$user_from['avatar'],true).'">
							</div>
							<div class="username">'.$user_from['username'].'</div>
							</div>
							
							</div>
							<div class="col-lg-8 col-12 order-lg-2 order-3">
								<div class="msg">
								<div class="card mt-2 mb-2"><div class="card-body">'.$content.'</div></div>
								</div>
							</div>
							<div class="col-lg-2 col-6 order-lg-2 order-2">
							
							<div class="user">
							<div class="avatar">
							<img src="'.m_user_avatar($user_to['gender'],$user_to['avatar'],true).'">
							</div>
							<div class="username">'.$user_to['username'].'</div>
							</div>
							
							</div>
							</div>
							<div class="col-12 text-center"><div class="btn btn-sm btn-primary" style="width:140px"><i class="fa fa-clock"></i> '.$date.'</div></div>
							</div>
							</div>
							';
						}
						$return['chat_message_list'] = $message_list;
						echo json_encode($return);
		
		break;
		case 'bulk_delete_product':
		
						foreach($_POST['ids'] as $id)
						{
							$info = $db->table('products')->where('id','=',$id)->get_vars();
							unlink(UPLOAD_DIR.'/images/'.basename($info['image']));
							unlink(UPLOAD_THUMB_DIR.'/'.basename($info['image']));
							$db->table('products')->where('id','=',$id)->delete();
						}
		
		break;
		case 'balances':
		
						$return = array();
						$yesterday_date = date('Y-m-d',strtotime('-1 day')).' 00:00:00';
						$today_total = $db->table('user_balances')->where_set('date','>=','CURDATE()')->where_set('date','<','CURDATE() + INTERVAL 1 DAY')->get();

						$stats = array();
						$stats['today_total'] = 0;
						foreach($today_total['data'] as $to)
						{
							$user = $to['u_id'];
							$description = $to['description'];
							$amount = $to['amount'];
							
							if(!isset($stats['users'][$user]))
							{
								$stats['users'][$user]['user_id'] = $user;
								$stats['users'][$user]['today_total'] = 0;
							}
							if(!isset($stats['descriptions'][$description]))
							{
								$stats['descriptions'][$description]['description_type'] = $description;
								$stats['descriptions'][$description]['today_total'] = 0;
							}
							
							
							
							
								$stats['today_total'] = $stats['today_total']+$amount;
								$stats['users'][$user]['today_total'] = $stats['users'][$user]['today_total']+$amount;
								$stats['descriptions'][$description]['today_total'] = $stats['descriptions'][$description]['today_total']+$amount;
							
							
							
							
						}

						$users = $stats['users'];
						$descriptions = $stats['descriptions'];
						array_multisort(array_column($users, 'today_total'), SORT_DESC,$users);
						array_multisort(array_column($descriptions, 'today_total'), SORT_DESC,$descriptions);
						
						$first_description = $descriptions[array_key_first($descriptions)];
						
						$return['today_total'] = m_currency($stats['today_total']);
						$return['today_best_type'] = $first_description['description_type'];
						$return['today_best_type_total'] = m_currency($first_description['today_total']);
						$return['today_best_user'] = m_user('username',$users[0]['user_id']);
						$return['today_best_user_total'] = m_currency($users[0]['today_total']);
						$return['today_review_first_pay'] = m_currency($descriptions['İnceleme Ödemesi']['today_total']);
						$return['today_review_pay'] = m_currency($descriptions['İnceleme Görüntülenme']['today_total']);
						$return['today_time_pay'] = m_currency($descriptions['Sitede Kalma Kazancı']['today_total']);
						$return['today_referer_withdraw_amount'] = m_currency($descriptions['Referans Para Çekimi']['today_total']);
						echo json_encode($return);
		
		break;
		case 'comment_approve':
						$return = array();
						$informations = $db->table('comments')->where('id','=',m_a_p('id'))->where('status','=','0')->get();
						if($informations['total_count']>0)
						{
							$info = $informations['data'][0];
							$data = [
							'status' => 1
							
							];
							
							$query = $db->table('comments')->where('id','=',m_a_p('id'))->update($data);
							m_user_notification_push('comment',$info['r_id']);
							
							if($info['answered_u_id']!=0)
							{
								m_user_notification_push('comment_answer',$info['id']);
							}
							
							$return['status'] = true;
							$return['msg'] = 'Yorum Onaylandı!';
						}
						else
						{
							$return['status'] = false;
							$return['msg'] = 'Yorum Bulunamadı!';
						}
						echo json_encode($return);
		
		break;
		case 'copy_review_reject':
						$return = array();
						$informations = $db->table('reviews')->where('id','=',m_a_p('id'))->where('status','=','0')->get();
						if($informations['total_count']>0)
						{
							$info = $informations['data'][0];
							
							$rejected_type = $db->table('rejected_types')->where('copy','=','1')->get_vars()['id'];
							
							$data = [
							'rejected_type' => $rejected_type,
							'status' => 2,
							
							];
							
							$query = $db->table('reviews')->where('id','=',$info['id'])->update($data);
							
							$db->query("update users set rejected_reviews=rejected_reviews+1 where id='".$info['u_id']."'");
							$db->query("update users set copy_reviews=copy_reviews+1 where id='".$info['u_id']."'");
							
							email_send(m_user('email',$info['u_id']),'İncelemeniz Reddedildi',email_inceleme_red(m_user('username',$info['u_id'])));
							m_user_notification_push('rejected_review',$info['id']);
							
							$return['status'] = true;
							$return['msg'] = 'İncele Reddedildi!';
						}
						else
						{
							$return['status'] = false;
							$return['msg'] = 'İnceleme Bulunamadı!';
						}
						echo json_encode($return);
		
		break;
		case 'add_comment_review_detail':
						
						$review = $db->table('reviews')->where('id','=',m_u_p('id'))->get_vars();
						$product = $db->table('products')->where('id','=',$review['p_id'])->get_vars();
						$brand = $db->table('brands')->where('id','=',$product['b_id'])->get_vars();
						
						echo '
						<div class="row">
						
						<div class="col-4">
							<a href="'.m_image_url($product['image']).'" data-popup="lightbox"><img src="'.m_image_url($product['image']).'" class="img-thumbnail" style="width:100px;height:100px"></a>
						</div>
						
						<div class="col-8">
							<a href="'.m_permalink('review',$review['sef'],$review['id']).'" target="_blank" class="btn btn-sm btn-primary">İncelemeyi Gör</a> <br><br>
							<b>Marka:</b> '.$brand['title'].' <br><br>
							<b>Ürün Adı:</b> '.$product['title'].'
						
						</div>
						
						</div>
						';
		
		break;
		case 'add_review_image':
						$return = array();
						
						$upload = m_image_tmp_uploader('files','review_image_'.uniqid().'',true,true,100,100);
						if($upload[0]!='')
						{
							$return['result'] = true;
							$n = 0;
							foreach($upload as $image)
							{
							
							
							$return['links'][$n] = m_image_tmp_url($image);
							$n++;
							}
						}
						else
						{
							$return['result'] = false;
						}
		echo json_encode($return);
		
		break;
		case 'review_image_editor_ajax':
						$return = array();
						
						$upload = m_image_tmp_uploader('image','review_image_'.time().'',true,true,100,100);
						if($upload[0]!='')
						{
							$return['result'] = true;
							
							$return['link'] = m_image_tmp_url($upload[0]);
						}
						else
						{
							$return['result'] = false;
						}
		echo json_encode($return);
		
		break;
		case 'brand_search':
		
		$return = array();
		if(mb_strlen(m_a_p('q'),'UTF-8')>2)
		{
		
			$brands = $db->table('brands')->where('status','=','1')->where_set("REPLACE(title,' - ',' ')",'LIKE',"'%".addslashes(m_a_p('q'))."%'")->order('title','asc')->limit(20)->get();
			foreach($brands['data'] as $brand)
			{
			
				
				$return['items'][] = ['id'=>$brand['id'], 'text'=>$brand['title']];
				
			}
			$return['total_count'] = $brands['total_count'];
			$return['incomplete_results'] = false;
			echo json_encode($return);
		}
		break;
		case 'product_search':
		
		$return = array();
		if(mb_strlen(m_a_p('q'),'UTF-8')>2)
		{
			$cats = array();
			$cats_query = $db->query("select c_id,MATCH(title) AGAINST ('\"".addslashes(m_a_p('q'))."\"') as score from products where status='1' and MATCH(title) AGAINST ('\"".addslashes(m_a_p('q'))."\"') order by score desc")->fetchAll(PDO::FETCH_ASSOC);
			foreach($cats_query as $cat)
			{
				if(!in_array($cat['c_id'],$cats) and count($cats)<=10)
				{
					array_push($cats,$cat['c_id']);
				}
			}
			if(count($cats)==0)
			{
				$return['total_count'] = $informations['total_count'];
				$return['incomplete_results'] = false;
			}
			else
			{
				
				foreach($cats as $cat)
				{
					$d_category = m_review::product_last_category($cat);
					$return['items'][] = ['type'=>'category', 'text'=>$d_category['title']];
					$products = $db->query("select id,sef,title,MATCH(title) AGAINST ('\"".addslashes(m_a_p('q'))."\"') as score from products where status='1' and c_id LIKE '%[".$d_category['id']."]%' and MATCH(title) AGAINST ('\"".addslashes(m_a_p('q'))."\"') order by score desc limit 5")->fetchAll(PDO::FETCH_ASSOC);
					foreach ($products as $product)
					{
						$return['items'][] = ['id'=>$product['id'], 'text'=>$product['title']];
					}
					
					
				}
				$return['total_count'] = $products['total_count'];
				$return['incomplete_results'] = false;
			}
			
			echo json_encode($return);
		}
		break;
	}
}
?>