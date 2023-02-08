<?php
	m_header();
?>
   
<div class="main">
<div class="container">

	<div class="row">

	
	<div class="col-xl-12 col-lg-12 col-sm-12">
	
	<div class="page_head">
	<div class="page_icon"><i class="fa fa-exclamation-triangle"></i></div>
	<div class="page_title"><h1>İnceleme Red Nedenleri</h1></div>
	
	</div>
	</div>
	
	<div class="col-xl-12 col-lg-12 col-sm-12">
	
	<div class="alert alert-info mb-2"><i class="fa fa-info-circle"></i> İncelemeleriniz reddedildiğinde veya düzenleme istediğinde bu sayfadaki bilgilerden yararlanabilirsiniz.</div>

		<ol class="list-group">
		<?php
		$informations = $db->table('rejected_types')->order('rt_rank','asc')->get();
		if($informations['total_count']>0)
		{
			foreach($informations['data'] as $info)
			{
				echo ' <li id="rejected_type_'.$info['id'].'" class="list-group-item d-flex justify-content-between align-items-start">
					<div class="ms-2 me-auto">
					  <div class="fw-bold mb-2"><i class="'.$info['icon'].' text-info me-3"></i> '.$info['title'].'</div>
					  '.$info['content'].'
					</div>
				  </li>';
			}
		}
		?>
		 
		</ol>
	</div>
	</div>
	
</div>
</div>

<?php
	m_footer();
?>
					