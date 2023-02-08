<?php
require('init.php');
ob_get_clean();
header('Content-type: text/xml'); 
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
';
echo '
<sitemap>
<loc>'.SITE_DOMAIN.'/sitemap_pages.xml</loc>
</sitemap>
';
echo '
<sitemap>
<loc>'.SITE_DOMAIN.'/sitemap_channels.xml</loc>
</sitemap>
';
echo '
<sitemap>
<loc>'.SITE_DOMAIN.'/sitemap_shows.xml</loc>
</sitemap>
';
echo '
<sitemap>
<loc>'.SITE_DOMAIN.'/sitemap_peoples.xml</loc>
</sitemap>
';
echo '
<sitemap>
<loc>'.SITE_DOMAIN.'/sitemap_trailers.xml</loc>
</sitemap>
';
echo '
<sitemap>
<loc>'.SITE_DOMAIN.'/sitemap_news.xml</loc>
</sitemap>
';
?>
</sitemapindex>