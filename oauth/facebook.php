<?php
require_once('../init.php');
require 'facebook_inc/facebook.php';
$facebook = new Facebook(array( //developers.facebook.com/ sayfasında oluşturulan login uygulamasının appId ve secret bilgilerini buraya ekliyoruz
				'appId' => '532981881504663',
				'secret' => '16670acd022153a3b415b0e7e7d43bc9',
				'cookie' => false
			));
$userid = $facebook->getUser(); //Kullanıcı onay verip giriş yaptı ise üye id bilgisini, değil ise 0 döndürür
if ($userid){ //üye giriş yaptı ise
	try{
		$profile = $facebook->api('/me', array('fields' => 'id,email,name,picture.type(large),gender')); //kullanıcının id, email, isim alacağımızı tanımlıyoruz, scope değerine email parametresini eklediğimiz için email bilgisini çekmek istediğimizi belirtiyoruz
	}catch(FacebookApiException $e){
		print $e->getMessage();
		$userid = null;
	}
	//kullanıcı bilgileri değişkenlere aktarılıyor
	$s_uye_id = $profile['id'];
	$s_uye_isim = $profile['name'];
	$s_uye_picture = $profile['picture']['data']['url'];
	$s_uye_email = filter_var($profile['email'], FILTER_SANITIZE_EMAIL);
	$varmi = $db->table('users')->where('email','=',$s_uye_email)->get();
	if($varmi['total_count']==0)
	{
								$referer = 0;
								if(m_get_session('referer')!='')
								{
									$referer_user_count = $db->table('users')->where('referer_key','=',m_get_session('referer'))->count();
								   if($referer_user_count>0)
								   {
									   $referer = $db->table('users')->where('referer_key','=',m_get_session('referer'))->get_var('id');
									   
								   }
								   else
								   {
									   $referer = 0;
								   }
								}
								$data = [
								'referer' => $referer,
								'referer_key' => uniqid(),
								'username' => m_username_sef($s_uye_isim),
								'phone' => '',
								'email' => $s_uye_email,
								'gender' => 'Erkek',
								'password' => md5(uniqid()),
								'sef' => m_username_sef($s_uye_isim),
								'register_date' => $db->now(),
								'register_ip' => m_ip(),
								'last_login' => $db->now(),
								'last_ip' => m_ip(),
								'status' => 1
								
								];
								$query = $db->table('users')->insert($data);
								if($referer!=0)
								{
									user_balances_add(true,$query,m_setting('referer_amount'),'referer',$referer,'Referanslı Üye Kazançı');
								}
								m_set_session('referer','');
								m_set_session('m_user',$query);
								m_redirect(SITE_DOMAIN);
	}
	else
	{
		m_set_session('m_user',$varmi['data'][0]['id']);
		m_redirect(SITE_DOMAIN);
	}
	
}else{ //daha onay vermedi ise

	$login = $facebook->getLoginUrl(array('scope' => 'email')); //kullanıcının giriş yapacağı ekran giriş url, scope parametresi ile kullanıcıdan ek bilgi istenir, parametre girilmez ise kullanıcının herkeze açık bilgileri alınır
	//$login = $facebook->getLoginUrl(array('scope' => 'email,offline_access,publish_stream,user_birthday,user_location,user_work_history,user_about_me,user_hometown'));
	header('Location:'.$login); //kullanıcının facebook giriş sayfasına yönlendiriyoruz
}