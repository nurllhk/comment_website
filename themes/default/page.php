<?php
	m_header();
	$informations = $db->table('pages')->where('sef','=',m_u_g('sef'))->where('status','=',1)->get();
	if($informations['total_count']=='0')
	{
		m_redirect(SITE_DOMAIN);
	}
	$info = $informations['data'][0];
?>
<div class="main">
	<div class="container">
		<div class="row">
		<div class="col-xl-12 col-lg-12 col-sm-12 col-12">
		<div class="page_head">
		<div class="page_icon"><i class="fa fa-info-circle"></i></div>
		<div class="page_title"><h1><?php echo $info['title']; ?></h1></div>
		</div>
		<div class="mt-3">
		<div class="row">
		
		<div class="col-xl-12 col-lg-12 col-sm-12">
		
		<div class="content_box">
		
		<?php echo $info['content']; ?>
		
		</div>
		
		
		</div>
		
		
		
		</div>
		</div>
		</div>
		
		
		
		</div>
	</div>
</div>
<?php
	m_footer();
?>
					