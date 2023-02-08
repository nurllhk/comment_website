<?php
require('../init.php');
ob_get_clean();
header('Content-type: text/xml'); 
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
echo '
<url>
<loc>'.SITE_DOMAIN.'</loc>
</url>
';
echo '<url>
<loc>'.m_permalink('login').'</loc>
</url>
';
echo '<url>
<loc>'.m_permalink('register').'</loc>
</url>
';
echo '<url>
<loc>'.m_permalink('forgot_password').'</loc>
</url>
';
echo '<url>
<loc>'.m_permalink('how_to_work').'</loc>
</url>
';
echo '<url>
<loc>'.m_permalink('brands').'</loc>
</url>
';
echo '<url>
<loc>'.m_permalink('positive_reviews').'</loc>
</url>
';
echo '<url>
<loc>'.m_permalink('negative_reviews').'</loc>
</url>
';
echo '<url>
<loc>'.m_permalink('tops').'</loc>
</url>
';
echo '<url>
<loc>'.m_permalink('contact').'</loc>
</url>
';
$informations = $db->table('pages')->where('status','=',1)->order('id','asc')->get();
if($informations['total_count']>0)
{
foreach($informations['data'] as $info)
{
echo '<url>
<loc>'.m_permalink('page',$info['sef']).'</loc>
</url>
';
}
}
?>
</urlset>