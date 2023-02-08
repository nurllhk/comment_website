<?php
require_once('../init.php');
if(!m_moderator_check())
{
	m_redirect(MODERATOR_URL.'/login.php');
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
		if(m_a_g('table')=='comments')
		{
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