<?php if(!defined('ADMIN_INCLUDED')) { exit; } ?>
<div class="content">

<div class="card">
	<div class="card-header header-elements-sm-inline">
		<h6 class="card-title">Yorumlar</h6>
	</div>
	<div class="card-body">
	<form class="ajax_table_search">
		<input type="hidden" name="type" value="data_table">
		<input type="hidden" name="table" value="comments">
		<input type="text" class="form-control mb-3 text_search" name="q" placeholder="Aramak için yazın ve enterlayın.">
		<div class="row">
			<div class="col-lg-4 mt-2">
	
				<div class="input-group">
				<span class="input-group-prepend">
					<span class="input-group-text font-weight-bold">Durum</span>
				</span>
				<select class="form-control select2" name="filters[status]">
					<option value="0">Onay Bekliyor</option>
					<option value="1">Onaylandı</option>
				</select>
				</div>
				
			</div>
			<div class="col-lg-4 mt-2">
	
				<div class="input-group">
				<span class="input-group-prepend">
					<span class="input-group-text font-weight-bold">Sıralanacak</span>
				</span>
				<select class="form-control select2" name="order">
					<option value="id">ID</option>
				</select>
				</div>
				
			</div>
			
			<div class="col-lg-4 mt-2">
			
				<div class="input-group">
				<span class="input-group-prepend">
					<span class="input-group-text font-weight-bold">Sıralama Tipi</span>
				</span>
				<select class="form-control select2" name="order_by">
					<option value="asc">Eskiden Yeniye</option>
					<option value="desc">Yeniden Eskiye</option>
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



