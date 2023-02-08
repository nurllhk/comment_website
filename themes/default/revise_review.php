<?php
	m_header();
	$reviews = $db->table('reviews')->where('id','=',m_u_g('id'))->where('u_id','=',m_user('id'))->where('status','=',3)->get();
	if($reviews['total_count']=='0')
	{
		m_redirect(SITE_DOMAIN);
	}
	$review = $reviews['data'][0];
	$rejected_type = $db->table('rejected_types')->where('id','=',$review['rejected_type'])->get_vars();
	preg_match_all('#<div class="review_inner_detail_content">(.*?)</div>#si',$review['content'],$review_parts);
	$n = 0;
	foreach($review_parts[1] as $r_part)
	{
		$review_part[$n] = trim(strip_tags(preg_replace("/<br\W*?\/>/", "\n", $r_part)));
		$n++;
	}
?>   
<div class="main">
	<div class="container">
		<div class="page_head">
		<div class="page_icon"><i class="fa fa-pen-square"></i></div>
		<div class="page_title"><h1>İnceleme Düzenleme İşlemi</h1></div>
		</div>
		<div class="mt-3 review_form_container">
		<div class="row">
					<?php
							$review_list = new m_review();
							$review_list->template 					= 'default';
							$review_list->template_col 				= 'col-xl-12 col-lg-12 col-sm-12';
							$review_list->query_options 			= "where id='".$review['p_id']."'";
							$review_list->order 					= "order by id desc";
							$review_list->limit 					= 1;
							$result = $review_list->list_products();
							echo $result['html'];
					?>
		</div>
		<form class="revise_review_form" method="post" action="#" enctype="multipart/form-data" novalidate>
		<input class="form-control" name="type" value="revise_review" type="hidden">
		<input class="form-control" name="id" value="<?php echo $review['id']; ?>" type="hidden">
		<div class="review_add_card revise_review">
				<div class="review_add_card_content">
				
							<div class="mascot"><img src="<?php echo UPLOAD_URL; ?>/mascot.png" alt="Mascot"></div>
							<div class="review_add_card_content_inner">
							<div class="review_add_content_result"></div>
								<div class="review_add_step active">
									<div class="review_add_card_content_question">
										<div class="question">
										Tekrardan Merhaba, İncelemen için <?php echo $rejected_type['title']; ?> nedeniyle düzenleme istendiğini görüyorum, üzülme düzenlemen için sana yardımcı olacağım!
										</div>
									</div>
									<div class="question_after">
										<a href="javascript:void(0);" class="rw_btn np_step" data-type="next"><i class="fa fa-check-square"></i> <span>Hadi Düzenlemeye Başlayalım</span></a>
									</div>
								</div>
								<div class="review_add_step">
									<div class="progress mb-2" style="height:20px">
										  <div class="progress-bar bg-danger" role="progressbar" style="width: 16.66%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">1 / 6</div>
									</div>
									<div class="review_add_card_content_question">
										<div class="question">
										Öncelikle Tavsiye edip etmediğini belirle, kısa bir başlık ekle ve puanlamanı yap.
										</div>
									</div>
									<div class="question_after">
										<div class="mb-3">
										<input type="radio" class="btn-check" name="recommend" id="success-outlined" value="1" autocomplete="off" <?php if($review['recommend']==1) { echo 'checked'; } ?>>
										<label class="btn btn-outline-success radio_btn w-100 mb-2" for="success-outlined"><i class="fa fa-thumbs-up"></i> Evet</label>
										<input type="radio" class="btn-check" name="recommend" id="danger-outlined" value="0" autocomplete="off" <?php if($review['recommend']==1) { echo 'checked'; } ?>>
										<label class="btn btn-outline-danger radio_btn w-100 mb-2" for="danger-outlined"><i class="fa fa-thumbs-down"></i> Hayır</label>
										</div>
										<div class="mb-3">
										<input class="form-control mb-2" name="title" type="text" placeholder="İnceleme Başlığı - Örneğin: Pratik makyaj temizleme için ideal" value="<?php echo $review['title']; ?>">
										<select class="form-select w-100" name="rate">
											<option value="1" <?php if($review['rate']==1) { echo 'selected'; } ?>>PUAN: 1</option>
											<option value="2" <?php if($review['rate']==2) { echo 'selected'; } ?>>PUAN: 2</option>
											<option value="3" <?php if($review['rate']==3) { echo 'selected'; } ?>>PUAN: 3</option>
											<option value="4" <?php if($review['rate']==4) { echo 'selected'; } ?>>PUAN: 4</option>
											<option value="5" <?php if($review['rate']==5) { echo 'selected'; } ?>>PUAN: 5</option>
										</select>
										</div>
										<a href="javascript:void(0);" class="rw_btn_prev np_step" data-type="prev"><i class="fa fa-arrow-alt-circle-left"></i> <span>Önceki Adım</span></a>
										<a href="javascript:void(0);" class="rw_btn np_step" data-type="next"><i class="fa fa-arrow-alt-circle-right"></i> <span>Sonraki Adım</span></a>
									</div>
								</div>
								<div class="review_add_step">
									<div class="progress mb-2" style="height:20px">
										  <div class="progress-bar bg-danger" role="progressbar" style="width: 33.33%" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100">2 / 6</div>
									</div>
									<div class="review_add_card_content_question">
										<div class="question">
										Performans açısından fiyatını hakediyor mu ?
										</div>
									</div>
									<div class="question_after">
										<div class="mb-3">
										<input type="radio" class="btn-check" name="price_rate" id="success-outlined2" value="1" autocomplete="off"  <?php if($review['price_rate']==1) { echo 'checked'; } ?>>
										<label class="btn btn-outline-success radio_btn w-100 mb-2" for="success-outlined2"><i class="fa fa-thumbs-up"></i> Evet</label>
										<input type="radio" class="btn-check" name="price_rate" id="danger-outlined2" value="0" autocomplete="off" <?php if($review['price_rate']==0) { echo 'checked'; } ?>>
										<label class="btn btn-outline-danger radio_btn w-100 mb-2" for="danger-outlined2"><i class="fa fa-thumbs-down"></i> Hayır</label>
										</div>
										<a href="javascript:void(0);" class="rw_btn_prev np_step" data-type="prev"><i class="fa fa-arrow-alt-circle-left"></i> <span>Önceki Adım</span></a>
										<a href="javascript:void(0);" class="rw_btn np_step" data-type="next"><i class="fa fa-arrow-alt-circle-right"></i> <span>Sonraki Adım</span></a>
									</div>
								</div>
								<div class="review_add_step">
									<div class="progress mb-2" style="height:20px">
										  <div class="progress-bar bg-danger" role="progressbar" style="width: 49.98%" aria-valuenow="49" aria-valuemin="0" aria-valuemax="100">3 / 6</div>
									</div>
									<div class="review_add_card_content_question">
										<div class="question">
										Ürün/hizmeti en az 75 kelime ile anlatır mısın ? Ve ürüne ait bir fotoğraf eklemelisin Örn. Ne zaman aldın ? Ne zamandır kullanıyorsun? Nereden temin ettin ? 
										</div>
									</div>
									<div class="question_after">
										<div class="mb-3">
										
											<textarea name="content[]" class="form-control w-100 review_add_content capture_1" placeholder="Lütfen tüm harfleri büyük yazmaktan kaçınınız. &#10;&#10;Merhaba arkadaşlar, selam arkadaşlar v.b girişlerle başlamayınız bu içeriğinizin puanlamasını düşürecektir."><?php echo $review_part[0]; ?></textarea>
											<span class="mt-1 mb-1 btn btn-default btn-sm microphone_write" rel="capture_1"><i class="fa fa-microphone"></i> <span>Mikrofonu Kullan</span></span>
											<div class="review_add_content_word_count"><div class="total">0</div><div class="slash">/</div><div class="need">75</div></div>
											<div class="mt-3 mb-3">
											<div class="alert alert-info mb-1"><i class="fa fa-info-circle"></i> Düzenleme işlemlerinde fotoğrafı yeniden yüklemelisiniz</div>
											<div class="row">
												<div class="col-lg-2 col-sm-12">
													<img src="<?php echo UPLOAD_URL; ?>/blank.webp" class="img-thumbnail review_content_image" alt="Görsel">
												</div>
												<div class="col-lg-10 col-sm-12">
													<input type="file" name="images[]" class="form-control mt-1 review_add_content_image" accept="image/*">
												</div>
											</div>
											</div>
										</div>
										<a href="javascript:void(0);" class="rw_btn_prev np_step" data-type="prev"><i class="fa fa-arrow-alt-circle-left"></i> <span>Önceki Adım</span></a>
										<a href="javascript:void(0);" class="rw_btn np_step" data-type="next"><i class="fa fa-arrow-alt-circle-right"></i> <span>Sonraki Adım</span></a>
									</div>
								</div>
								<div class="review_add_step">
									<div class="progress mb-2" style="height:20px">
										  <div class="progress-bar bg-danger" role="progressbar" style="width: 66.64%" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100">4 / 6</div>
									</div>
									<div class="review_add_card_content_question">
										<div class="question">
										Harika gidiyorsun! Bu ürün tecrübelerini en az 75 kelime ile "tanıtmak" istersen nasıl tanıtırdın? Ve ürüne ait kendi çektiğin bir fotoğraf ekler misin ?
										</div>
									</div>
									<div class="question_after">
										<div class="mb-3">
										
											<textarea name="content[]" class="form-control w-100 review_add_content capture_2" placeholder="Lütfen tüm harfleri büyük yazmaktan kaçınınız."><?php echo $review_part[1]; ?></textarea>
											<span class="mt-1 mb-1 btn btn-default btn-sm microphone_write" rel="capture_2"><i class="fa fa-microphone"></i> <span>Mikrofonu Kullan</span></span>
											<div class="review_add_content_word_count"><div class="total">0</div><div class="slash">/</div><div class="need">75</div></div>
											<div class="mt-3 mb-3">
											<div class="alert alert-info mb-1"><i class="fa fa-info-circle"></i> Düzenleme işlemlerinde fotoğrafı yeniden yüklemelisiniz</div>
											<div class="row">
												<div class="col-lg-2 col-sm-12">
													<img src="<?php echo UPLOAD_URL; ?>/blank.webp" class="img-thumbnail review_content_image" alt="Görsel">
												</div>
												<div class="col-lg-10 col-sm-12">
													<input type="file" name="images[]" class="form-control mt-1 review_add_content_image" accept="image/*">
												</div>
											</div>
											</div>
										</div>
										<a href="javascript:void(0);" class="rw_btn_prev np_step" data-type="prev"><i class="fa fa-arrow-alt-circle-left"></i> <span>Önceki Adım</span></a>
										<a href="javascript:void(0);" class="rw_btn np_step" data-type="next"><i class="fa fa-arrow-alt-circle-right"></i> <span>Sonraki Adım</span></a>
									</div>
								</div>
								<div class="review_add_step">
									<div class="progress mb-2" style="height:20px">
										  <div class="progress-bar bg-danger" role="progressbar" style="width: 83.33%" aria-valuenow="83" aria-valuemin="0" aria-valuemax="100">5 / 6</div>
									</div>
									<div class="review_add_card_content_question">
										<div class="question">
										Sadece 2 adım kaldı! Peki "deneyimlerini ve tecrübelerini" lütfen 1 fotoğraf ve en az 75 kelime ile anlatır mısın ?
										</div>
									</div>
									<div class="question_after">
										<div class="mb-3">
										
											<textarea name="content[]" class="form-control w-100 review_add_content capture_3" placeholder="Lütfen tüm harfleri büyük yazmaktan kaçınınız."><?php echo $review_part[2]; ?></textarea>
											<span class="mt-1 mb-1 btn btn-default btn-sm microphone_write" rel="capture_3"><i class="fa fa-microphone"></i> <span>Mikrofonu Kullan</span></span>
											<div class="review_add_content_word_count"><div class="total">0</div><div class="slash">/</div><div class="need">75</div></div>
											<div class="mt-3 mb-3">
											<div class="alert alert-info mb-1"><i class="fa fa-info-circle"></i> Düzenleme işlemlerinde fotoğrafı yeniden yüklemelisiniz</div>
											<div class="row">
												<div class="col-lg-2 col-sm-12">
													<img src="<?php echo UPLOAD_URL; ?>/blank.webp" class="img-thumbnail review_content_image" alt="Görsel">
												</div>
												<div class="col-lg-10 col-sm-12">
													<input type="file" name="images[]" class="form-control mt-1 review_add_content_image" accept="image/*">
												</div>
											</div>
											</div>
										</div>
										<a href="javascript:void(0);" class="rw_btn_prev np_step" data-type="prev"><i class="fa fa-arrow-alt-circle-left"></i> <span>Önceki Adım</span></a>
										<a href="javascript:void(0);" class="rw_btn np_step" data-type="next"><i class="fa fa-arrow-alt-circle-right"></i> <span>Sonraki Adım</span></a>
									</div>
								</div>
								<div class="review_add_step">
									<div class="progress mb-2" style="height:20px">
										  <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">6 / 6</div>
									</div>
									<div class="review_add_card_content_question">
										<div class="question">
										Anladım, son olarak "kullanıcılara vereceğin mesajı" en az 75 kelime ile anlatıp ürüne ait son bir fotoğraf ekler misin ?
										</div>
									</div>
									<div class="question_after">
										<div class="mb-3">
										
											<textarea name="content[]" class="form-control w-100 review_add_content capture_4" placeholder="Lütfen tüm harfleri büyük yazmaktan kaçınınız."><?php echo $review_part[3]; ?></textarea>
											<span class="mt-1 mb-1 btn btn-default btn-sm microphone_write" rel="capture_4"><i class="fa fa-microphone"></i> <span>Mikrofonu Kullan</span></span>
											<div class="review_add_content_word_count"><div class="total">0</div><div class="slash">/</div><div class="need">75</div></div>
											<div class="mt-3 mb-3">
											<div class="alert alert-info mb-1"><i class="fa fa-info-circle"></i> Düzenleme işlemlerinde fotoğrafı yeniden yüklemelisiniz</div>
											<div class="row">
												<div class="col-lg-2 col-sm-12">
													<img src="<?php echo UPLOAD_URL; ?>/blank.webp" class="img-thumbnail review_content_image" alt="Görsel">
												</div>
												<div class="col-lg-10 col-sm-12">
													<input type="file" name="images[]" class="form-control mt-1 review_add_content_image" accept="image/*">
												</div>
											</div>
											</div>
										</div>
										<a href="javascript:void(0);" class="rw_btn_prev np_step" data-type="prev"><i class="fa fa-arrow-alt-circle-left"></i> <span>Önceki Adım</span></a>
										<button type="submit" class="rv_btn_submit"><i class="fa fa-check-square"></i> Tamamla ve Onaya Gönder</button>
									</div>
								</div>
							</div>
				</div>
		</div>
		</form>
	</div>
</div>
</div>
		
		
		

<?php
	m_footer();
?>
					