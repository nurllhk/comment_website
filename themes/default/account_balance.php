<?php
	m_header();
	if($_POST)
	{
		if(m_user('balance')>=m_setting('min_withdraw'))
		{
				if(m_u_p('buyer_phone')=='' or m_u_p('buyer_identity_number')=='' or m_u_p('buyer_name')=='' or m_u_p('buyer_lastname')=='' or m_u_p('buyer_birth_year')=='')
				{
					$withdraw_result =  m_alert('Hata','Alıcı TC Kimlik Numarası, Alıcı Adı, Alıcı Soyadı, Alıcı Doğum Yılı, Alıcı Telefon Numarası boş bırakılamaz.');
				}
				else
				{
					if(identity_check(m_u_p('buyer_identity_number'),m_u_p('buyer_name'),m_u_p('buyer_lastname'),m_u_p('buyer_birth_year')))
					{
						
						$data = [
						'u_id' => USER['id'],
						'bank_buyer' =>m_u_p('buyer_name')." ".m_u_p('buyer_lastname'),
						'bank_iban' => m_u_p('bank_iban'),
						'buyer_phone' => m_u_p('buyer_phone'),
						'buyer_identity_number' => m_u_p('buyer_identity_number'),
						'buyer_birth_year' => m_u_p('buyer_birth_year'),
						'amount' => m_user('balance'),
						'date' => $db->now(),
						'status' => 0
						
						];
						$withdraw_id = $db->table('withdrawals')->insert($data);
						user_balances_add(false,USER['id'],m_user('balance'),'withdraw',$withdraw_id,'Para Çekimi');
						$withdraw_result =  m_alert('Başarılı','Çekim talebiniz alınmıştır en kısa sürede işlenecektir...');
						
					}
					else
					{
						$withdraw_result =  m_alert('Hata','TC Kimlik bilgileri doğrulanamadı.');
					}
				}
		}
		else
		{
				$withdraw_result =  m_alert('Hata','Bakiyeniz minumum çekim tutarının altında.');
		}
	}
?>   
<div class="main">
	<div class="container">
		<div class="row">

		
		<div class="col-xl-12 col-lg-12 col-sm-12">
		<div class="page_head">
		<div class="page_icon"><i class="fa fa-wallet"></i></div>
		<div class="page_title"><h1>Bakiye İşlemleri</h1></div>
		</div>
		<div class="row">
		
		<div class="col-xl-4 col-lg-4 col-sm-4 col-12">
			
			<?php require_once('account_part.php'); ?>
		
		</div>
		
		<div class="col-xl-8 col-lg-8 col-sm-8 col-12">
			
			<div class="card">
			<div class="card-body">
			
				  <?php
				  $week_category = m_setting('week_category');
				  $week_category = str_replace('[','',$week_category);
				  $week_category = str_replace(']','',$week_category);
				  $week_category_details = $db->table('categories')->where('id','=',$week_category)->get_vars();
				  ?>
				  <div class="alert alert-success"><i class="fa fa-star"></i> Haftanın kategorisi olan "<b><?php echo $week_category_details['title']; ?></b>" kategorisindeki ürün/hizmetler için yapacağınız her onaylanan inceleme için ek <?php echo m_setting('week_category_fee'); ?> ücret kazanacağınızı biliyor musunuz ?</a>
				  
				  <br><br>Not: Haftanın kategorisi her hafta değişkenlik gösterebilir.<br><br>
			
				  <?php echo $week_category_details['title']; ?> kategorisinde bulunan ürün/hizmetleri listelemek için <a href="<?php echo m_permalink('category',$week_category_details['sef'],$week_category_details['id']); ?>/liste" class="fw-bold">tıklayın.</a>
				  </div>
				  
				  <div class="alert alert-info"><i class="fa fa-info-circle"></i> Açıklıyorum'da bilgi ve deneyimlerinizi paraya dönüştürebilirsiniz. Her gün onlarca ürün ve hizmet kullanıyorsunuz. Onlar hakkında faydalı yorumlar yazın ve düzenli gelir elde edin. <a href="<?php echo SITE_DOMAIN; ?>/nasil-calisir" class="font-weight-bold">Devamını oku ...</a>
				  </div>
				  <div class="alert alert-danger">
				  <strong>Bakiyeniz:</strong> <span class="user_balance"><?php echo m_currency(USER['balance']); ?></span> <i class="fa fa-lira-sign"></i>
				  </div>
					<?php
						$total_views = $db->select('sum(views) as total')->table('reviews')->where('u_id','=',USER['id'])->where('status','=',1)->get();
						$total_wins = $db->select('sum(amount) as total')->table('user_balances')->where('u_id','=',USER['id'])->where('data_type','=','review')->get();
						$total_referer = $db->select('sum(amount) as total')->table('user_balances')->where('u_id','=',USER['id'])->where('data_type','=','referer_amount')->get();
						$total_time_pay = $db->select('sum(amount) as total')->table('user_balances')->where('u_id','=',USER['id'])->where('data_type','=','time_pay')->get();
						$total_review_pay = $db->select('sum(amount) as total')->table('user_balances')->where('u_id','=',USER['id'])->where('data_type','=','review_first_pay')->get();
						$total_referer_withdrawals = $db->select('sum(amount) as total')->table('user_balances')->where('u_id','=',USER['id'])->where('data_type','=','referer_withdraw_amount')->get();
						$total_withdrawals = $db->select('sum(amount) as total')->table('withdrawals')->where('u_id','=',USER['id'])->where('status','=',1)->get();
					?>
					  <div class="list-group mb-3">
					  <div class="list-group-item">
					  <div class="row">
					  <div class="col-lg-4 col-8 fw-bold">Onaylı İncelemeleriniz:</div>
					  <div class="col-lg-8 col-4"><?php echo m_number_format($db->table('reviews')->where('u_id','=',USER['id'])->where('status','=','1')->count()); ?></div>
					  </div>
					  </div>
					  <div class="list-group-item">
					  <div class="row">
					  <div class="col-lg-4 col-8 fw-bold">T.Görüntülenme:</div>
					  <div class="col-lg-8 col-4"><?php echo m_number_format($total_views['data'][0]['total']); ?></div>
					  </div>
					  </div>
					  </div>
					  <div class="list-group mb-3">
					  <div class="list-group-item">
					  <div class="row">
					  <div class="col-lg-12 col-12 fw-bold text-center">Son 15 Günlük Performans</div>
					  </div>
					  </div>
					  <div class="list-group-item">
					  <div class="row">
					  <div class="col-lg-4 col-8 fw-bold">İnceleme Ekleme Kazancı</div>
					  <div class="col-lg-8 col-4"><?php echo m_currency($total_review_pay['data'][0]['total']); ?> <i class="fa fa-lira-sign"></i></div>
					  </div>
					  </div>
					  <div class="list-group-item">
					  <div class="row">
					  <div class="col-lg-4 col-8 fw-bold">T.Görüntülenme Kazancı</div>
					  <div class="col-lg-8 col-4"><?php echo m_currency($total_wins['data'][0]['total']); ?> <i class="fa fa-lira-sign"></i></div>
					  </div>
					  </div>
					  <div class="list-group-item">
					  <div class="row">
					  <div class="col-lg-4 col-8 fw-bold">Sitede Kalma Kazancı</div>
					  <div class="col-lg-8 col-4"><?php echo m_currency($total_time_pay['data'][0]['total']); ?> <i class="fa fa-lira-sign"></i></div>
					  </div>
					  </div>
					  <div class="list-group-item">
					  <div class="row">
					  <div class="col-lg-4 col-8 fw-bold">Referans Kazancı</div>
					  <div class="col-lg-8 col-4"><?php echo m_currency($total_referer['data'][0]['total']); ?> <i class="fa fa-lira-sign"></i></div>
					  </div>
					  </div>
					  <div class="list-group-item">
					  <div class="row">
					  <div class="col-lg-4 col-8 fw-bold">Referans P.Çekimi Kazanılan</div>
					  <div class="col-lg-8 col-4"><?php echo m_currency($total_referer_withdrawals['data'][0]['total']); ?> <i class="fa fa-lira-sign"></i></div>
					  </div>
					  </div>
					  </div>
					  <div class="list-group mb-3">
					  <div class="list-group-item">
					  <div class="row">
					  <div class="col-lg-4 col-8 fw-bold">Toplam Para Çekimi</div>
					  <div class="col-lg-8 col-4"><?php echo m_currency($total_withdrawals['data'][0]['total']); ?> <i class="fa fa-lira-sign"></i></div>
					  </div>
					  </div>
					  <div class="list-group-item">
					  <div class="row">
					  <div class="col-lg-4 col-8 fw-bold">Referans Bağlantınız</div>
					  <div class="col-lg-8 col-12">
					  <b class="reference_link"><?php echo SITE_DOMAIN; ?>/kayit-ol?referer=<?php echo m_user('referer_key'); ?></b>
					  <br>
					  <span class="btn btn-sm btn-primary reference_link_copy">Kopyala</span>
					  </div>
					  </div>
					  </div>
					  </div>
					  
					  <div class="alert alert-info mt-1 mb-1"><i class="fa fa-info-circle"></i> Referanslarınızın yaptıkları para çekimlerinden <b>%<?php echo m_setting('referer_withdraw_amount'); ?></b> kazanç sağlıyabileceğinizi biliyor muydunuz ?</div>
					<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
		
					  <li class="nav-item" role="presentation">
						<a class="nav-link active tab_datatable" id="pills-withdraw-tab" href="#pills-withdraw" data-bs-toggle="pill" data-bs-target="#pills-withdraw" role="tab" aria-controls="pills-withdraw" aria-selected="true">Çekim</a>
					  </li>
					  <li class="nav-item" role="presentation">
						<a class="nav-link tab_datatable" id="pills-refefers-tab" href="#pills-refefers" data-bs-toggle="pill" data-bs-target="#pills-refefers" role="tab" aria-controls="pills-refefers" aria-selected="false">Referanslar</a>
					  </li>
					  <li class="nav-item" role="presentation">
						<a class="nav-link tab_datatable" id="pills-balances-tab" href="#pills-balances" data-bs-toggle="pill" data-bs-target="#pills-balances" role="tab" aria-controls="pills-balances" aria-selected="false">Bakiye Geçmişi</a>
					  </li>
					</ul>
					<div class="tab-content" id="pills-tabContent">
          
					  <div class="tab-pane fade show active" id="pills-withdraw" role="tabpanel" aria-labelledby="pills-withdraw-tab">
				   
							<?php
							if($_POST)
							{
								echo $withdraw_result;
							}
							?>	
							<br>
							<form method="post" action="" autocomplete="off">
							<div class="mb-3">
								<label class="form-label">Bakiyeniz</label>
								<input type="text" class="form-control" name="amount" value="<?php echo m_currency(m_user("balance")); ?> TL" disabled>
							</div>
							<div class="mb-3">
								<label class="form-label">Alıcı TC Kimlik Numarası</label> 
								<input type="text" class="form-control" name="buyer_identity_number" required><br>
								<label class="form-label "><span class="btn btn-danger">UYARI!<span></label><br>
								<label class="form-label "><span class="">Kullanılan TC kimlik numaralarını farklı hesaplarda kullanmak yasaktır.<span></label>
							</div>
							<div class="mb-3">
								<label class="form-label">Alıcı Adı</label>
								<input type="text" class="form-control" name="buyer_name" required>
							</div>
							<div class="mb-3">
								<label class="form-label">Alıcı Soyadı</label>
								<input type="text" class="form-control" name="buyer_lastname" required>
							</div>
							<div class="mb-3">
								<label class="form-label">Alıcı Doğum Yılı</label>
								<input type="text" class="form-control" name="buyer_birth_year" required>
							</div>
							<div class="mb-3">
								<label class="form-label">Alıcı Telefon Numarası</label>
								<input type="text" class="form-control" name="buyer_phone" required>
							</div>
							<div class="mb-3">
								<label class="form-label">IBAN</label>
								<input type="text" class="form-control" name="bank_iban" required>
							</div>
							<?php echo m_alert('Bilgi','Minumum '.m_currency(m_setting('min_withdraw')).' TL tutarında para çekim talebi verebilirsiniz.'); ?>
							<button type="submit" class="btn btn-default btn-sm"><i class="fa fa-check"></i> Çekim Talebi Ver</button>
							</form>
							
							<br>
							<h4>Çekim Geçmişi</h4>
							<br>
							<div class="card">
							<div class="card-body">
							<?php
							$informations = $db->table('withdrawals')->where('u_id','=',USER['id'])->order('id','desc')->get();
							if($informations['total_count']>0)
							{
							?>
							<table class="table table-bordered nowrap datatable dt-responsive" style="width:100%">
							<thead>
								<tr>
									<th>Alıcı</th>
									<th>Tutar</th>
									<th>Durum</th>
									<th>Yönetici Notu</th>
									<th>Tarih</th>
								</tr>
							</thead>
							<tbody>
							<?php
								foreach($informations['data'] as $info)
								{
									echo '
									<tr>
										<td>'.$info['bank_buyer'].'</td>
										<td>'.m_currency($info['amount']).' <i class="fa fa-lira-sign"></i></td>
										<td>'.m_withdraw_status($info['status']).'</td>
										<td>'.$info['admin_note'].'</td>
										<td>'.m_date_to_tr(m_user('register_date',$info['data_id'])).'</td>
									</tr>';
								}
							?>
							</tbody>
							</table>
							<?php
							}
							else
							{
								echo m_alert('Bilgi','Henüz bir para çekim talebiniz bulunmuyor.');
							}
							?>
							</div>
							</div>
						 
					
					  </div>
					  <div class="tab-pane fade" id="pills-refefers" role="tabpanel" aria-labelledby="pills-refefers-tab">
						<div class="card">
						<div class="card-body">
							<?php
							$informations = $db->table('users')->where('referer','=',USER['id'])->where('status','=',1)->order('id','desc')->get();
							if($informations['total_count']>0)
							{
							?>
							<table class="table table-bordered nowrap datatable dt-responsive" style="width:100%">
							<thead>
								<tr>
									<th>Kullanıcı Adı</th>
									<th>Kazanç</th>
									<th>Kayıt Tarihi</th>
								</tr>
							</thead>
							<tbody>
							<?php
								foreach($informations['data'] as $info)
								{
									$kazanc = $db->table('user_balances')->where('u_id','=',USER['id'])->where('data_id','=',$info['id'])->where('data_type','=','referer_amount')->get_var('amount');
									if($kazanc=='')
									{
										$kazanc = 0;
									}
									$kazanc = m_currency($kazanc);
									echo '
									<tr>
										<td>'.$info['username'].'</td>
										<td>'.$kazanc.'</td>
										<td>'.m_date_full_to_tr($info['register_date']).'</td>
									</tr>';
								}
							?>
							</tbody>
							</table>
							<?php
							}
							else
							{
								echo m_alert('Bilgi','Henüz bir referansınız bulunmuyor.');
							}
							?>
						</div>
						</div>
						
						
						
						
					  </div>
					  <div class="tab-pane fade" id="pills-balances" role="tabpanel" aria-labelledby="pills-balances-tab">
						<div class="card">
						<div class="card-body">
						
							<div class="alert alert-info"><i class="fa fa-info-circle"></i> Son 5.000 İşlem ( Son 15 Gün )</div>
							<select class="balance_filter form-select mb-2 mt-2">
							<option value="">Bakiye Geçmişini Filtrele</option>
							<option value="İnceleme Ödemesi">İnceleme Ödemesi</option>
							<option value="Haftanın Kategorisi İnceleme Ödemesi">Haftanın Kategorisi İnceleme Ödemesi</option>
							<option value="İnceleme Görüntülenme">İnceleme Görüntülenme</option>
							<option value="Sitede Kalma Kazancı">Sitede Kalma Kazancı</option>
							<option value="Referans Para Çekimi">Referans Para Çekimi</option>
							<option value="Para Çekimi">Para Çekimi</option>
							</select>
							<table id="balance_table" class="table table-bordered nowrap datatable dt-responsive" style="width:100%">
							<thead>
								<tr>
									<th>Tarih</th>
									<th>İşlem</th>
									<th>Tutar</th>
									<th>Önceki Bakiye</th>
									<th>Son Bakiye</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$informations = $db->table('user_balances')->where('u_id','=',USER['id'])->order('id','desc')->limit(5000)->get();
							if($informations['total_count']>0)
							{
								foreach($informations['data'] as $info)
								{
									echo '
									<tr>
										<td>'.m_date_to_tr($info['date']).'</td>
										<td>'.$info['description'].'</td>
										<td>'.m_currency($info['amount']).' <i class="fa fa-lira-sign"></i></td>
										<td>'.m_currency($info['before_balance']).' <i class="fa fa-lira-sign"></i></td>
										<td>'.m_currency($info['last_balance']).' <i class="fa fa-lira-sign"></i></td>
									</tr>';
								}
							}
							?>
							</tbody>
							</table>
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
	</div>
</div>
<?php
	m_footer();
?>
					