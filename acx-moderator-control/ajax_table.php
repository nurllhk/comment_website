<?php
require_once('../init.php');
if(!m_admin_check())
{
	m_redirect(MADMIN_URL.'/login.php');
}

if(m_a_p('type'))
{
	if(m_u_p('page_no'))
	{
		$_GET['page_no'] = m_u_p('page_no');
	}
	switch(m_a_p('type'))
	{
		case 'data_table':
			
			$available_tables = array(
			'categories',
			'brands',
			'products',
			'reviews',
			'users',
			'comments'
			);
			if(in_array(m_u_p('table'),$available_tables))
			{
				$table = m_u_p('table');
				$q = m_u_p('q');
				$filters = m_u_p('filters');
				$like_filters = m_u_p('like_filters');
				$order = m_u_p('order');
				$order_by = m_u_p('order_by');
				$null_filter = m_u_p('null_filter');
				$not_null_filter = m_u_p('not_null_filter');
				
				$informations = $db->table($table);
				$data_table = new data_table();
				$data_table->admin_url = MADMIN_URL;
				$data_table->table = $table;
				
				
				switch($table)
				{
					case 'products':
						
						$data_table->edit_page = 'product';
						$data_table->status_zero = 'Pasif';
						$data_table->status_one = 'Aktif';
						if($q!='')
						{
							$informations->where_set('title','LIKE',"'%".$q."%'");
						}
						
					
					break;
					case 'brands':
						
						$data_table->edit_page = 'brand';
						$data_table->status_zero = 'Pasif';
						$data_table->status_one = 'Aktif';
						if($q!='')
						{
							$informations->where_set('title','LIKE',"'%".$q."%'");
						}
						
					
					break;
					case 'categories':
						
						$data_table->edit_page = 'category';
						$data_table->status_zero = 'Pasif';
						$data_table->status_one = 'Aktif';
						if($q!='')
						{
							$informations->where_set('title','LIKE',"'%".$q."%'");
						}
						
					
					break;
					case 'users':
						
						$data_table->edit_page = 'user';
						$data_table->status_zero = 'Pasif';
						$data_table->status_one = 'Aktif';
						if($q!='')
						{
							$informations->where_set('( username','LIKE',"'%".$q."%'")->where_set('email','LIKE',"'%".$q."%'",'OR',')');
						}
						
					
					break;
					case 'comments':
						
						$data_table->edit_page = 'comment_detail';
						$data_table->status_zero = 'Beklemede';
						$data_table->status_one = 'Onaylı';
						if($q!='')
						{
							$informations->where_set('content','LIKE',"'%".$q."%'");
						}
						
					
					break;
					case 'reviews':
						
						$data_table->edit_page = 'review_detail';
						$data_table->status_zero = 'Beklemede';
						$data_table->status_one = 'Yayınlandı';
						$data_table->status_three = 'Düzenleme B.';
						$data_table->status_four = 'Yayınlanmayı B.';
						$informations->where('plagiarism','=',1);
						if($q!='')
						{
							$informations->where_set('title','LIKE',"'%".$q."%'");
						}
						if(m_u_p('problem')=='true')
						{
							$informations->where('pay_review','=','0')->where_set('DATE(date)','>=',"'2022-05-18'");
						}
						
						
					
					break;
				}
				
				foreach($filters as $key => $value)
				{
					if($value!='')
					{
						$informations->where($key,'=',$value);
					}
				}
				foreach($like_filters as $key => $value)
				{
					if($value!='')
					{
						$informations->where_set($key,'LIKE',"'%".$value."%'");
					}
				}
				if($null_filter!='')
				{
					
						$informations->where_set("( $null_filter",'=',"''")->where_set($null_filter,'IS','NULL','OR',')');
					
				}
				if($not_null_filter!='')
				{
					
						$informations->where_set("$not_null_filter",'!=',"''")->where_set($not_null_filter,'IS','NOT NULL');
					
				}
				
				
				
				$informations = $informations->order($order,$order_by)->pagination(25)->get();
				
				
				$bulk_check = false;
				if($informations['total_count']>0)
				{
					if($table=='products')
					{
						foreach($informations['data'] as $info)
						{
							$data_table->add_card();
							$data_table->add_card_info('view','Sitede Gör');
							$data_table->add_card_info('checkbox','Seç');
							$data_table->add_card_info('view_url',m_permalink('product',$info['sef'],$info['id']));
							$data_table->add_card_info('status',$info['status']);
							$data_table->add_card_info('views',$info['views']);
							$data_table->add_card_info('id',$info['id']);
							$data_table->add_card_row('Başlık',$info['title']);
							$data_table->add_card_row('Kategori',m_review::product_all_category($info['c_id']));
							$data_table->add_card_row('<b class="text-warning">Onay B. İ.</b>',$db->table('reviews')->where('p_id','=',$info['id'])->where('status','=',0)->count());
							$data_table->add_card_row('<b class="text-success">Onaylı İ.</b>',$db->table('reviews')->where('p_id','=',$info['id'])->where('status','=',1)->count());
							$data_table->add_card_row('<b class="text-danger">Red İ.</b>',$db->table('reviews')->where('p_id','=',$info['id'])->where('status','=',2)->count());
						}
						$bulk_check = true;
					}
					if($table=='brands')
					{
						foreach($informations['data'] as $info)
						{
							$data_table->add_card();
							$data_table->add_card_info('view','Sitede Gör');
							$data_table->add_card_info('view_url',m_permalink('brand',$info['sef'],$info['id']));
							$data_table->add_card_info('status',$info['status']);
							$data_table->add_card_info('views',$info['views']);
							$data_table->add_card_info('id',$info['id']);
							$data_table->add_card_row('Başlık',$info['title']);
						}
					}
					if($table=='categories')
					{
						foreach($informations['data'] as $info)
						{
							$data_table->add_card();
							$data_table->add_card_info('view','Sitede Gör');
							$data_table->add_card_info('view_url',m_permalink('category',$info['sef'],$info['id']));
							$data_table->add_card_info('status',$info['status']);
							$data_table->add_card_info('views',$info['views']);
							$data_table->add_card_info('id',$info['id']);
							$data_table->add_card_row('Başlık',$info['title']);
							if($info['c_id']==0)
							{
								$top_category = 'Yok';
							}
							else
							{
								$top_category = $db->table('categories')->where('id','=',$info['c_id'])->get_var('title');
							}
							$data_table->add_card_row('Üst Kategori',$top_category);
						}
					}
					if($table=='users')
					{
						foreach($informations['data'] as $info)
						{
							$total_withdraw = $db->select('SUM(amount) as total')->table('withdrawals')->where('u_id','=',$info['id'])->where('status','=',1)->get();
							$total_withdraw = $total_withdraw['data'][0]['total'];
							$data_table->add_card();
							$data_table->add_card_info('view','Sitede Gör');
							$data_table->add_card_info('view_url',m_permalink('user_profile',$info['sef'],$info['id']));
							$data_table->add_card_info('status',$info['status']);
							$data_table->add_card_info('id',$info['id']);
							$data_table->add_card_row('Kullanıcı Adı',$info['username']);
							$data_table->add_card_row('Bakiye',m_currency($info['balance']).' TL');
							$data_table->add_card_row('İnceleme',$db->table('reviews')->where('u_id','=',$info['id'])->count());
							$data_table->add_card_row('Yorum',$db->table('comments')->where('u_id','=',$info['id'])->count());
							$data_table->add_card_row('T.Para Çekimi',m_currency($total_withdraw).' TL');
							$data_table->add_card_row('Son Giriş',m_date_to_tr($info['last_login']));
							$data_table->add_card_row('Kayıt Tarihi',m_date_to_tr($info['register_date']));
						}
					}
					if($table=='comments')
					{
						foreach($informations['data'] as $info)
						{
							$review_detail = $db->table('reviews')->where('id','=',$info['r_id'])->get();
							$review_detail = $review_detail['data'][0];
							$data_table->add_card();
							$data_table->add_card_info('view','İncelemeyi Gör');
							$data_table->add_card_info('view_url',m_permalink('review',$review_detail['sef'],$review_detail['id']));
							$data_table->add_card_info('date',$info['date']);
							$data_table->add_card_info('status',$info['status']);
							$data_table->add_card_info('id',$info['id']);
							$data_table->add_card_info('approve','comment_approve');
							$data_table->add_card_row('Kullanıcı',m_user('username',$info['u_id']));
							$data_table->add_card_row('İnceleme',$review_detail['title']);
							$data_table->add_card_row('Yorum',$info['content'],'textarea');
						}
					}
					if($table=='reviews')
					{
						foreach($informations['data'] as $info)
						{
							$product_detail = $db->table('products')->where('id','=',$info['p_id'])->get();
							$product_detail = $product_detail['data'][0];
							$data_table->add_card();
							$data_table->add_card_info('view','İncelemeyi Gör');
							$data_table->add_card_info('view_url',m_permalink('review',$info['sef'],$info['id']));
							$data_table->add_card_info('date',$info['date']);
							$data_table->add_card_info('status',$info['status']);
							$data_table->add_card_info('id',$info['id']);
							$data_table->add_card_info('original_content',$info['original_content']);
							$data_table->add_card_info('copy_content',$info['copy_content']);
							$data_table->add_card_info('copy_review_reject','copy_review_reject');
							$data_table->add_card_row('Kullanıcı',m_user('username',$info['u_id']));
							$data_table->add_card_row('Başlık',$info['title']);
							$data_table->add_card_row('Ürün',$product_detail['title']);
							$data_table->add_card_row('Görüntülenme',m_number_format($info['views']));
							$data_table->add_card_row('Kazanma',m_data_table_status_icon($info['pay_review']));
							$data_table->add_card_row('Editör',m_data_table_status_icon(m_user('editor',$info['u_id'])));
						}
					}
					echo $data_table->generate($informations['total_count'],$informations['total_page'],$informations['current_page'],$bulk_check);
				}
				else
				{
					echo m_alert('Hata','Tabloda veya aramanıza ait bir sonuç bulunamadı.');
				}
			}
		break;
	}
}
?>