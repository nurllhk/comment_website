<?php if(!defined('ADMIN_INCLUDED')) { exit; } ?>
<div class="content">

<div class="card">
	<div class="card-header header-elements-sm-inline">
		<h6 class="card-title">Ürünler</h6>
		<div class="text-right" style="margin-right:10px;">
		<a href="<?php echo MODERATOR_URL; ?>/index.php?page=product_add"><span class="btn bg-success-400 btn-labeled btn-labeled-left"><b><i class="icon-add"></i></b>  Ekle</span></a>
		</div>
	</div>
	<div class="card-body">
	<form class="ajax_table_search">
		<input type="hidden" name="type" value="data_table">
		<input type="hidden" name="table" value="products">
		<input type="text" class="form-control mb-3 text_search" name="q" placeholder="Aramak için yazın ve enterlayın.">
		<select class="form-control select2" name="like_filters[c_id]">
					<option value=""><b>Tüm Kategoriler</b></option>
					<?php
					$categories = $db->table('categories')->where('c_id','=',0)->where('status','=','1')->order('title','asc')->get();
					foreach($categories['data'] as $category)
					{
						
						echo '<option value="['.$category['id'].']"><b>'.$category['title'].'</b></option>';
						$sub_categories = $db->table('categories')->where('c_id','=',$category['id'])->where('status','=','1')->order('title','asc')->get();
						foreach($sub_categories['data'] as $sub_category)
						{
							
							echo '<option value="['.$sub_category['id'].']">- '.$sub_category['title'].'</option>';
						}
					}
					?>
		</select>
		<div class="row">
			<div class="col-lg-4 mt-2">
	
				<div class="input-group">
				<span class="input-group-prepend">
					<span class="input-group-text font-weight-bold">Durum</span>
				</span>
				<select class="form-control select2" name="filters[status]">
					<option value="1">Aktif</option>
					<option value="0">Pasif</option>
				</select>
				</div>
				
			</div>
			<div class="col-lg-3 mt-2">
	
				<div class="input-group">
				<span class="input-group-prepend">
					<span class="input-group-text font-weight-bold">Sıralanacak</span>
				</span>
				<select class="form-control select2" name="order">
					<option value="id">ID</option>
					<option value="views">Görüntülenme Sayısı</option>
				</select>
				</div>
				
			</div>
			
			<div class="col-lg-2 mt-2">
			
				<div class="input-group">
				<span class="input-group-prepend">
					<span class="input-group-text font-weight-bold">Sıralama Tipi</span>
				</span>
				<select class="form-control select2" name="order_by">
					<option value="desc">Azalan</option>
					<option value="asc">Artan</option>
				</select>
				</div>
				
			</div>
			
			<div class="col-lg-3 mt-2">
			
				<div class="input-group">
				<span class="input-group-prepend">
					<span class="input-group-text font-weight-bold">Hatalı</span>
				</span>
				<select class="form-control select2" name="null_filter">
					<option value="">Boş Veri Filtrele</option>
					<option value="image">Resim</option>
				</select>
				</div>
				
			</div>
			
			
			
		</div>
	</form>
	</div>
</div>

<div class="ajax_table">
		<div class="ajax_table_loading"><i class="fa fa-spinner fa-spin fa-5x"></i></div>
		<div class="ajax_table_content">
		
</div>
</div>


</div>



