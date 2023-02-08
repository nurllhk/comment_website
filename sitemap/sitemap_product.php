<?php
require('../init.php');
ob_get_clean();
header('Content-type: text/xml'); 
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';

$informations = $db->table('products')->where('status','=',1)->pagination(20000)->order('id','asc')->get();
if($informations['total_count']>0)
{
foreach($informations['data'] as $info)
{
echo '<url>
<loc>'.m_permalink('product',$info['sef'],$info['id']).'</loc>
</url>
';
}

}
echo'</urlset>';