<?php if(!defined('ADMIN_INCLUDED')) { exit; } ?>
<div class="content">
<div class="navbar navbar-dark navbar-expand-md navbar-component">
<div class="d-md-none">
</div>
<div class="collapse navbar-collapse" id="navbar-component">
	<ul class="navbar-nav">
		<li class="nav-item">
			<a href="<?php echo ADMIN_URL;?>/index.php?page=products" class="navbar-nav-link">Ürünler</a>
		</li>
		<li class="nav-item">
			<a href="#" class="navbar-nav-link"><i class="fa fa-share"></i></a>
		</li>
		<li class="nav-item">
			<a href="#" class="navbar-nav-link">Ürün</a>
		</li>
	</ul>

</div>
</div>
<div class="card">
<div class="card-header bg-dark text-white header-elements-inline">
<h5 class="card-title">Ürün Ekle</h5>
</div>

<div class="card-body">
<?php
if($_POST)
{

	if($_FILES['image']['name']=='')
	{
		$image = '';
	}
	else
	{
		
		$upload=m_image_uploader('image','product_'.m_sef(m_a_p('title')).'_'.uniqid().'',true,true);
		$image = $upload[0];
	}
	if(m_a_p('b_id')=='')
	{
		$b_id = 0;
	}
	else
	{
		$b_id = m_a_p('b_id');
	}
	$data = [
	'c_id' => implode($_POST['c_id']),
	'b_id' => $b_id,
	'title' => m_a_p('title'),
	'price' => m_a_p('price'),
	'gtin_no' => m_a_p('gtin_no'),
	'sef' => m_sef(m_a_p('title')),
	'image' => $image,
	'status' => 1
	
	];
	
	$query = $db->table('products')->insert($data);
	if($query)
	{
		echo m_alert('Başarılı','İşleminiz başarıyla gerçekleştirildi.');
	}
	else
	{
		if($upload[0]!='')
		{
			unlink(UPLOAD_DIR.'/images/'.$upload[0]);
		}
		echo m_alert('Hata','İşlem gerçekleştirilirken bir hata oluştu.');
	}
	
}
?>
<form action="" method="post" enctype="multipart/form-data">
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Ürün Resmi:</label>
		<div class="col-lg-9">
			<input type="file" class="form-control" name="image">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Kategori:</label>
		<div class="col-lg-9">
			<select class="form-control select2" name="c_id[]" multiple>
			<?php
			$categories = $db->table('categories')->where('c_id','=',0)->where('status','=','1')->order('title','asc')->get();
			foreach($categories['data'] as $category)
			{
			
				
				echo '<option value="['.$category['id'].']"><b>'.$category['title'].'</b></option>';
				$sub_categories = $db->table('categories')->where('c_id','=',$category['id'])->where('status','=','1')->order('title','asc')->get();
				foreach($sub_categories['data'] as $sub_category)
				{
					
					
					echo '<option value="['.$category['id'].']['.$sub_category['id'].']">- '.$sub_category['title'].'</option>';
				}
			}
			?>
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Marka:</label>
		<div class="col-lg-9">
			<select class="form-control select_search" name="b_id">
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Ürün Adı</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="title" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Ürün Fiyatı</label>
		<div class="col-lg-9">
			<input type="number" class="form-control" name="price" value="0" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Ürün Barkodu</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="gtin_no">
		</div>
	</div>

	<div>
		<button type="submit" class="btn btn-primary">Ekle <i class="icon-paperplane ml-2"></i></button>
	</div>
</form>
</div>
</div>
</div>
