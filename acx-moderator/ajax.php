<?php
require_once('../init.php');
if(!m_moderator_check())
{
	m_redirect(MODERATOR_URL.'/login.php');
}
if($_POST)
{
	switch(m_a_p('type'))
	{
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
							
							m_moderator_action_add('comment',$info['id']);
							
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
							
							m_moderator_action_add('review',$info['id'],2);
							
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