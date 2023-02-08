<?php if(!defined('ADMIN_INCLUDED')) { exit; } ?>
<div class="content">


<div class="card">
		<div class="card-header header-elements-sm-inline">
			<h6 class="card-title">Alt Kategoriler</h6>
			<div class="text-right" style="margin-right:10px;">
			<a href="<?php echo MADMIN_URL; ?>/index.php?page=category_add"><span class="btn bg-success-400 btn-labeled btn-labeled-left"><b><i class="icon-add"></i></b> Kategori Ekle</span></a>
			</div>
		</div>

		<div class="card-body">
		<input type="text" class="form-control ajax_table_search" placeholder="Aramak için yazınız.">
		</div>
		<div class="ajax_table" rel="sub_categories" data-id="<?php echo m_a_g('id'); ?>">
		<div class="ajax_table_loading"><i class="fa fa-spinner fa-spin fa-5x"></i></div>
		<div class="ajax_table_content">
		
		</div>
		</div>
</div>

</div>



