<?php
require_once('init.php');
if($_POST)
{
switch(m_u_p('type'))
{

case 'user_reviews_list':
		
		if(m_u_p('page_no'))
		{
			$_GET['page_no'] = m_u_p('page_no');
		}

		if(USER)
		{
			$user_reviews = $db->table('reviews')->where('u_id','=',USER['id']);
			
			if(m_u_p('status')!='')
			{
				$user_reviews->where('status','=',m_u_p('status'));
			}
			if(m_u_p('q')!='')
			{
				$user_reviews->where_set('title','LIKE',"'%".m_u_p('q')."%'");
			}
			$user_reviews = $user_reviews->order('id','desc')->pagination(10)->get();
			echo '<div class="alert alert-info mt-2 mb-2"><i class="fa fa-edit"></i> Filtrelemenize göre toplam '.m_number_format($user_reviews['total_count']).' incelemeniz bulunuyor. İnceleme Kazançlarında görünen tutarlar son 15 günü yansıtmaktadır.</div>';
			if($user_reviews['total_count']>0)
			{
				
			echo m_user_reviews_pagination($user_reviews['total_page'],$user_reviews['current_page']);	
				
			foreach($user_reviews['data'] as $review)
			{
				$total_review_wins = $db->select('sum(amount) as total')->table('user_balances')->where('u_id','=',USER['id'])->where('data_type','=','review')->where('data_id','=',$review['id'])->get();

			echo '
			<div class="card mb-3">
			<div class="card-body">
			<div class="row">
			<div class="col-12 mb-3">
			<b>İnceleme Adı:</b> <a href="'.m_permalink('review',$review['sef'],$review['id']).'">'.$review['title'].'</a>
			</div>
			<div class="col-lg-3 col-12 mb-3">
			<b>Tarih:</b> '.m_date_to_tr($review['date']).'
			</div>
			<div class="col-lg-3 col-12 mb-3">
			<b>Durum:</b> '.m_review_status($review['status']).'
			</div>
			<div class="col-lg-3 col-12 mb-3">
			<b>Görüntülenme:</b> '.number_format($review['views']).'</i>
			</div>
			<div class="col-lg-3 col-12 mb-3">
			<b>Kazanç:</b> '.m_currency($total_review_wins['data'][0]['total']).'  <i class="fa fa-lira-sign"></i>
			</div>
			
			';
			if($review['status']==1)
			{
			echo '
			<div class="col-lg-12 col-12 mb-3">
			<h5 style="font-size:13px">Alınan Puanlar - Para Kazanma Durumu</h5>
			<hr>
			<div class="row">
			
			<div class="col-xl-3 col-lg-3 col-12">
			<span class="btn btn-outline-success btn-sm w-100 text-start mb-2" title="Onaylanan İnceleme"><i class="fa fa-check-square"></i> O.İnceleme <span class="float-end">'.m_number_format($review['approved_point']).'</span></span>
			</div>
			<div class="col-xl-3 col-lg-3 col-12">
			<span class="btn btn-outline-success btn-sm w-100 text-start mb-2" title="İlk İnceleme"><i class="fa fa-tint"></i> İ.İnceleme <span class="float-end">'.m_number_format($review['first_point']).'</span></span>
			</div>
			<div class="col-xl-3 col-lg-3 col-12">
			<span class="btn btn-outline-success btn-sm w-100 text-start mb-2" title="Kelime Sayısı"><i class="fa fa-text-width"></i> K.Sayısı <span class="float-end">'.m_number_format($review['word_point']).'</span></span>
			</div>
			<div class="col-xl-3 col-lg-3 col-12">
			<span class="btn btn-outline-success btn-sm w-100 text-start mb-2" title="İmla Kuralları"><i class="fa fa-keyboard"></i> İ.Kuralları <span class="float-end">'.m_number_format($review['spelling_point']).'</span></span>
			</div>
			
			<div class="col-xl-3 col-lg-3 col-12">
			<span class="btn btn-outline-success btn-sm w-100 text-start mb-2" title="Eklenen Fotoğraf"><i class="fa fa-images"></i> E.Fotoğraf <span class="float-end">'.m_number_format($review['image_point']).'</span></span>
			</div>
			
			<div class="col-xl-3 col-lg-3 col-12">
			<span class="btn btn-outline-success btn-sm w-100 text-start mb-2" title="Kateli Fotoğraflar"><i class="fa fa-camera-retro"></i> K.Fotoğraflar <span class="float-end">'.m_number_format($review['original_image_point']).'</span></span>
			</div>
			
			<div class="col-xl-3 col-lg-3 col-12">
			<span class="btn btn-outline-success btn-sm w-100 text-start mb-2" title="Paragraf Fotoğraf Uyumu"><i class="fa fa-th-large"></i> P.F Uyumu <span class="float-end">'.m_number_format($review['paragraph_point']).'</span></span>
			</div>';
			
			
			if($review['pay_review']==1)
			{
				echo '<div class="col-xl-3 col-lg-3 col-12">
			<span class="btn btn-outline-success btn-sm w-100 text-start mb-2" title="Para Kazanma"><i class="fa fa-coins"></i> P.Kazanma <span class="float-end"><i class="fa fa-check-square text-primary"></i></span></span>
			</div>';
			}
			if($review['pay_review']==0)
			{
				echo '<div class="col-xl-3 col-lg-3 col-12">
			<span class="btn btn-outline-success btn-sm w-100 text-start mb-2" title="Para Kazanma"><i class="fa fa-coins"></i> P.Kazanma  <span class="float-end"><i class="fa fa-times text-danger"></i></span></span>
			</div>';
			}
			
			
			
			echo '
			</div>
			</div>';
			}
			if($review['status']==0)
			{
				echo '<div class="row"><div class="col-lg-12"><div class="alert alert-info"><i class="fa fa-spin fa-spinner"></i> İncelemeniz değerlendiriliyor, lütfen daha sonra tekrar kontrol edin..</div></div></div>';
			}
			if($review['status']==4)
			{
				echo '<div class="row"><div class="col-lg-12"><div class="alert alert-success"><i class="fa fa-spin fa-spinner"></i> İncelemeniz '.m_date_to_tr($review['wait_publish_date']).' tarihinde yayınlanacak şekilde planlandı.</div></div></div>';
			}
			if($review['status']==3)
			{
				$rejected_type = $db->table('rejected_types')->where('id','=',$review['rejected_type'])->get_vars();
				echo '<div class="row"><div class="col-lg-12"><div class="alert alert-warning d-block mb-2"><i class="'.$rejected_type['icon'].'"></i> İncelemeniz Düzenleme Bekliyor: '.$rejected_type['title'].'</div></div></div>';
				echo '<div class="row"><div class="col-lg-12"><a href="'.m_permalink('revise_review',$review['id']).'" class="alert alert-success d-block w-100 mb-2"><i class="fa fa-pen-square"></i> İncelemenizi düzenlemek için tıklayınız.</a></div></div>';
				echo '<div class="row"><div class="col-lg-12"><a href="'.m_permalink('rejected_types').'" class="alert alert-info d-block w-100 mb-2"><i class="fa fa-question-circle"></i> İnceleme Red Nedenlerini görmek için tıklayınız.</a></div></div>';
			}
			if($review['status']==2)
			{
				$rejected_type = $db->table('rejected_types')->where('id','=',$review['rejected_type'])->get_vars();
				if($rejected_type['title']=='')
				{
					$rejected_type['title'] = 'Neden, belirtilmedi.';
				}
				echo '<div class="row"><div class="col-lg-12"><div class="alert alert-danger d-block mb-2"><i class="fa fa-exclamation-triangle"></i> İncelemeniz Reddedildi: '.$rejected_type['title'].'</div></div></div>';
				echo '<div class="row"><div class="col-lg-12"><a href="'.m_permalink('rejected_types').'#'.$rejected_type['id'].'" class="alert alert-info d-block w-100 mb-2"><i class="fa fa-question-circle"></i> İnceleme Red Nedenlerini görmek için tıklayınız.</a></div></div>';
			}
			
			
			echo '
			
			
			</div>
			</div>	

			</div>';
			
			}
			
			echo m_user_reviews_pagination($user_reviews['total_page'],$user_reviews['current_page']);
			
			}
			else
			{
				echo m_alert('Bilgi','Filtrelemelere göre şuanda eklediğiniz bir inceleme bulunmuyor.');
			}
		}
		else
		{
				echo m_alert('Hata','Oturumunuz sonlanmış görünüyor lütfen üye girişi yapınız.');
		}

break;

case 'first_review_step':
		
		$return = array();
		$return['status'] = false;
		if($_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest' and $_SESSION['csrf_token']==m_u_p('csrf_token'))
		{
			if(USER)
			{
				$db->query("update users set first_review_step='1' where id='".USER['id']."'");
				$return['status'] = true;
			}
			else
			{
				$return['status'] = false;
				$return['msg'] = 'Oturumunuz sonlanmış görünüyor lütfen üye girişi yapınız.';
			}
		}
		else
		{
			$return['status'] = false;
			$return['msg'] = 'Geçersiz istek, tarayıcınız çerez ( cookie ) desteklemiyor. Sayfayı yenileyerek tekrar deneyebilirsiniz.';
		}
		echo json_encode($return);
break;

case 'chat_info':
		
		$from = USER['id'];
		$to = m_u_p('id');
		
		$return = array();
		$return['status'] = false;
		if($_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest' and $_SESSION['csrf_token']==m_u_p('csrf_token'))
		{
			if(USER)
			{
				if($db->table('users')->where('id','=',$to)->count()>0 and $to!=USER['id'])
				{
					
					$return['status'] = true;
					$return['chat_info'] = friendship::chat_info($from,$to);
				}
				else
				{
					$return['status'] = false;
					$return['msg'] = 'Mesaj göndermek istediğiniz kullanıcı bulunamadı.';
				}
			}
			else
			{
					$return['status'] = false;
					$return['msg'] = 'Oturumunuz sonlanmış görünüyor lütfen üye girişi yapınız.';
			}
		}
		else
		{
			$return['status'] = false;
			$return['msg'] = 'Geçersiz istek, tarayıcınız çerez ( cookie ) desteklemiyor. Sayfayı yenileyerek tekrar deneyebilirsiniz.';
		}
		echo json_encode($return);
break;
case 'chat_messages':
		
		
		
		$return = array();
		$return['status'] = false;
		if($_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest' and $_SESSION['csrf_token']==m_u_p('csrf_token'))
		{
			if(USER)
			{
				$return['status'] = true;
				$return['chat_info']['messages'] = friendship::messages(USER['id']);
			}
			else
			{
				$return['status'] = false;
				$return['msg'] = 'Oturumunuz sonlanmış görünüyor lütfen üye girişi yapınız.';
			}
		}
		else
		{
			$return['status'] = false;
			$return['msg'] = 'Geçersiz istek, tarayıcınız çerez ( cookie ) desteklemiyor. Sayfayı yenileyerek tekrar deneyebilirsiniz.';
		}
		echo json_encode($return);
break;
case 'chat_user_block':
		
		$from = USER['id'];
		$to = m_u_p('id');
		
		$return = array();
		$return['status'] = false;
		if($_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest' and $_SESSION['csrf_token']==m_u_p('csrf_token'))
		{
			if(USER)
			{
				if($db->table('users')->where('id','=',$to)->count()>0 and $to!=USER['id'])
				{
					$block = friendship::block($from,$to);
					if($block)
					{
						
						$return['status'] = true;
					}
					else
					{
						$return['status'] = false;
						$return['msg'] = 'Bu kişiyi zaten engellemişsiniz.';
					}
				}
				else
				{
					$return['status'] = false;
					$return['msg'] = 'Engellemek istediğiniz kullanıcı bulunamadı.';
				}
			}
			else
			{
					$return['status'] = false;
					$return['msg'] = 'Oturumunuz sonlanmış görünüyor lütfen üye girişi yapınız.';
			}
		}
		else
		{
			$return['status'] = false;
			$return['msg'] = 'Geçersiz istek, tarayıcınız çerez ( cookie ) desteklemiyor.';
		}
		echo json_encode($return);
break;
case 'chat_user_block_delete':
		
		$from = USER['id'];
		$to = m_u_p('id');
		
		$return = array();
		$return['status'] = false;
		if($_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest' and $_SESSION['csrf_token']==m_u_p('csrf_token'))
		{
			if(USER)
			{
				if($db->table('users')->where('id','=',$to)->count()>0 and $to!=USER['id'])
				{
					$block_delete = friendship::block_delete($from,$to);
					$return['status'] = true;
				}
				else
				{
					$return['status'] = false;
					$return['msg'] = 'Engelini kaldırmak istediğiniz kullanıcı bulunamadı.';
				}
			}
			else
			{
					$return['status'] = false;
					$return['msg'] = 'Oturumunuz sonlanmış görünüyor lütfen üye girişi yapınız.';
			}
		}
		else
		{
			$return['status'] = false;
			$return['msg'] = 'Geçersiz istek, tarayıcınız çerez ( cookie ) desteklemiyor.';
		}
		echo json_encode($return);
break;
case 'chat_delete':
		
		$from = USER['id'];
		$to = m_u_p('id');
		
		$return = array();
		$return['status'] = false;
		if($_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest' and $_SESSION['csrf_token']==m_u_p('csrf_token'))
		{
			if(USER)
			{
				if($db->table('users')->where('id','=',$to)->count()>0 and $to!=USER['id'])
				{
					$block_delete = friendship::chat_delete($from,$to);
					$return['status'] = true;
				}
				else
				{
					$return['status'] = false;
					$return['msg'] = 'Karşı kullanıcı bulunamadı.';
				}
			}
			else
			{
					$return['status'] = false;
					$return['msg'] = 'Oturumunuz sonlanmış görünüyor lütfen üye girişi yapınız.';
			}
		}
		else
		{
			$return['status'] = false;
			$return['msg'] = 'Geçersiz istek, tarayıcınız çerez ( cookie ) desteklemiyor.';
		}
		echo json_encode($return);
break;
case 'chat_send':
		$content = trim(entities(strip_tags_content(m_u_p('content'))));
		$from = USER['id'];
		$to = m_u_p('id');
		
		$return = array();
		$return['status'] = false;
		if($_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest' and $_SESSION['csrf_token']==m_u_p('csrf_token'))
		{
			if(USER)
			{
				
				if($db->table('users')->where('id','=',$to)->count()>0 and $to!=USER['id'])
				{
					$block_check = friendship::block_check($from,$to);
				
					if($block_check['you'])
					{
						$return['status'] = false;
						$return['msg'] = 'Bu kişiyi engellediğinizden mesajlaşmaya devam edemezsiniz.';
						
					}elseif($block_check['to'])
					{
						$return['status'] = false;
						$return['msg'] = 'Bu kişi tarafından engellendiğinizden mesajlaşmaya devam edemezsiniz.';
						
					}else
					{
						if(mb_strlen($content,'UTF-8')>0)
						{
							
							$return['status'] = true;
							$return['chat_info'] = friendship::send($from,$to,$content);
						}
						else
						{
							$return['status'] = false;
							$return['msg'] = 'Mesajınız boş olamaz.';
						}
						
					}
					
				}
				else
				{
					$return['status'] = false;
					$return['msg'] = 'Mesaj göndermek istediğiniz kullanıcı bulunamadı.';
				}
			}
			else
			{
					$return['status'] = false;
					$return['msg'] = 'Oturumunuz sonlanmış görünüyor lütfen üye girişi yapınız.';
			}
		}
		else
		{
			$return['status'] = false;
			$return['msg'] = 'Geçersiz istek, tarayıcınız çerez ( cookie ) desteklemiyor.';
		}
		echo json_encode($return);
break;

case 'user_follow':
		
		
		$user = m_u_p('id');
		
		$return = array();
		$return['status'] = false;
		if($_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest' and $_SESSION['csrf_token']==m_u_p('csrf_token'))
		{
			if(USER)
			{
				if($db->table('users')->where('id','=',$user)->count()>0 and $user!=USER['id'])
				{
					$user_follow = friendship::user_follow($user);
					$return['status'] = true;
					$return['user_follow'] = $user_follow;
					
				}
				else
				{
					$return['status'] = false;
					$return['msg'] = 'Takip etmek istediğiniz kullanıcı bulunamadı.';
				}
			}
			else
			{
					$return['status'] = false;
					$return['msg'] = 'Oturumunuz sonlanmış görünüyor lütfen üye girişi yapınız.';
			}
		}
		else
		{
			$return['status'] = false;
			$return['msg'] = 'Geçersiz istek, tarayıcınız çerez ( cookie ) desteklemiyor.';
		}
		echo json_encode($return);
break;

case 'add_comment':
		$return = array();
		$return['status'] = false;
		if($_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest' and $_SESSION['csrf_token']==m_u_p('csrf_token'))
		{
			if(USER)
			{
				if(mb_strlen(m_u_p('content'),'UTF-8')<20)
				{
					$return['status'] = false;
					$return['msg'] = 'Yorumunuz en az 20 karakter içermelidir.';
				}
				else
				{
					$review_count = $db->table('reviews')->where('id','=',m_u_p('r_id'))->where('status','=',1)->count();
					$waiting_user_comment = $db->table('comments')->where('r_id','=',m_u_p('r_id'))->where('u_id','=',USER['id'])->where('status','=',0)->count();
					$review_last_comment = $db->table('comments')->where('r_id','=',m_u_p('r_id'))->where('status','=',1)->order('id','desc')->limit(1)->get();
					
					if($waiting_user_comment>0)
					{
						$return['status'] = false;
						$return['msg'] = 'Bu inceleme için onay bekleyen bir yorumunuz zaten var.';
					}
					else
					{
						if($review_last_comment['data'][0]['u_id']==USER['id'])
						{
							$return['status'] = false;
							$return['msg'] = 'İncelemede bulunan son yorum zaten size ait. Lütfen flood yapmayınız.';
						}
						else
						{
							if($review_count>0)
							{
								
									if(m_u_p('content')=='')
									{
										$return['status'] = false;
										$return['msg'] = 'Lütfen yorumu boş bırakmayınız.';
									}
									else
									{
										$data = [
										'r_id' => m_u_p('r_id'),
										'u_id' => USER['id'],
										'answered_u_id' => m_u_p('answered_u_id'),
										'content' => m_u_p('content'),
										'status' => 0
										
										];
										$db->table('comments')->insert($data);
									
										$return['status'] = true;
										$return['msg'] = 'Teşekkürler, yorumunuz yönetici onayından sonra yayınlanacaktır.';
										 
									}
								
							}
							else
							{
								$return['status'] = false;
								$return['msg'] = 'Yorum yapmak istediğiniz inceleme aktif değil.';
								
							}
						}
					}
				}
					
					
					
			}
			else
			{
					$return['status'] = false;
					$return['msg'] = 'Oturumunuz sonlanmış görünüyor lütfen üye girişi yapınız.';
			}
		}
		else
		{
			$return['status'] = false;
			$return['msg'] = 'Geçersiz istek, lütfen daha sonra tekrar deneyin.';
		}
		echo json_encode($return);
break;
case 'other_reviews':
		if(m_u_p('page')!='')
		{
			$_GET['page_no'] = m_u_p('page');
			$review_list = new m_review();
			$review_list->template 					= 'default';
			$review_list->template_col 				= 'col-xl-4 col-lg-4 col-sm-12';
			$review_list->include_user 				= true;
			$review_list->include_product 			= true;
			$review_list->query_options 			= "where r.status='1'";
			$review_list->order 					= "order by r_date desc";
			$review_list->paginate 					= 15;
			$result = $review_list->list_reviews();
			echo $result['html'];
		}
break;	
case 'user_control':
		$return = array();
		
		if($_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest' and $_SESSION['csrf_token']==m_u_p('csrf_token') and USER)
		{
				$return['status'] = true;
				$return['have_notification'] = false;
				$return['have_message'] = false;
				if(m_setting('fee_per_time_on_status')==1 and m_ip_country())
				{
					$difference = time()-USER['timepay_time'];
				
					if($difference>9)
					{
						
						user_balances_add(true,USER['id'],m_setting('fee_per_time_on'),'time_pay',time(),'Sitede Kalma Kazancı');
						$data = [
						'timepay_time' => time()
						];
						
						$query = $db->table('users')->where('id','=',USER['id'])->update($data);
					}
				}
				
				$return['balance'] = m_currency(USER['balance']);
				$total = $db->table('user_notifications')->where('u_id','=',USER['id'])->where('status','=',0)->count();
				$total_msg = $db->table('user_inbox')->where('user_to','=',USER['id'])->where('to_read','=',0)->where('to_delete','=',0)->count();
				if($total>0)
				{
					$return['have_notification'] = true;
				}
				if($total_msg>0)
				{
					$return['have_message'] = true;
				}
		}
		else
		{
			$return['status'] = false;
		}
		echo json_encode($return);
break;
case 'review_payment':
		$cookie = $_COOKIE['review_views'];
		$cookie_unserialize = unserialize($cookie);
		if(!is_array($cookie_unserialize))
		{
			$cookie_unserialize = array();
		}
		if(count($cookie_unserialize)>=50)
		{
			$cookie_unserialize = array();
		}
		if($_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest' and $_SESSION['csrf_token']==m_u_p('csrf_token') and !in_array(m_u_p('id'),$cookie_unserialize))
		{
				
				$reviews = $db->table('reviews')->where('id','=',m_u_p('id'))->where('status','=',1)->get();
				$review = $reviews['data'][0];
				if($reviews['total_count']=='0')
				{
					exit;
				}
				
				$user = $db->table('users')->where('id','=',$review['u_id'])->get_vars();
			
				if($review['pay_review']==1)
				{
					echo "OK";
					array_push($cookie_unserialize,m_u_p('id'));
					setcookie('review_views',serialize($cookie_unserialize),time() + (10 * 365 * 24 * 60 * 60));
					
					m_review_payment($review,$user);
				}
		}
break;	
case 'review_rating':
		$return = array();
		if(m_u_p('review_id')!='' and $db->table('reviews')->where('status','=',1)->where('id','=',m_u_p('review_id'))->count()>0 and m_u_p('rating')!='')
		{
			if($db->table('ip_likes')->where('ip','=',m_ip())->where('data_type','=','review')->where('data_id','=',m_u_p('review_id'))->count()==0)
			{
				if(m_u_p('rating')=='up')
				{
					$db->query("update reviews set liked=liked+1 where id='".m_u_p('review_id')."'");
					$return['total_count'] = $db->table('reviews')->where('id','=',m_u_p('review_id'))->get_var('liked');
					
					m_user_notification_push('like',m_u_p('review_id'));
				}
				else
				{
					$db->query("update reviews set unliked=unliked+1 where id='".m_u_p('review_id')."'");
					$return['total_count'] = $db->table('reviews')->where('id','=',m_u_p('review_id'))->get_var('unliked');
					m_user_notification_push('unlike',m_u_p('review_id'));
				}
				
				$data = [
				'ip' => m_ip(),
				'data_type' => 'review',
				'data_id' => m_u_p('review_id')
				];
				
				$db->table('ip_likes')->insert($data);
				
				$return['result'] = true;
				$return['message']['title'] = 'Başarılı';
				$return['message']['content'] = 'Oyunuz başarıyla kullanıldı, teşekkürler.';
				m_set_session('review_'.m_u_p('review_id').'','ok');
			}
			else
			{
				$return['result'] = false;
				$return['message']['title'] = 'Hata';
				$return['message']['content'] = 'Bu inceleme için daha önce oy kullanmışsınız.';
			}
		}
		echo json_encode($return);
break;
case 'comment_rating':
		$return = array();
		if(m_u_p('comment_id')!='' and $db->table('comments')->where('status','=',1)->where('id','=',m_u_p('comment_id'))->count()>0 and m_u_p('rating')!='')
		{
			if($db->table('ip_likes')->where('ip','=',m_ip())->where('data_type','=','comment')->where('data_id','=',m_u_p('comment_id'))->count()==0)
			{
				if(m_u_p('rating')=='up')
				{
					$db->query("update comments set liked=liked+1 where id='".m_u_p('comment_id')."'");
					$return['total_count'] = $db->table('comments')->where('id','=',m_u_p('comment_id'))->get_var('liked');
					
					m_user_notification_push('comment_like',m_u_p('comment_id'));
				}
				else
				{
					$db->query("update comments set unliked=unliked+1 where id='".m_u_p('comment_id')."'");
					$return['total_count'] = $db->table('comments')->where('id','=',m_u_p('comment_id'))->get_var('unliked');
					m_user_notification_push('comment_unlike',m_u_p('comment_id'));
				}
				
				$data = [
				'ip' => m_ip(),
				'data_type' => 'comment',
				'data_id' => m_u_p('comment_id')
				];
				
				$db->table('ip_likes')->insert($data);
				
				$return['result'] = true;
				$return['message']['title'] = 'Başarılı';
				$return['message']['content'] = 'Oyunuz başarıyla kullanıldı, teşekkürler.';
				m_set_session('comment_'.m_u_p('comment_id').'','ok');
			}
			else
			{
				$return['result'] = false;
				$return['message']['title'] = 'Hata';
				$return['message']['content'] = 'Bu yorum için daha önce oy kullanmışsınız.';
			}
		}
		echo json_encode($return);
break;
case 'product_search':
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
				echo '<li>İçerik Bulunamadı</li>';
			}
			else
			{
				
				foreach($cats as $cat)
				{
					$d_category = m_review::product_last_category($cat);
					echo '<li class="search_category_li"><a href="'.SITE_DOMAIN.'/kategori/'.$d_category['id'].'/'.$d_category['sef'].'">'.preg_replace('#('.m_a_p('q').')#si','<b>$1</b>',$d_category['title']).'</a></li>';
					$products = $db->query("select id,sef,title,MATCH(title) AGAINST ('\"".addslashes(m_a_p('q'))."\"') as score from products where status='1' and c_id LIKE '%[".$d_category['id']."]%' and MATCH(title) AGAINST ('\"".addslashes(m_a_p('q'))."\"') order by score desc limit 5")->fetchAll(PDO::FETCH_ASSOC);
					foreach ($products as $product)
					{
						echo '<li class="search_product_li"><a href="'.SITE_DOMAIN.'/urun/'.$product['id'].'/'.$product['sef'].'-yorumlari">'.preg_replace('#('.m_a_p('q').')#si','<b>$1</b>',$product['title']).'</a></li>';
					}
					
					
				}
			
			}
			
			
		}
break;
case 'user_reviews_search':
		if(mb_strlen(m_a_p('q'),'UTF-8')>2)
		{
			
			
			$user_reviews = $db->table('reviews')->where_set("REPLACE(title,' - ',' ')",'LIKE',"'%".addslashes(m_a_p('q'))."%'")->where('u_id','=',USER['id'])->order('id','desc')->get();
			if($user_reviews['total_count']>0)
			{
			foreach($user_reviews['data'] as $review)
			{
				$total_review_wins = $db->select('sum(amount) as total')->table('user_balances')->where('u_id','=',$review['u_id'])->where('data_type','=','review')->where('data_id','=',$review['id'])->get();
				$reason_for_rejection = '';
				
					if($review['reason_for_rejection']!='')
					{
						
					$reason_for_rejection = '<div class="col-desktop-12 col-mobile-12" style="margin-top:10px;margin-bottom:5px;">
											<b>Bilgi:</b> '.$review['reason_for_rejection'].'
											</div>';	
					}

			echo '
			<div class="white-box" style="margin-bottom:5px;">
			<div class="rows">
			<div class="col-desktop-12 col-mobile-12" style="margin-bottom:5px;">
			<b>İnceleme Adı:</b> <a href="'.SITE_DOMAIN.'/yorumlari/'.$review['id'].'/'.$review['sef'].'">'.$review['title'].'</a>
			</div>
			<div class="col-desktop-3 col-mobile-12" style="margin-bottom:5px;">
			<b>Tarih:</b> '.m_date_to_tr($review['date']).'
			</div>
			<div class="col-desktop-3 col-mobile-12" style="margin-bottom:5px;">
			<b>Durum:</b> '.m_review_status($review['status']).'
			</div>
			<div class="col-desktop-3 col-mobile-12" style="margin-bottom:5px;">
			<b>Görüntülenme:</b> '.number_format($review['views']).'</i>
			</div>
			<div class="col-desktop-3 col-mobile-12" style="margin-bottom:5px;">
			<b>Kazanç:</b> '.m_currency($total_review_wins['data'][0]['total']).'  <i class="fa fa-lira-sign"></i>
			</div>
			'.$reason_for_rejection.'
			</div>	

			</div>';
			}
			}
			else
			{
				echo m_alert('Bilgi','Aramanıza ait bir incelemeniz bulunamadı.');
			}
			
			
		}
break;
case 'review_product_search':
		
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
				echo '<li>İçerik Bulunamadı</li>';
			}
			else
			{
				
				foreach($cats as $cat)
				{
					$d_category = m_review::product_last_category($cat);
					echo '<li class="search_category_li"><a href="'.SITE_DOMAIN.'/kategori/'.$d_category['id'].'/'.$d_category['sef'].'">'.preg_replace('#('.m_a_p('q').')#si','<b>$1</b>',$d_category['title']).'</a></li>';
					$products = $db->query("select id,sef,title,MATCH(title) AGAINST ('\"".addslashes(m_a_p('q'))."\"') as score from products where status='1' and c_id LIKE '%[".$d_category['id']."]%' and MATCH(title) AGAINST ('\"".addslashes(m_a_p('q'))."\"') order by score desc limit 5")->fetchAll(PDO::FETCH_ASSOC);
					foreach ($products as $product)
					{
						echo '<li class="search_product_li"><a href="'.m_permalink('add_review_detail',$product['id']).'">'.preg_replace('#('.m_a_p('q').')#si','<b>$1</b>',$product['title']).'</a></li>';
					}
					
					
				}
			
			}
			
			
		}
break;

case 'brand_search':
		
		$return = array();
		if(mb_strlen(m_a_p('q'),'UTF-8')>2)
		{
		
			$brands = $db->table('brands')->where('status','=','1')->where_set('title','LIKE',"'%".addslashes(m_a_p('q'))."%'")->order('title','asc')->limit(20)->get();
			foreach($brands['data'] as $brand)
			{
			
				
				$return['items'][] = ['id'=>$brand['id'], 'text'=>$brand['title']];
				
			}
			$return['items'][] = ['id'=>'0', 'text'=>'Sonuç bulumadı ( Diğer seçimi tıklayınız. )'];
			$return['total_count'] = $brands['total_count'];
			$return['incomplete_results'] = false;
			echo json_encode($return);
		}
break;
case 'add_review':
		$return = array();
		if(USER)
		{
				$informations = $db->table('products')->where('id','=',m_u_p('p_id'))->order('title','asc')->limit(1)->get();
				$info = $informations['data'][0];
				$week_category = 0;
				if(strstr($info['c_id'],m_setting('week_category')))
				{
					$week_category = 1;
				}
				if($informations['total_count']==0)
				{
					$return['status'] = false;
					$return['msg'] = 'Ürün bulunamadı.';
				}
				else
				{
					if(m_u_p('title')=='' or m_u_p('p_id')=='' or m_u_p('rate')=='')
					{
						$return['status'] = false;
						$return['msg'] = 'İnceleme başlığını boş bıraktığını görüyorum lütfen kontrol edip tekrar denermisin ?';
					}
					else
					{
									$need_image = 4;
									if(USER['editor']==1)
									{
										$need_content_words = 40;
									}
									else
									{
										$need_content_words = 75;
									}
									$check_review_images = check_review_images();
									$check_review_contents_words = check_review_contents_words($need_content_words);
									if($check_review_images<$need_image)
									{
										$return['status'] = false;
										$return['msg'] = 'Açıklamalar için gereken fotoğrafı yüklemediğini görüyorum, lütfen her bir açıklamana fotoğraf ekleyip tekrar denermisin ?';
									}
									else
									{
										if($check_review_contents_words)
										{
											$sef = m_sef(m_u_p('title'));
											$upload = m_image_tmp_uploader('images','review_image_'.$sef.'_'.uniqid().'',true,true,100,100);
											$content = '';
											$n=0;
											foreach($upload as $image)
											{
												$image_url  = m_image_tmp_url($image);
												$image_content  = strip_tags(nl2br($_POST['content'][$n]),"<br>");
$content.='
<div class="review_detail_content">
<div class="review_inner_detail_image">
<img src="'.$image_url.'">
</div>
<div class="review_inner_detail_content">
<p>'.$image_content.'</p>
</div>
</div>
';
$n++;
											}
											
											$data = [
											'week_category' => $week_category,
											'c_id' => $db->table('products')->where('id','=',m_u_p('p_id'))->get_var('c_id'),
											'b_id' => $db->table('products')->where('id','=',m_u_p('p_id'))->get_var('b_id'),
											'u_id' => USER['id'],
											'p_id' => m_u_p('p_id'),
											'title' => ucfirst_tr(m_u_p('title')),
											'content' => $content,
											'sef' => m_sef(m_u_p('title')),
											'price_rate' => m_u_p('price_rate'),
											'rate' => m_u_p('rate'),
											'recommend' => m_u_p('recommend'),
											'status' => 0
											
											];
											
											$review_id = $db->table('reviews')->insert($data);
											review_pointer($review_id);
											$return['status'] = true;
										}
										else
										{
											
											$return['status'] = false;
											$return['msg'] = 'Yaptığın açıklamaların bir kısmı maalesef '.$need.' kelimeden az metinlerden oluşuyor, kontrol edip tekrar denermisin ?';
										
										}
									}
						 
					}
				}
		}
		else
		{
			$return['status'] = false;
			$return['msg'] = 'Oturumunuz sonlanmış görünüyor "farklı bir sekme" açarak giriş yapıktan sonra bu sekmeden işleminize devam ediniz.';
		}
		echo json_encode($return);
		
break;
case 'revise_review':
		$return = array();
		if(USER)
		{
				$reviews = $db->table('reviews')->where('id','=',m_u_p('id'))->where('u_id','=',USER['id'])->where('status','=',3)->get();
				if($reviews['total_count']==0)
				{
					$return['status'] = false;
					$return['msg'] = 'Bu incelemeyi düzenleme yetkiniz bulunmuyor.';
				}
				else
				{
					$review = $reviews['data'][0];
					if(m_u_p('title')=='' or m_u_p('rate')=='')
					{
						$return['status'] = false;
						$return['msg'] = 'İnceleme başlığını boş bıraktığını görüyorum lütfen kontrol edip tekrar denermisin ?';
					}
					else
					{
									$need_image = 4;
									if(USER['editor']==1)
									{
										$need_content_words = 40;
									}
									else
									{
										$need_content_words = 75;
									}
									$check_review_images = check_review_images();
									$check_review_contents_words = check_review_contents_words($need_content_words);
									if($check_review_images<$need_image)
									{
										$return['status'] = false;
										$return['msg'] = 'Açıklamalar için gereken fotoğrafı yüklemediğini görüyorum, lütfen her bir açıklamana fotoğraf ekleyip tekrar denermisin ?';
									}
									else
									{
										if($check_review_contents_words)
										{
											$sef = m_sef(m_u_p('title'));
											$upload = m_image_tmp_uploader('images','review_image_'.$sef.'_'.uniqid().'',true,true,100,100);
											$content = '';
											$n=0;
											foreach($upload as $image)
											{
												$image_url  = m_image_tmp_url($image);
												$image_content  = strip_tags(nl2br($_POST['content'][$n]),"<br>");
$content.='
<div class="review_detail_content">
<div class="review_inner_detail_image">
<img src="'.$image_url.'">
</div>
<div class="review_inner_detail_content">
<p>'.$image_content.'</p>
</div>
</div>
';
$n++;
											}
											
											$data = [
											'title' => ucfirst_tr(m_u_p('title')),
											'content' => $content,
											'sef' => m_sef(m_u_p('title')),
											'price_rate' => m_u_p('price_rate'),
											'rate' => m_u_p('rate'),
											'revised' => $review['revised']+1,
											'plagiarism' => 0,
											'status' => 0
											
											];
											
											$review_id = $db->table('reviews')->where('id','=',$review['id'])->update($data);
											review_pointer($review_id);
											$return['status'] = true;
										}
										else
										{
											
											$return['status'] = false;
											$return['msg'] = 'Yaptığın açıklamaların bir kısmı maalesef '.$need.' kelimeden az metinlerden oluşuyor, kontrol edip tekrar denermisin ?';
										
										}
									}
						 
					}
				}
		}
		else
		{
			$return['status'] = false;
			$return['msg'] = 'Oturumunuz sonlanmış görünüyor "farklı bir sekme" açarak giriş yapıktan sonra bu sekmeden işleminize devam ediniz.';
		}
		echo json_encode($return);
		
break;
case 'login':
	$result = array();
	if(USER)
	{
		$result['status'] = false;
		$result['error'] = 'Zaten üye girişi yapılmış.';
	}
	else
	{
			if(m_u_p('email')=='' or m_u_p('password')=='')
			{
				$result['status'] = false;
				$result['error'] = 'Lütfen tüm alanları doldurun.';
			}
			else
			{
				$informations = $db->table('users')->where('email','=',m_u_p('email'))->where('password','=',m_password(m_u_p('password')))->order('id','desc')->get();
				if($informations['total_count']==0)
				{
					$result['status'] = false;
					$result['error'] = 'Email Adresi veya şifre geçersiz. Lütfen tekrar deneyiniz.';
				}
				else
				{	
								$info = $informations['data'][0];
								if($info['banned_msg']=='')
								{
									
										m_set_session('m_user',$info['id']);
										$data = [
										'last_login' => $db->now(),
										'last_ip' => m_ip()
										];
										$query = $db->table('users')->where('id','=',$info['id'])->update($data);
										$result['status'] = true;
								}
								else
								{
							
									$result['status'] = false;
									$result['error'] = 'Yasaklandınız. <br> Bitiş Süresi: '.$info['ban_finish_time'].' <br> Yasaklanma Nedeni: '.$info['banned_msg'].'';
								}
				}
			}
		
	}
	echo json_encode($result);
break;
case 'register':
	$result = array();
	if(USER)
	{
		$result['status'] = false;
		$result['error'] = 'Zaten üye girişi yapılmış.';
	}
	else
	{
		
   
       
		if(m_u_p('captcha')==m_get_session('captcha'))
		{
			if(m_u_p('user_agreement')=='')
			{
				$result['status'] = false;
				$result['error'] = 'Lütfen üyelik sözleşmesini kabul ediniz.';
			}
			else
			{
				if(m_u_p('username')=='' or m_u_p('password')=='' or m_u_p('email')=='' or m_u_p('gender')=='')
				{
					$result['status'] = false;
					$result['error'] = 'Lütfen tüm alanları doldurun.';
				}
				else
				{
					if(preg_match('/^[a-zA-Z0-9_.\-ğüşıöçĞÜŞİÖÇ]*$/si',m_u_p('username')) and preg_match('#([a-zA-ZğüşıöçĞÜŞİÖÇ])#si',m_u_p('username')) and mb_strlen(m_u_p('username'))<=14 and mb_strlen(m_u_p('username'))>=6)
					{
						if($db->table('users')->where('username','=',m_u_p('username'))->count()==0)
						{
							if (filter_var(m_u_p('email'), FILTER_VALIDATE_EMAIL))
							{
								
								if($db->table('users')->where('email','=',m_u_p('email'))->count()==0)
								{
										if(m_u_p('gender')=='Erkek')
										{
											$gender = 'Erkek';
										}
										else
										{
											$gender = 'Kadın';
										}
										if(m_u_p('referer')=='')
										{
										   $detect_referer = '0';
										}
										else
										{
										   $referer_user_count = $db->table('users')->where('referer_key','=',m_u_p('referer'))->count();
										   if($referer_user_count>0)
										   {
											   $detect_referer = $db->table('users')->where('referer_key','=',m_u_p('referer'))->get_var('id');
											   
										   }
										   else
										   {
											   $detect_referer = 0;
										   }
										}
										
										$hash  = md5(uniqid());
										$data = [
										'activation_key' => '',
										'referer_key' => md5("".time()."-".uniqid().""),
										'referer' => $detect_referer,
										'username' => m_u_p('username'),
										'phone' => m_u_p('phone'),
										'email' => m_u_p('email'),
										'gender' => $gender,
										'password' => m_password(m_u_p('password')),
										'sef' => m_username_sef(m_u_p('username')),
										'register_date' => $db->now(),
										'register_ip' => m_ip(),
										'last_login' => $db->now(),
										'last_ip' => m_ip(),
										'status' => 1
										
										];
										$query = $db->table('users')->insert($data);
										m_set_session('referer','');
										m_set_session('m_user',$query);
										if($query)
										{
											$result['status'] = true;
										}
										else
										{
											$result['status'] = false;
											$result['error'] = 'Üyelik oluşturulurken bir hata oluştu.';
										}
									
								}
								else
								{
									$result['status'] = false;
									$result['error'] = 'Email adresi kullanılıyor. Lütfen tekrar deneyiniz.';
								}
							
							}
							else
							{
								$result['status'] = false;
								$result['error'] = 'Lütfen geçerli bir email adresi yazınız.';
							}
						}
						else
						{
								$result['status'] = false;
								$result['error'] = 'Kullanıcı adı kullanılıyor. Lütfen tekrar deneyiniz.';
						}
					}
					else
					{
						$result['status'] = false;
						$result['error'] = 'Lütfen kullanıcı adınızda yalnızca harfleri (a-z), rakamları ve -_ işaretini kullanın. Kullanıcı adınız 6 ile 14 karakter arasında olmalı ve en az 1 harf olmalıdır.';
					}
				}
			}
		}
		else
		{
			$result['status'] = false;
			$result['error'] = 'Robot doğrulamasını yanlış. Lütfen tekrar deneyiniz.';
		}
		
	}
	echo json_encode($result);
	
break;


}

}