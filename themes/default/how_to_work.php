<?php
	m_header();
?>
   
<div class="main">
<div class="container landing_page">
	<div class="row">

	
	<div class="col-xl-12 col-lg-12 col-sm-12">
	<div class="page_head">
	<div class="page_icon"><i class="fa fa-coins"></i></div>
	<div class="page_title"><h1>Yorumla Kazan</h1></div>
	</div>
	<div class="row">
	
	<div class="col-xl-6 col-lg-6 col-sm-12">
		<video autoplay controls class="landing_video">
		  <source src="<?php echo SITE_THEME_URL; ?>/assets/videos/landing.mp4" type="video/mp4">
		</video>
	</div>
	
	<div class="col-xl-6 col-lg-6 col-sm-12">
		<div class="landing_detail">
			<div class="landing-hero__content">
			<div class="landing-hero__title">Merhaba!</div>
			<div class="landing-hero__sub-title line-after">Açıklıyorum'da aklınıza gelebilecek her ürün için gerçek kullanıcı deneyimlerini ve incelemelerini bulabilirsiniz.</div>
			<div class="landing-hero__text">Sadece bir ürün ya da hizmet düşünün ve Açıklıyorum'da arayın. O ürünü kullananlar aklınızdaki sorular için size yardımcı olacaktır.</div>
			</div>
		</div>
	</div>
	
	<div class="col-xl-12 col-lg-12 col-sm-12">
		<div class="landing_content_box">
			<div class="landing-money">
			  <div class="landing-money__content">
				<div class="landing-money__title line-after"><span>Dürüst</span> incelemelere ödeme yapıyoruz.</div>
				<div class="landing-money__text">Acikliyorum.com'da bilgi ve deneyimi paraya dönüştürebilirsiniz. Her gün onlarca ürün ve hizmet kullanıyorsunuz. Onlar hakkında faydalı yorumlar yazın ve düzenli gelir elde edin.</div>
			  </div>
			  <div class="landing-money__img">
				<img src="<?php echo UPLOAD_URL.'/1x1.gif'; ?>" class="lazyload" width="300" height="265" data-src="<?php echo SITE_THEME_URL; ?>/assets/img/hand-money.webp" alt="Dürüst incelemere ödeme yapıyoruz">
			  </div>
			</div>
		</div>
		<div class="row">
			<div class="col-xl-4 col-lg-4 col-sm-12">
			<div class="info_box">
				<i class="fa fa-user-plus"></i>
				<span>Şimdi Üye Olun</span>
			</div>
			</div>
			<div class="col-xl-4 col-lg-4 col-sm-12">
			<div class="info_box">
				<i class="fa fa-pen-square"></i>
				<span>İnceleme Yazmaya Başlayın</span>
			</div>
			</div>
			<div class="col-xl-4 col-lg-4 col-sm-12">
			<div class="info_box">
				<i class="fa fa-wallet"></i>
				<span>Pasif Gelir Elde Etmeye Başlayın</span>
			</div>
			</div>
		</div>
		<div class="page_head">
		<div class="page_icon"><i class="fa fa-question"></i></div>
		<div class="page_title"><h1>Nasıl Kazanıyor, Nasıl Paylaşıyoruz ?</h1></div>
		</div>
		<div class="row">
			<div class="col-xl-4 col-lg-4 col-sm-12">
			<div class="info_box">
				<i class="fa fa-newspaper"></i>
				<span>Faydalı Bir İnceleme Yazıyorsun</span>
				<p>Bir ürün veya hizmet hakkında bilgi arayan kişiler tarafından okunur.</p>
			</div>
			</div>
			<div class="col-xl-4 col-lg-4 col-sm-12">
			<div class="info_box">
				<i class="fa fa-scroll"></i>
				<span>İnceleme sayfasında reklam gösteriyoruz</span>
				<p>İnceleme ne kadar iyi ve faydalı olursa, o kadar çok görüntüleme alır.</p>
			</div>
			</div>
			<div class="col-xl-4 col-lg-4 col-sm-12">
			<div class="info_box">
				<i class="fa fa-balance-scale"></i>
				<span>Reklam gelirini sizinle paylaşıyoruz</span>
				<p>Gereken şartları sağlayan her incelemenizin görüntülenmesine ödeme yapıyoruz.</p>
			</div>
			</div>
		</div>
		<div class="page_head">
		<div class="page_icon"><i class="fa fa-chart-pie"></i></div>
		<div class="page_title"><h1>Ödeme Tablosu ve Para Çekimi İşlemleri</h1></div>
		</div>
		<div class="row">
			<div class="col-xl-8 col-lg-8 col-sm-12">
			<div class="content_box">
				<div class="table-responsive fs-12">
				<table class="table table-bordered">
				  <thead>
					<tr>
					  <th>Rozet</th>
					  <th>Seviye</th>
					  <th>Onaylanan Her İnceleme İçin Ücret</th>
					  <th>Görüntülenme Başı Ücret</th>
					</tr>
				  </thead>
				  <tbody>
					<tr>
					  <th><span class="user_rank <?php echo USER_LEVELS[0]['level_color']; ?>"><i class="fa <?php echo USER_LEVELS[0]['level_icon']; ?>"></i></span></th>
					  <td><?php echo USER_LEVELS[0]['title']; ?></td>
					  <td><?php echo m_currency(USER_LEVELS[0]['fee_per_review']); ?> <i class="fa fa-lira-sign"></i></td>
					  <td><?php echo m_currency(USER_LEVELS[0]['view_amount']); ?> <i class="fa fa-lira-sign"></i></td>
					</tr>
					<tr>
					  <th><span class="user_rank <?php echo USER_LEVELS[1]['level_color']; ?>"><i class="fa <?php echo USER_LEVELS[1]['level_icon']; ?>"></i></span></th>
					  <td><?php echo USER_LEVELS[1]['title']; ?></td>
					  <td><?php echo m_currency(USER_LEVELS[1]['fee_per_review']); ?> <i class="fa fa-lira-sign"></i></td>
					  <td><?php echo m_currency(USER_LEVELS[1]['view_amount']); ?> <i class="fa fa-lira-sign"></i></td>
					</tr>
					<tr>
					  <th><span class="user_rank <?php echo USER_LEVELS[2]['level_color']; ?>"><i class="fa <?php echo USER_LEVELS[2]['level_icon']; ?>"></i></span></th>
					  <td><?php echo USER_LEVELS[2]['title']; ?></td>
					  <td><?php echo m_currency(USER_LEVELS[2]['fee_per_review']); ?> <i class="fa fa-lira-sign"></i></td>
					  <td><?php echo m_currency(USER_LEVELS[2]['view_amount']); ?> <i class="fa fa-lira-sign"></i></td>
					</tr>
				  </tbody>
				</table>
				<br/>
				<i class="fa fa-info-circle"></i> İncelemenizin para kazanmaya açılması için, en az 300 kelime ve 4 fotoğraf barındırması gerekir.
				<br/>
				<i class="fa fa-info-circle"></i> İncelemeyi eklediğinizdeki seviyeniz değil, mevcut seviyeniz üzerinden değerlendirme yapılır.
				</div>
			</div>
			</div>
			<div class="col-xl-4 col-lg-4 col-sm-12">
			<div class="info_box">
				<i class="fa fa-handshake"></i>
				<span>Para Çekimi</span>
				<p>Bakiyeniz 35.00 TL seviyesine ulaştığında dilediğiniz zaman para çekim talebi verebilirsiniz.</p><br/>
				<p class="mt-4 mb-4">Sadece kendi adınıza kayıtlı banka hesaplarına para çekimi yapabilirsiniz.Para çekim talebiniz onaylandığında, işleminiz tamamlanacaktır.</p>
			</div>
			</div>
		</div>
		<div class="page_head">
		<div class="page_icon"><i class="fa fa-signal"></i></div>
		<div class="page_title"><h1>Seviye Gelişimi</h1></div>
		</div>
		<div class="progress mb-3">
		  <div class="progress-bar bg-brand" role="progressbar" aria-valuenow="33.3"
		  aria-valuemin="0" aria-valuemax="100" style="width:33.3%">
			Yeni Yazar
		  </div>
		  <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="33.3"
		  aria-valuemin="0" aria-valuemax="100" style="width:33.3%">
			( <?php echo m_number_format(USER_LEVELS[1]['need_level']); ?> Puan )
		  </div>
		   <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="33.3"
		  aria-valuemin="0" aria-valuemax="100" style="width:33.3%">
			( <?php echo m_number_format(USER_LEVELS[2]['need_level']); ?> Puan )
		  </div>
		</div>
		<ol class="list-group">
		  <li class="list-group-item d-flex justify-content-between align-items-start">
			<div class="ms-2 me-auto">
			  <div class="fw-bold"><i class="fa fa-check-square text-success me-3"></i> Onaylanan İnceleme</div>
			  Onaylanan her incelemeniz için puan alırsınız.
			</div>
			<span class="badge bg-primary rounded-pill">5 Puan</span>
		  </li>
		  <li class="list-group-item d-flex justify-content-between align-items-start">
			<div class="ms-2 me-auto">
			  <div class="fw-bold"><i class="fa fa-tint text-success me-3"></i> Ürüne Ait İlk İnceleme</div>
			  İncelemesini yaptığınız ürün/hizmet' e ait bir inceleme bulunmuyor ve ilgili ürüne ait ilk incelemeyi siz eklemişseniz puan alırsınız.
			</div>
			<span class="badge bg-primary rounded-pill">6 Puan</span>
		  </li>
		  <li class="list-group-item d-flex justify-content-between align-items-start">
			<div class="ms-2 me-auto">
			  <div class="fw-bold"><i class="fa fa-text-width text-success me-3"></i> Kelime Oranı</div>
			  İncelemenizde bulunan her 50 kelime için puan alırsınız.
			</div>
			<span class="badge bg-primary rounded-pill">50 Puan</span>
		  </li>
		  <li class="list-group-item d-flex justify-content-between align-items-start">
			<div class="ms-2 me-auto">
			  <div class="fw-bold"><i class="fa fa-keyboard text-success me-3"></i> İmla Kuralları</div>
			  İncelemenizde imla kurallarına dikkat etmeniz durumunda puan alırsınız. ( Örneğin; tüm harfleri büyük yazmamak, cümle başlangıçlarında büyük harf ile başlamak... )
			</div>
			<span class="badge bg-primary rounded-pill">8 Puan</span>
		  </li>
		  <li class="list-group-item d-flex justify-content-between align-items-start">
			<div class="ms-2 me-auto">
			  <div class="fw-bold"><i class="fa fa-images text-success me-3"></i> Eklenen Fotoğraf</div>
			  İncelemenize eklediğiniz fotoğraf başına puan alırsınız. ( Paragraf ve Fotoğraf yerleşiminde bulunan kurallar referans alınacaktır. )
			</div>
			<span class="badge bg-primary rounded-pill">10 Puan</span>
		  </li>
		  <li class="list-group-item d-flex justify-content-between align-items-start">
			<div class="ms-2 me-auto">
			  <div class="fw-bold"><i class="fa fa-camera-retro text-success me-3"></i> Kaliteli Fotoğraflar</div>
			  İncelemenize eklediğiniz fotoğrafların kaliteli ve görüntü boyutu büyük olması durumunda puan alırsınız.
			</div>
			<span class="badge bg-primary rounded-pill">15 Puan</span>
		  </li>
		  <li class="list-group-item d-flex justify-content-between align-items-start">
			<div class="ms-2 me-auto">
			  <div class="fw-bold"><i class="fa fa-th-large text-success me-3"></i> Paragraf ve Fotoğraf Yerleşimi</div>
			  İncelemenizdeki paragraf ve fotoğrafların yerleşimine dikkat etmeniz durumunda puan alırsınız. ( Önerilen: Her 2 paragraf sonrasında fotoğraf yerleşimi )
			</div>
			<span class="badge bg-primary rounded-pill">20 Puan</span>
		  </li>
		</ol>
		<div class="alert alert-success mt-3" role="alert">
		  <h4 class="alert-heading">Örnek Puanlandırma</h4>
		  <p>Örneğin; 300 kelime, 4 fotoğrafdan oluşan ve ilgili kurallarının tamamına uygun olan onaylanmış incelemeniz için alacağınız puanın hesaplaması aşağıda belirtilmiştir.</p>
		  <hr>
		  <p class="mb-0">5 + 6 + (300/50)x50=300 + 8 + 4x10=40 + 15 + 20 = 394 Puan</p>
		</div>
		
	</div>
	
	
	
	</div>
	
	
	
	</div>
	
	
	
	</div>
	
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-sm-12 col-12">
		<div class="page_head">
		<div class="page_icon"><i class="fa fa-info-circle"></i></div>
		<div class="page_title"><h1>Vakit Geçir Kazan</h1></div>
		</div>
		<div class="mt-3">
		<div class="row">
		
		<div class="col-xl-12 col-lg-12 col-sm-12">
		
		<div class="content_box">
		
		<h1>Açıklıyorum'dan Bir Kazanç Modeli Daha!</h1><p>Tüm kullanıcılarımızın sitemizde geçirdiği zamanı önemsiyor ve her geçen gün sitemizdeki aktiviteleri geliştiriyoruz. Artık kullanıcılarımız sadece yorum yazarak değil, sitede geçirdiği vakit üzerinden de para kazanabilecekler.</p><h2>Peki nasıl çalışıyor ?</h2><p>Sitemizde geçirdiğiniz vakit başta da belirttiğimiz gibi bizim için oldukça değerli. Sitemize girişinizden itibaren, en az 10 saniye ilgili sayfa oturumunuzun açık kalması durumunda, her 10 saniye başına, bakiyenize 0,0001 TL yansıtılacaktır.</p><p>Bu işlem her kullanıcı, ip birleşimi için geçerli olup aynı IP'deki birden fazla kullanıcıyı kapsamamaktadır.</p><p>Bakiyenizdeki tutarı, sitemizde geçerli olan Minimum Para Çekimi dahilinde dilediğiniz zaman anında banka hesabınıza çekebilirsiniz.</p><h3>Genel Şartlar ve Kurallar</h3><p>Bu kampanya sadece Türkiye için geçerlidir, diğer ülkelerdeki üyelerimizi kapsamamaktadır.</p><p>Sitemizdeki oturumunuzun ( sayfada kalma süresi ) minimum 10 saniye olmak zorundadır. Aksi halde bakiyenize ilgili ödül işlenmeyecektir.</p><p>Herhangi bir kullanıcının, ilgili sistemi kötüye kullanımı veya suistimal etmesi durumunda ilgili kullanıcıya ait üyelik kapatılacak ve bakiyesi silinecektir.</p><p>Acikliyorum.com, bu kampanya şartları ile ilgili her zaman düzenleme ve değiştirme hakkını saklı tutar.</p>		
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
					