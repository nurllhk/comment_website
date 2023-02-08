<?php
include('../init.php');
exit;
$informations = $db->table('reviews')->where_set('date','<=','DATE_SUB(NOW(), INTERVAL 3 DAY)')->where('status','=',2)->order('id','asc')->get();
foreach($informations['data'] as $info)
{
	m_content_image_remover($info['content']);
	$db->table('reviews')->where('id','=',$info['id'])->delete();
}
$db->query('REPAR TABLE reviews');