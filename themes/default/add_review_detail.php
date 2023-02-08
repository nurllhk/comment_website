<?php
	m_header();
	$informations = $db->table('products')->where('id','=',m_u_g('id'))->order('title','asc')->limit(1)->get();
	if($informations['total_count']==0)
	{
		m_redirect(SITE_DOMAIN.'/inceleme-ekle');
	}
	$info = $informations['data'][0];
	if(USER['first_review_step']==0)
	{
		m_redirect(m_permalink('first_review_step',$info['id']));
	}
	$wait_reviews = $db->table('reviews')->where('u_id','=',USER['id'])->where('status','=',3)->count();
	if($wait_reviews>0)
	{
		m_redirect(m_permalink('account_page','bekleyen-duzenleme'));
	}
?>   
<div class="main">
	<div class="container">
		<div class="page_head">
		<div class="page_icon"><i class="fa fa-pen-square"></i></div>
		<div class="page_title"><h1>İnceleme Ekle - Anlatım</h1></div>
		</div>
		<div class="mt-3 review_form_container">
		<div class="row">
					<?php
							$review_list = new m_review();
							$review_list->template 					= 'default';
							$review_list->template_col 				= 'col-xl-12 col-lg-12 col-sm-12';
							$review_list->query_options 			= "where id='".$info['id']."'";
							$review_list->order 					= "order by id desc";
							$review_list->limit 					= 1;
							$result = $review_list->list_products();
							echo $result['html'];
					?>
		</div>
		<form class="review_add_content_form" method="post" action="#" enctype="multipart/form-data" novalidate>
		<input class="form-control" name="type" value="add_review" type="hidden">
		<input class="form-control" name="p_id" value="<?php echo m_u_g('id'); ?>" type="hidden">
		<div class="review_add_card">
				<div class="review_add_card_content">
				
							<div class="mascot"><img src="<?php echo UPLOAD_URL; ?>/mascot.png" alt="Mascot"></div>
							<div class="review_add_card_content_inner">
							<div class="review_add_content_result"></div>
								<div class="review_add_step active">
									<div class="review_add_card_content_question">
										<div class="question">
										Merhaba! Nasılsın bugün? 6 Adımda para kazanabileceğin bir inceleme yazman için sana yardımcı olacağım!😊
										</div>
									</div>
									<div class="question_after">
										<a href="javascript:void(0);" class="rw_btn np_step" data-type="next"><i class="fa fa-check-square"></i> <span>Hadi Başlayalım</span></a>
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
										<input type="radio" class="btn-check review_recommend_check" name="recommend" id="success-outlined" value="1" autocomplete="off">
										<label class="btn btn-outline-success radio_btn w-100 mb-2" for="success-outlined"><i class="fa fa-thumbs-up"></i> Evet</label>
										<input type="radio" class="btn-check review_recommend_check" name="recommend" id="danger-outlined" value="0" autocomplete="off">
										<label class="btn btn-outline-danger radio_btn w-100 mb-2" for="danger-outlined"><i class="fa fa-thumbs-down"></i> Hayır</label>
										</div>
										<div class="mb-3">
										<input class="form-control review_add_title mb-2" name="title" type="text" placeholder="İnceleme Başlığı - Örneğin: Pratik makyaj temizleme için ideal">
										<select class="form-select w-100 review_point_select" name="rate">
											<option value="0">Puanınız kaç olurdu ?</option>
											<option value="1">PUAN: 1</option>
											<option value="2">PUAN: 2</option>
											<option value="3">PUAN: 3</option>
											<option value="4">PUAN: 4</option>
											<option value="5">PUAN: 5</option>
										</select>
										</div>
										<a href="javascript:void(0);" class="rw_btn_prev np_step" data-type="prev"><i class="fa fa-arrow-alt-circle-left"></i> <span>Önceki Adım</span></a>
										<a href="javascript:void(0);" class="rw_btn np_step" data-type="next" data-check="true"><i class="fa fa-arrow-alt-circle-right"></i> <span>Sonraki Adım</span></a>
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
										<input type="radio" class="btn-check" name="price_rate" id="success-outlined2" value="1" autocomplete="off" checked>
										<label class="btn btn-outline-success radio_btn w-100 mb-2" for="success-outlined2"><i class="fa fa-thumbs-up"></i> Evet</label>
										<input type="radio" class="btn-check" name="price_rate" id="danger-outlined2" value="0" autocomplete="off">
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
										
											<textarea name="content[]" class="form-control w-100 review_add_content capture_1" placeholder="Lütfen tüm harfleri büyük yazmaktan kaçınınız. &#10;&#10;Merhaba arkadaşlar, selam arkadaşlar v.b girişlerle başlamayınız bu içeriğinizin puanlamasını düşürecektir."></textarea>
											<span class="mt-1 mb-1 btn btn-default btn-sm microphone_write" rel="capture_1"><i class="fa fa-microphone"></i> <span>Mikrofonu Kullan</span></span>
											<div class="review_add_content_word_count"><div class="total">0</div><div class="slash">/</div><div class="need">75</div></div>
											<div class="mt-3 mb-3">
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
										
											<textarea name="content[]" class="form-control w-100 review_add_content capture_2" placeholder="Lütfen tüm harfleri büyük yazmaktan kaçınınız."></textarea>
											<span class="mt-1 mb-1 btn btn-default btn-sm microphone_write" rel="capture_2"><i class="fa fa-microphone"></i> <span>Mikrofonu Kullan</span></span>
											<div class="review_add_content_word_count"><div class="total">0</div><div class="slash">/</div><div class="need">75</div></div>
											<div class="mt-3 mb-3">
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
										
											<textarea name="content[]" class="form-control w-100 review_add_content capture_3" placeholder="Lütfen tüm harfleri büyük yazmaktan kaçınınız."></textarea>
											<span class="mt-1 mb-1 btn btn-default btn-sm microphone_write" rel="capture_3"><i class="fa fa-microphone"></i> <span>Mikrofonu Kullan</span></span>
											<div class="review_add_content_word_count"><div class="total">0</div><div class="slash">/</div><div class="need">75</div></div>
											<div class="mt-3 mb-3">
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
										
											<textarea name="content[]" class="form-control w-100 review_add_content capture_4" placeholder="Lütfen tüm harfleri büyük yazmaktan kaçınınız."></textarea>
											<span class="mt-1 mb-1 btn btn-default btn-sm microphone_write" rel="capture_4"><i class="fa fa-microphone"></i> <span>Mikrofonu Kullan</span></span>
											<div class="review_add_content_word_count"><div class="total">0</div><div class="slash">/</div><div class="need">75</div></div>
											<div class="mt-3 mb-3">
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
								<div id="ezoic-pub-ad-placeholder-124"> </div>
							</div>
				</div>
		</div>
		</form>
	</div>
</div>
</div>
		
		
		

<div class="modal fade" id="inceleme_red_info" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-question-circle"></i> İncelemeler Neden Reddedilir ?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
      </div>
      <div class="modal-body">
        <p>- İncelemenizin Reddedilme Sebebini profilinizdeki "<strong>İncelemelerim</strong>" Sekmesinden görebilirsiniz. </p>
		<p>
		  İncelemeleriniz kendi yazılarınızdan ve fotoğraflarınızdan oluşmalıdır. (Başka sitelerden Kopyala/Yapıştır yazılar ve fotoğraflar direkt reddedilmektedir. Örneğin başka siteden ürün fotoğrafı almak, herhangi bir yazıyı kopyala yapıştır yapmak ret sebebidir.)
		</p>
		<p>
		  Eğer incelemeleriniz Kullanmadığınız, henüz piyasaya çıkmamış bir ürün ya da hizmetse reddedilir; çünkü açıklıyorum.com kullanıcıları ürün/hizmet tecrübelerini okumak ve yazmak için siteyi ziyaret etmektedirler.
		</p>
		<p>
		  Eğer incelemeleriniz 50 Karakter altındaysa otomatik olarak reddedilir.
		</p>
		<p>
		  Eğer incelemeleriniz <strong>300 kelime veya 4 fotoğraf altı ama özgün ise "Onaylanır" lakin Para kazanmaya açılmaz</strong>.
		</p>
		<p>
		  İncelemeler düzenlemeye kapalıdır. destek@acikliyorum.com adresinden düzeltme talebinizi bize iletebilirsiniz.
		</p>
		<p>
		  <br>
		  <strong>İncelememin görüntülenmesini nasıl artırabilirim?</strong>
		</p>
		<p>
		  İncelemelerinizi Whatsapp Facebook gruplarındaki arkadaşlarınızla paylaşıp günlük ziyaret etmelerini rica edebilirsiniz.
		</p>
		<p>
		  İncelemeniz ne kadar gerçek fotoğraflardan oluşursa o kadar üst sayıda görüntülenmesini sistem sağlamaktadır.
		</p>
		<p>
		  İncelemenin yazdığınız ürün hizmet hakkındaki Tecrübelerinizi yazmanız daha çok ilgi görmesini sağlayacaktır.
		</p>
		<p>
		  Paragraf sonra fotoğraf, paragraf sonra fotoğraf şeklinde giden incelemeler daha çok görüntülenme almaktadır.
		</p>
		<p>
		  Fotoğraflarınız Kendi Çektiğiniz fotoğraflar olursa sistem tarafından ekstra Kalite Puanı alırsınız ve incelemeniz daha çok kişiye ulaşır.
		</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
      </div>
    </div>
  </div>
</div>
<?php
	m_footer();
?>
					