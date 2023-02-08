<?php
require_once('../init.php');
require_once 'google_inc/Google_Client.php';
require_once 'google_inc/contrib/Google_Oauth2Service.php';

$client = new Google_Client();
$client->setApplicationName('Acikliyorum.com');//uygulama ismi
$client->setClientId('680239471402-aegattgn7p3rtdgpune8ndpj6t0goarl.apps.googleusercontent.com'); //İstemci kimliği (Client ID) ekleme kısmı
$client->setClientSecret('4tJ0Bm1uIs0uUY61WAXV5ytG'); //İstemci gizli anahtarı (Client Secret) ekleme kısmı
$client->setRedirectUri(SITE_DOMAIN.'/auth/google'); //kullanıcının yönlendirileceği sayfa yolu
$oauth2 = new Google_Oauth2Service($client);
if (isset($_GET['code'])){//google ile giriş yap sayfasında kullanıcı hesabıyla giriş yapar ise sitemize geri yönlendirilecek. yönlendirme url adresi içerisinde 'code' parametresi bulunmakta
$client->authenticate($_GET['code']);//giriş sayfasından gelen 'code' bilgisi ile kimlik doğrulaması yapılıyor ve erişim anahtarı (access token) elde ediliyor
$_SESSION['token'] = $client->getAccessToken();//erişim anahtarını session değişkenine atıyoruz
header('Location: '.SITE_DOMAIN.'/auth/google');//ve kullanıcıyı yönlendiriyoruz, sayfayı yeniliyoruz
return;
}
if (isset($_SESSION['token'])){//erişim anahtarı var ise
$client->setAccessToken($_SESSION['token']);//erişim anahtarını aktif et
$user = $oauth2->userinfo->get();//kullanıcı bilgilerini getir
$s_uye_id = $user['id'];
$s_uye_isim = $user['name'];
$s_uye_resim = $user['picture'];
$s_uye_email = filter_var($user['email'], FILTER_SANITIZE_EMAIL);

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




}else{
$authUrl = $client->createAuthUrl();//google üzerinden giriş yapılacak sayfanın url adresi oluşturuluyor
header('Location: '.$authUrl);//google giriş sayfasına yönlendir
}
/*
unset($_SESSION['token']); //jeton değerinin bulunduğu session değişkenini sil
$client->revokeToken(); //jetonu sil
*/