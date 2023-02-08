<?php
include('../init.php');
exit;
$informations = $db->table('products')->where('status','=',0)->order('id','asc')->get();
foreach($informations['data'] as $info)
{
	m_image_remover($info['image']);
	$db->table('products')->where('id','=',$info['id'])->delete();
}
$db->query('REPAR TABLE reviews');