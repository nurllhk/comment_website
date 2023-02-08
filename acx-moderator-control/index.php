<?php
require_once('../init.php');
if(!m_admin_check())
{
	m_redirect(MADMIN_URL.'/login.php');
}
define('ADMIN_INCLUDED', TRUE);
require_once ('theme/header.php');
if(m_a_g('page')=='')
{
	
	require_once('inc/default.php');
	
}
else
{
	if(m_a_g('page')=='delete')
	{
		
		switch(m_a_g('table'))
		{
			case 'reviews':
					$info = $db->table('reviews')->where('id','=',m_a_g('id'))->get_vars();
					m_content_image_remover($info['content']);
					$db->query("delete from review_views where r_id='".$info['id']."'");
					$db->query("delete from comments where r_id='".$info['id']."'");
					$db->table(m_a_g('table'))->where('id','=',m_a_g('id'))->delete();
			break;
			case 'products':
					$info = $db->table('products')->where('id','=',m_a_g('id'))->get_vars();
					m_image_remover($info['image']);
					$informations = $db->table('reviews')->where('p_id','=',m_a_g('id'))->get();
					foreach($informations['data'] as $info)
					{
						m_content_image_remover($info['content']);
						$db->query("delete from review_views where r_id='".$info['id']."'");
						$db->query("delete from comments where r_id='".$info['id']."'");
					}
					$db->table(m_a_g('table'))->where('id','=',m_a_g('id'))->delete();
			break;
			case 'brands':
					$info = $db->table('brands')->where('id','=',m_a_g('id'))->get_vars();
					m_image_remover($info['image']);
					$db->table(m_a_g('table'))->where('id','=',m_a_g('id'))->delete();
			break;
			case 'users':
					$info = $db->table('users')->where('id','=',m_a_g('id'))->get_vars();
					m_image_remover($info['image']);
					$informations = $db->table('reviews')->where('u_id','=',m_a_g('id'))->get();
					foreach($informations['data'] as $info)
					{
						m_content_image_remover($info['content']);
						$db->query("delete from review_views where r_id='".$info['id']."'");
						$db->query("delete from comments where r_id='".$info['id']."'");
						$db->query("delete from reviews where id='".$info['id']."'");
					}
					$db->table(m_a_g('table'))->where('id','=',m_a_g('id'))->delete();
					$db->table('user_followers')->where('u_id','=',m_a_g('id'))->delete();
					$db->table('user_followers')->where('follow_user','=',m_a_g('id'))->delete();
					$db->table('user_inbox')->where('user_to','=',m_a_g('id'))->delete();
					$db->table('user_send')->where('user_from','=',m_a_g('id'))->delete();
					$db->table('user_balances')->where('u_id','=',m_a_g('id'))->delete();
					$db->query("update users set referer='0' where referer='".m_a_g('id')."'");
					$informations = $db->table('support_messages')->where('u_id','=',m_a_g('id'))->get();
					foreach($informations['data'] as $info)
					{
						$db->table('support_messages')->where('s_id','=',$info['id'])->delete();
					}
					$db->table('support')->where('u_id','=',m_a_g('id'))->delete();
			break;
			case 'support':
					$db->table('support_messages')->where('s_id','=',m_a_g('id'))->delete();
					$db->table(m_a_g('table'))->where('id','=',m_a_g('id'))->delete();
			break;
			default:
			$db->table(m_a_g('table'))->where('id','=',m_a_g('id'))->delete();
		}
		m_redirect($_SERVER['HTTP_REFERER']);
	}
	else
	{
		require_once('inc/'.m_a_g('page').'.php');
	}
}
require_once('theme/footer.php');

?>