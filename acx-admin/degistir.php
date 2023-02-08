<?php
include('../init.php');
if(!m_admin_check())
{
	m_redirect(ADMIN_URL.'/login.php');
}
define('ADMIN_INCLUDED', TRUE);
function m_copy($url,$target)
{
		
		$ch = curl_init();
		$timeout = 7;
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
		curl_setopt($ch, CURLOPT_REFERER,$url);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$data= curl_exec($ch);
		curl_close($ch);
		file_put_contents($target,$data);
}
function m_image_download($url,$name)
{
	$upload_name = $name.'.jpg';
	m_copy($url,UPLOAD_DIR.'/images/'.$upload_name);
	$image = m_image_extension_converter(UPLOAD_DIR,$upload_name);
	$image = m_image_webp_convert(UPLOAD_DIR.'/images/'.$image);
	return $image;
}
if($_POST)
{
	$return = array();
	$im = getimagesize(m_a_p('link'));
	if($im[0]>0)
	{
		
		$image = m_image_download(m_a_p('link'),"".m_sef(m_a_p('title')."_".uniqid())."");
		$data = [
		'image' => $image
		];
		
		$query = $db->table('brands')->where('id','=',m_a_p('id'))->update($data);
		$return['status'] = true;
	}
	else
	{
		$return['status'] = false;
	}
	echo json_encode($return);
}