<?php
require('../init.php');
ob_get_clean();
header('Content-type: text/xml'); 
if(m_u_g('page_no')==0)
{
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
';
$informations = $db->table('users')->where('status','=',1)->pagination(50000)->order('id','asc')->get();
if($informations['total_count']>0)
{
if($informations['total_page']==0)
{
$informations['total_page'] = 1;
}
for ($x = 1; $x <= $informations['total_page']; $x++) {

echo '
<sitemap>
<loc>'.SITE_DOMAIN.'/sitemap_users_page_'.$x.'.xml</loc>
</sitemap>
';
}

echo '</sitemapindex>';
}
}
else
{
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';

$informations = $db->table('users')->where('status','=',1)->pagination(50000)->order('id','asc')->get();
if($informations['total_count']>0)
{
foreach($informations['data'] as $info)
{
echo '<url>
<loc>'.m_permalink('user_profile',$info['sef'],$info['id']).'</loc>
</url>
';
}

}
echo'</urlset>';
}