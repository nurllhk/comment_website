<?php
include('../init.php');
$informations = $db->table('users')->where('banned_msg','!=','')->order('id','desc')->get();
if($informations['total_count']>0)
{
		foreach($informations['data'] as $info)
		{
			if(time()>strtotime($info['ban_finish_time']) and $info['ban_finish_time']!='Sınırsız')
			{
				$db->query("update users set banned_msg='',ban_finish_time='' where id='".$info['id']."'");
			}
		}
}



?>