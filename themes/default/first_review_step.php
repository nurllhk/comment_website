<?php
	m_header();
	$informations = $db->table('products')->where('id','=',m_u_g('id'))->order('title','asc')->limit(1)->get();
	if($informations['total_count']==0)
	{
		m_redirect(SITE_DOMAIN.'/inceleme-ekle');
	}
	$info = $informations['data'][0];
?>
<div class="main">
	<div class="container">
		<div class="page_head">
		<div class="page_icon"><i class="fa fa-paper-plane"></i></div>
		<div class="page_title"><h1>İnceleme Eklemeden Önce İlk Adım</h1></div>
		</div>
		
		<?php echo m_ads('720_300'); ?>
		
		<div class="mt-3">
		<div class="alert alert-primary mb-2"><i class="fa fa-info-circle"></i> İnceleme eklemeden önce, ilk adım turunu tamamlamanız gerekiyor.</div>
		<form class="first_review_step_form" method="post" action="#" enctype="multipart/form-data" novalidate>
		<input class="form-control first_review_step_url" name="first_review_step_url" value="<?php echo m_permalink('add_review_detail',$info['id']); ?>" type="hidden">
		
		<div class="card mb-2 first_review_step_card active">
		
			<div class="card-header text-white">Doğru Başlık Seçimi</div>
			<div class="card-body">
			<div class="alert alert-info mb-2">
			<i class="fa fa-question-circle"></i> İncelemeniz için seçtiğiniz başlık ilgili ürün veya hizmet kullanıcılarının dikkatini çekecek bir başlık olmalıdır. İncelemenizin insanlara faydalı olmasını ve daha fazla görüntülenme almasını sağlamak için aşağıda belirtilen faktörlere dikkat ediniz.
			<br/>
			<br/>
			<i class="fa fa-times-circle text-danger"></i> Seçtiğiniz başlık ne çok kısa, nede çok uzun <b>olmalıdır.</b> <br/>
			<i class="fa fa-times-circle text-danger"></i> Başlığınız sadece ürün veya hizmet adından <b>oluşmamalıdır.</b> <br/>
			<i class="fa fa-check-square text-success"></i>  Başlıkta ürün veya hizmete ait iyi veya kötü özelliklerinden bahsetmek oldukça <b>faydalıdır.</b> <br/>
			</div>
			
			<ol class="list-group mb-1">
				<li class="list-group-item d-flex justify-content-between align-items-start">
				  <div class="ms-2 me-auto">
				  <div class="fw-bold"><i class="fa fa fa-shopping-cart me-3"></i>Örnek Ürün</div>
				  <b class="text-danger">Iphone 13 Pro</b>
				  </div>
				</li>
				<li class="list-group-item d-flex justify-content-between align-items-start">
				  <div class="ms-2 me-auto">
				  <div class="fw-bold text-success"><i class="fa fa-check-square me-3"></i>İyi Başlık Örnekleri</div>
				  
				  <ul class="list-group mt-2 mb-2">
				  <li class="list-group-item"><i class="fa fa-check text-success"></i> Fotoğraf çekimleri için ideal bir telefon</li>
				  <li class="list-group-item"><i class="fa fa-check text-success"></i> Fiyatını hakeden nadir telefonlardan</li>
				  <li class="list-group-item"><i class="fa fa-check text-success"></i> Şarj süresi dışında kullanışlı bir telefon</li>
				  <li class="list-group-item"><i class="fa fa-check text-success"></i> Oyun severlerin ilk tercihi Iphone 13</li>
				  <li class="list-group-item"><i class="fa fa-check text-success"></i> Parça veya tamir ücretleri çok fazla</li>
				  </ul>
				  </div>
				</li>
				<li class="list-group-item d-flex justify-content-between align-items-start">
				  <div class="ms-2 me-auto">
				  <div class="fw-bold text-danger"><i class="fa fa-times-circle me-3"></i>Kötü Başlık Örnekleri</div>
				  
				  <ul class="list-group mt-2 mb-2">
				  <li class="list-group-item"><i class="fa fa-times text-danger"></i> Iphone 13</li>
				  <li class="list-group-item"><i class="fa fa-times text-danger"></i> Telefon</li>
				  <li class="list-group-item"><i class="fa fa-times text-danger"></i> Çok seviyorum</li>
				  <li class="list-group-item"><i class="fa fa-times text-danger"></i> Çok İyi</li>
				  <li class="list-group-item"><i class="fa fa-times text-danger"></i> Kesinlikle önermem</li>
				  </ul>
				  
				  </div>
				</li>  
			</ol>
			
			<a href="javascript:void(0);" class="first_review_step_by_step" data-type="next"><span class="btn btn-sm btn-default w-100"><i class="fa fa-arrow-alt-circle-right"></i> Sonraki Adım</span></a>
	
			</div>
		
		</div>
		
		<div class="card mb-2 first_review_step_card">
		
			<div class="card-header text-white">Doğru Anlatım</div>
			<div class="card-body">
			<div class="alert alert-info mb-2">
			<i class="fa fa-question-circle"></i> İncelemenizin anlatımı incelemenizin görüntülenmesinde önemli rol oynamaktadır. Ayrıca giriş paragrafında kullanıcıların ilgisini çekebilecek girişler yapmanız oldukça önemlidir.
			<br/>
			<br/>
			<i class="fa fa-times-circle text-danger"></i> Giriş paragrafında sıradanlaşmış cümlelerden <b>kaçınmalısınız.</b> <br/>
			<i class="fa fa-times-circle text-danger"></i> İlgili ürün veya hizmetle ilgisi olmayan cümleler <b>yazmamalısınız.</b> <br/>
			<i class="fa fa-times-circle text-danger"></i> Anlatımınızda imla kurallarına dikkat etmeli ve tüm harfleri büyük <b>yazmamalısınız.</b> <br/>
			<i class="fa fa-times-circle text-danger"></i> Anlatımlarınız kopya içeriklerden veya alıntılardan <b>oluşmamalıdır.</b> <br/>
			<i class="fa fa-check-square text-success"></i> Anlatımınızda Ürün/Hizmetin iyi veya kötü özelliklerinden <b>bahsetmelisiniz.</b> <br/>
			<i class="fa fa-check-square text-success"></i> Ürün/Hizmet hakkındaki hem temin aşamasını hemde deneyimlerinizi anlatmak oldukça <b>faydalıdır.</b> <br/>
			</div>
			
			<ol class="list-group mb-1">
				<li class="list-group-item d-flex justify-content-between align-items-start">
				  <div class="ms-2 me-auto">
				  <div class="fw-bold"><i class="fa fa fa-shopping-cart me-3"></i>Örnek Ürün</div>
				  <b class="text-danger">Iphone 13 Pro</b>
				  </div>
				</li>
				<li class="list-group-item d-flex justify-content-between align-items-start">
				  <div class="ms-2 me-auto">
				  <div class="fw-bold text-success"><i class="fa fa-check-square me-3"></i>İyi Giriş Örnekleri</div>
				  
				  <ul class="list-group mt-2 mb-2">
				  <li class="list-group-item"><i class="fa fa-check text-success"></i> İyi bir oyun telefonumu arıyorsunuz ? İşte çözüm Iphone 13 Pro...</li>
				  <li class="list-group-item"><i class="fa fa-check text-success"></i> Apple markasına ait telefonlardan biri olan Iphone 13 Pro...</li>
				  <li class="list-group-item"><i class="fa fa-check text-success"></i> Mobil teknolojide çığır açan telefonların başında gelen telefonlardan biri olan...</li>
				  <li class="list-group-item"><i class="fa fa-check text-success"></i> Aldıktan sonra pişman olduğum Iphone 13 Pro deneyimlerimi sizinle paylaşmak istiyorum...</li>
				  <li class="list-group-item"><i class="fa fa-check text-success"></i> Bir internet sitesinden uygun fiyatına aldanarak aldığım...</li>
				  </ul>
				  </div>
				</li>
				<li class="list-group-item d-flex justify-content-between align-items-start">
				  <div class="ms-2 me-auto">
				  <div class="fw-bold text-danger"><i class="fa fa-times-circle me-3"></i>Kötü Giriş Örnekleri</div>
				  
				  <ul class="list-group mt-2 mb-2">
				  <li class="list-group-item"><i class="fa fa-times text-danger"></i> Merhaba arkadaşlar bugün size yeni bir incelemeyle geldim...</li>
				  <li class="list-group-item"><i class="fa fa-times text-danger"></i> Günaydın bugün size Iphone 13 Pro ürününü tanıtacağım...</li>
				  <li class="list-group-item"><i class="fa fa-times text-danger"></i> İyi akşamlar arkadaşlar güzel günleriniz olsun...</li>
				  <li class="list-group-item"><i class="fa fa-times text-danger"></i> Hayırlı günler açıklyorum ailesi...</li>
				  <li class="list-group-item"><i class="fa fa-times text-danger"></i> Herkese merhaba arkadaşlar, günaydın nasılsınız ?...</li>
				  </ul>
				  
				  </div>
				</li>  
			</ol>
			
			<a href="javascript:void(0);" class="first_review_step_by_step d-block mb-2" data-type="prev"><span class="btn btn-sm btn-primary w-100"><i class="fa fa-arrow-alt-circle-left"></i> Önceki Adım</span></a>
			<a href="javascript:void(0);" class="first_review_step_by_step d-block" data-type="next"><span class="btn btn-sm btn-default w-100"><i class="fa fa-arrow-alt-circle-right"></i> Sonraki Adım</span></a>
			
			</div>
		
		</div>
		
		<div class="card mb-2 first_review_step_card">
		
			<div class="card-header text-white">Doğru ve Alakalı Fotoğraf Seçimi</div>
			<div class="card-body">
			<div class="alert alert-info mb-2">
			<i class="fa fa-question-circle"></i> İncelemenizde kullandığınız fotoğraflar kendi çekiminiz olmalı ( istisnalar haricinde ) ve görüntü boyutları standart düzeyde olmalıdır. İncelemenizde kullandığınız fotoğraflar arama motorları tarafından tarandığından dolayı incelemenizin görüntülenmesinde önemli rol oynamaktadır.
			<br/>
			<br/>
			<i class="fa fa-times-circle text-danger"></i> Ürün/Hizmetle ilgisi olmayan fotoğraflar <b>kullanmamalısınız.</b> <br/>
			<i class="fa fa-times-circle text-danger"></i> Fotoğraflarınızda herhangi bir marka veya sitenin filigranı veya logosu <b>bulunmamalıdır.</b> <br/>
			<i class="fa fa-check-square text-success"></i> Kullandığınız fotoğrafların kendi çekiminiz olması <b>önerilmektedir.</b> <br/>
			<i class="fa fa-check-square text-success"></i> Ürün veya hizmetin yer aldığı fotoğraflar <b>kullanmalısınız.</b> <br/>
			<i class="fa fa-check-square text-success"></i> Görüntü kalitesi yüksek fotoğraflar kullanmanız oldukça <b>faydalıdır.</b> <br/>
			
			</div>
			
			
			<a href="javascript:void(0);" class="first_review_step_by_step d-block mb-2" data-type="prev"><span class="btn btn-sm btn-primary w-100"><i class="fa fa-arrow-alt-circle-left"></i> Önceki Adım</span></a>
			<button type="submit" class="first_review_step_by_step btn btn-sm btn-success w-100"><i class="fa fa-check-circle"></i> İnceleme Eklemeye Devam Edin</button>
			
			</div>
		
		</div>
		
		
		</form>
	</div>
</div>
</div>
		

<?php
	m_footer();
?>
					