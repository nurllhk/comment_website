<?php if(!defined('ADMIN_INCLUDED')) { exit; } ?>
<?php
	$informations = $db->table('settings')->where('id','=',1)->get();
	if($informations['total_count']=='0')
	{
		m_redirect(ADMIN_URL);
	}
	$info = $informations['data'][0];

?>   

<div class="content">
<div class="navbar navbar-dark navbar-expand-md navbar-component">
<div class="d-md-none">
</div>
<div class="collapse navbar-collapse" id="navbar-component">
	<ul class="navbar-nav">
		<li class="nav-item">
			<a href="<?php echo ADMIN_URL;?>" class="navbar-nav-link">Anasayfa</a>
		</li>
		<li class="nav-item">
			<a href="#" class="navbar-nav-link"><i class="fa fa-share"></i></a>
		</li>
		<li class="nav-item">
			<a href="#" class="navbar-nav-link">Genel Ayarlar</a>
		</li>
	</ul>

</div>
</div>


<form method="post" enctype="multipart/form-data">

<div class="card">
<div class="card-header bg-dark text-white header-elements-inline">
<h5 class="card-title">Genel Ayarlar</h5>
</div>

<div class="card-body">
<?php
if($_POST)
{
	if($_FILES['logo']['name']=='')
	{
		$logo = $info['logo'];
	}
	else
	{
		$logo=m_image_uploader('logo','logo_'.m_sef(m_a_p('title')).'_'.uniqid().'',true);
		$logo=$logo[0];
		unlink(UPLOAD_DIR.'/images/'.$info['logo']);
	}
	if($_FILES['logo_mobile']['name']=='')
	{
		$logo_mobile = $info['logo_mobile'];
	}
	else
	{
		$logo_mobile=m_image_uploader('logo_mobile','logo_mobile_'.m_sef(m_a_p('title')).'_'.uniqid().'',true);
		$logo_mobile=$logo_mobile[0];
		unlink(UPLOAD_DIR.'/images/'.$info['logo_mobile']);
	}
	$data = [
	'logo' => $logo,
	'logo_mobile' => $logo_mobile,
	'maintenance' => m_a_p('maintenance'),
	'week_brand' => m_a_p('week_brand'),
	'week_product' => m_a_p('week_product'),
	'week_user' => m_a_p('week_user'),
	'week_category' => m_a_p('week_category'),
	'week_category_fee' => m_a_p('week_category_fee'),
	'referer_amount' => m_a_p('referer_amount'),
	'referer_withdraw_amount' => m_a_p('referer_withdraw_amount'),
	'fee_per_review_status' => m_a_p('fee_per_review_status'),
	'fee_per_time_on_status' => m_a_p('fee_per_time_on_status'),
	'fee_per_time_on' => m_a_p('fee_per_time_on'),
	'min_withdraw' => m_a_p('min_withdraw'),
	'phone' => m_a_p('phone'),
	'email' => m_a_p('email'),
	'ads_email' => m_a_p('ads_email'),
	'address' => m_a_p('address'),
	'facebook' => m_a_p('facebook'),
	'twitter' => m_a_p('twitter'),
	'instagram' => m_a_p('instagram'),
	'linkedin' => m_a_p('linkedin'),
	'w_title' => m_a_p('w_title'),
	'w_host' => m_a_p('w_host'),
	'w_port' => m_a_p('w_port'),
	'w_email' => m_a_p('w_email'),
	'w_pass' => m_a_p('w_pass'),
	'copyright' => m_a_p('copyright'),
	'home_seo_content' => m_a_p('home_seo_content'),
	'google_app_link' => m_a_p('google_app_link'),
	'head_codes' => m_a_p('head_codes'),
	'auto_ads_code' => m_a_p('auto_ads_code'),
	'footer_codes' => m_a_p('footer_codes')
	];
	
	$query = $db->table('settings')->where('id','=',1)->update($data);
	if($query)
	{
		echo m_alert('Başarılı','İşleminiz başarıyla gerçekleştirildi.');
	}
	else
	{
		echo m_alert('Hata','İşlem gerçekleştirilirken bir hata oluştu.');
	}
	
	$informations = $db->table('settings')->where('id','=',1)->get();
	$info = $informations['data'][0];
	
}
?>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Logo:</label>
		<div class="col-lg-9">
			<img src="<?php echo m_image_url($info['logo']); ?>" class="img-thumbnail" style="max-width:100px">
			<br>
			<br>
			<input type="file" class="form-control" name="logo">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Mobil Logo:</label>
		<div class="col-lg-9">
			<img src="<?php echo m_image_url($info['logo_mobile']); ?>" class="img-thumbnail" style="max-width:100px">
			<br>
			<br>
			<input type="file" class="form-control" name="logo_mobile">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Bakım Modu:</label>
		<div class="col-lg-9">
			<div class="form-check form-check-inline">
				<label class="form-check-label">
					<input type="radio" class="form-input-styled" name="maintenance" value="1" <?php if($info['maintenance']==1) { echo 'checked'; } ?> data-fouc>
					Aktif
				</label>
			</div>

			<div class="form-check form-check-inline">
				<label class="form-check-label">
					<input type="radio" class="form-input-styled" name="maintenance" value="0" <?php if($info['maintenance']==0) { echo 'checked'; } ?> data-fouc>
					Pasif
				</label>
			</div>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Google Play Linki:</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="google_app_link" value="<?php echo $info['google_app_link']; ?>">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Email:</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="email" value="<?php echo $info['email']; ?>">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">İşbirliği Email:</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="ads_email" value="<?php echo $info['ads_email']; ?>">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Telefon:</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="phone" value="<?php echo $info['phone']; ?>">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Adres:</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="address" value="<?php echo $info['address']; ?>">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Copyright:</label>
		<div class="col-lg-9">
			<textarea name="copyright" class="form-control" style="width:100%;height:100px;"><?php echo $info['copyright']; ?></textarea>
		</div>
	</div>


</div>
</div>

<div class="card">
<div class="card-header bg-dark text-white header-elements-inline">
<h5 class="card-title">Haftanın Kategorisi - Ek Ücreti</h5>
</div>

<div class="card-body">
	
	
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Kategori:</label>
		<div class="col-lg-9">
			<select class="form-control select2" name="week_category" id="week_category">
			<?php
			$categories = $db->table('categories')->where('c_id','=',0)->where('status','=','1')->order('title','asc')->get();
			foreach($categories['data'] as $category)
			{
				if(strstr($info['week_category'],'['.$category['id'].']'))
				{
					$selected=' selected="selected"';
				}
				else
				{
					$selected='';
				}
				
				echo '<option value="['.$category['id'].']"'.$selected.'><b>'.$category['title'].'</b></option>';
				$sub_categories = $db->table('categories')->where('c_id','=',$category['id'])->where('status','=','1')->order('title','asc')->get();
				foreach($sub_categories['data'] as $sub_category)
				{
					if(strstr($info['week_category'],'['.$sub_category['id'].']'))
					{
						$selected=' selected="selected"';
					}
					else
					{
						$selected='';
					}
					
					echo '<option value="['.$sub_category['id'].']"'.$selected.'>- '.$sub_category['title'].'</option>';
				}
			}
			?>
			</select>
		</div>
	</div>
	
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Ek Ücret:</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="week_category_fee" value="<?php echo $info['week_category_fee']; ?>">
		</div>
	</div>

</div>
</div>

<div class="card">
<div class="card-header bg-dark text-white header-elements-inline">
<h5 class="card-title">Haftanın Panoraması</h5>
</div>

<div class="card-body">
	
	
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Marka:</label>
		<div class="col-lg-9">
			<select class="form-control select_search" name="week_brand" id="brand">
			<?php
			$brands = $db->table('brands')->where('status','=','1')->where('id','=',$info['week_brand'])->order('title','asc')->get();
			foreach($brands['data'] as $brand)
			{
			
				if($info['week_brand']==$brand['id'])
				{
					$selected=' selected="selected"';
				}
				else
				{
					$selected='';
				}
				echo '<option value="'.$brand['id'].'"'.$selected.'>'.$brand['title'].'</option>';
				
			}
			?>
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Ürün:</label>
		<div class="col-lg-9">
			<select class="form-control product_select_search" name="week_product" id="product_id">
			<?php
			$products = $db->table('products')->where('id','=',$info['week_product'])->order('title','asc')->limit(1)->get();
			foreach($products['data'] as $product)
			{
			
				if($info['week_product']==$product['id'])
				{
					$selected=' selected="selected"';
				}
				else
				{
					$selected='';
				}
				echo '<option value="'.$product['id'].'"'.$selected.'>'.$product['title'].'</option>';
				
			}
			?>
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Yazar:</label>
		<div class="col-lg-9">
			<select class="form-control select2" name="week_user" id="week_user">
			<?php
			$users = $db->table('users')->where('status','=',1)->order('username','asc')->get();
			foreach($users['data'] as $user)
			{
			
				if($info['week_user']==$user['id'])
				{
					$selected=' selected="selected"';
				}
				else
				{
					$selected='';
				}
				echo '<option value="'.$user['id'].'"'.$selected.'>'.$user['username'].'</option>';
				
			}
			?>
			</select>
		</div>
	</div>

</div>
</div>

<div class="card">
<div class="card-header bg-dark text-white header-elements-inline">
<h5 class="card-title">Ödeme Ayarları</h5>
</div>

<div class="card-body">
	
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Sitede Kalma 10 Saniye Başına Ödeme:</label>
		<div class="col-lg-9">
			<div class="form-check form-check-inline">
				<label class="form-check-label">
					<input type="radio" class="form-input-styled" name="fee_per_time_on_status" value="1" <?php if($info['fee_per_time_on_status']==1) { echo 'checked'; } ?> data-fouc>
					Aktif
				</label>
			</div>

			<div class="form-check form-check-inline">
				<label class="form-check-label">
					<input type="radio" class="form-input-styled" name="fee_per_time_on_status" value="0" <?php if($info['fee_per_time_on_status']==0) { echo 'checked'; } ?> data-fouc>
					Pasif
				</label>
			</div>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">İnceleme Ekleme Başına Ödeme:</label>
		<div class="col-lg-9">
			<div class="form-check form-check-inline">
				<label class="form-check-label">
					<input type="radio" class="form-input-styled" name="fee_per_review_status" value="1" <?php if($info['fee_per_review_status']==1) { echo 'checked'; } ?> data-fouc>
					Aktif
				</label>
			</div>

			<div class="form-check form-check-inline">
				<label class="form-check-label">
					<input type="radio" class="form-input-styled" name="fee_per_review_status" value="0" <?php if($info['fee_per_review_status']==0) { echo 'checked'; } ?> data-fouc>
					Pasif
				</label>
			</div>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Minumum Çekim:</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="min_withdraw" value="<?php echo $info['min_withdraw']; ?>">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Sitede Kalma 10 Saniye Kazanç:</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="fee_per_time_on" value="<?php echo $info['fee_per_time_on']; ?>">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Referans Üye Kazanç:</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="referer_amount" value="<?php echo $info['referer_amount']; ?>">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Referansdan Çekim Kazanç Yüzdesi:</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="referer_withdraw_amount" value="<?php echo $info['referer_withdraw_amount']; ?>">
		</div>
	</div>

</div>
</div>

<div class="card">
<div class="card-header bg-dark text-white header-elements-inline">
<h5 class="card-title">Webmail SMTP Ayarları</h5>
</div>

<div class="card-body">
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Webmail Firma Adı ( Başlık ):</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="w_title" value="<?php echo $info['w_title']; ?>">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Webmail Host:</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="w_host" value="<?php echo $info['w_host']; ?>">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Webmail Port:</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="w_port" value="<?php echo $info['w_port']; ?>">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Webmail Email:</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="w_email" value="<?php echo $info['w_email']; ?>">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Webmail Şifre:</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="w_pass" value="<?php echo $info['w_pass']; ?>">
		</div>
	</div>

</div>
</div>


<div class="card">
<div class="card-header bg-dark text-white header-elements-inline">
<h5 class="card-title">Seo İçerikleri</h5>
</div>

<div class="card-body">
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Anasayfa:</label>
		<div class="col-lg-9">
			<textarea name="home_seo_content" class="summernote"><?php echo $info['home_seo_content']; ?></textarea>
		</div>
	</div>

</div>
</div>

<div class="card">
<div class="card-header bg-dark text-white header-elements-inline">
<h5 class="card-title">Sosyal Medya Ayarları</h5>
</div>

<div class="card-body">
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Facebook:</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="facebook" value="<?php echo $info['facebook']; ?>">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Twitter:</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="twitter" value="<?php echo $info['twitter']; ?>">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">İnstagram:</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="instagram" value="<?php echo $info['instagram']; ?>">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Linkedin:</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="linkedin" value="<?php echo $info['linkedin']; ?>">
		</div>
	</div>

</div>
</div>


<div class="card">
<div class="card-header bg-dark text-white header-elements-inline">
<h5 class="card-title">Kod Ayarları</h5>
</div>

<div class="card-body">
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Otomatik Reklam Kodu:</label>
		<div class="col-lg-9">
					<textarea name="auto_ads_code" class="form-control" style="width:100%;height:200px;"><?php echo $info['auto_ads_code']; ?></textarea>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Header Kodları:</label>
		<div class="col-lg-9">
					<textarea name="head_codes" class="form-control" style="width:100%;height:200px;"><?php echo $info['head_codes']; ?></textarea>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Footer Kodları ( Analytics, Canlı Destek, Whatsapp v.b ):</label>
		<div class="col-lg-9">
					<textarea name="footer_codes" class="form-control" style="width:100%;height:200px;"><?php echo $info['footer_codes']; ?></textarea>
		</div>
	</div>

</div>
</div>

<div>
<button type="submit" class="btn btn-primary">Kaydet <i class="icon-paperplane ml-2"></i></button>
</div>
</form>
</div>
