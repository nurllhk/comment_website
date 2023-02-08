<?php if(!defined('ADMIN_INCLUDED')) { exit; } ?>
<?php
	$informations = $db->table('products')->where('id','=',m_a_g('id'))->get();
	if($informations['total_count']=='0')
	{
		m_redirect(ADMIN_URL);
	}
	$info = $informations['data'][0];
?>   
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
<h5 class="card-title">Ürün Düzenle</h5>
</div>

<div class="card-body">
<?php
if($_POST)
{
		if($_FILES['image']['name']=="")
		{
			$image = $info['image'];
		}
		else
		{
			
			$upload=m_image_uploader('image','product_'.m_sef(m_a_p('title')).'_'.uniqid().'',true,true);
			$image=$upload[0];
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
		'status' => m_a_p('status')
		
		];
		$db->query("update reviews set c_id='".implode($_POST['c_id'])."' where p_id='".$info['id']."'");
		$db->query("update reviews set b_id='".m_a_p('b_id')."' where p_id='".$info['id']."'");
		$query = $db->table('products')->where('id','=',m_a_g('id'))->update($data);
		
		if($query)
		{
			if($upload[0]!='')
			{
				unlink(UPLOAD_DIR.'/images/'.$info['image']);
			}
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
		
		$informations = $db->table('products')->where('id','=',m_a_g('id'))->get();
		$info = $informations['data'][0];
	
}
?>
<form action="" method="post" enctype="multipart/form-data">
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Durum:</label>
		<div class="col-lg-9">
			<div class="form-check form-check-inline">
				<label class="form-check-label">
					<input type="radio" class="form-input-styled" name="status" value="1" <?php if($info['status']==1) { echo 'checked'; } ?> data-fouc>
					Aktif
				</label>
			</div>

			<div class="form-check form-check-inline">
				<label class="form-check-label">
					<input type="radio" class="form-input-styled" name="status" value="0" <?php if($info['status']==0) { echo 'checked'; } ?> data-fouc>
					Pasif
				</label>
			</div>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3">Ürün Linki:</label>
		<div class="col-lg-9">
			<a href="<?php echo m_permalink('product',$info['sef'],$info['id']); ?>" target="_blank">Sitede Gör</a>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Ürün Resmi:</label>
		<div class="col-lg-9">
			<a href="<?php echo m_image_url($info['image']); ?>" data-popup="lightbox"><img src="<?php echo m_image_url($info['image']); ?>" class="img-thumbnail" style="width:100px;height:100px"></a>
			<br>
			<br>
			<input type="file" class="form-control" name="image">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Kategori:</label>
		<div class="col-lg-9">
			<select class="form-control select2" name="c_id[]" multiple id="c_id">
			<?php
			$categories = $db->table('categories')->where('c_id','=',0)->where('status','=','1')->order('title','asc')->get();
			foreach($categories['data'] as $category)
			{
				if(strstr($info['c_id'],'['.$category['id'].']'))
				{
					$selected=' selected="selected"';
				}
				else
				{
					$selected='';
				}
				
				echo '<option value="['.$category['id'].']"'.$selected.'><b>'.$category['title'].'</b></option>';
				$sub_categories = $db->table('categories')->where('c_id','=',$category['id'])->where('status','=','1')->order('title','asc')->get();
				foreach($sub_categories['data'] as $sub_category)
				{
					if(strstr($info['c_id'],'['.$sub_category['id'].']'))
					{
						$selected=' selected="selected"';
					}
					else
					{
						$selected='';
					}
					
					echo '<option value="['.$sub_category['id'].']"'.$selected.'>- '.$sub_category['title'].'</option>';
				}
			}
			?>
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Marka:</label>
		<div class="col-lg-9">
			<select class="form-control select_search" name="b_id" id="brand">
			<?php
			$brands = $db->table('brands')->where('status','=','1')->where('id','=',$info['b_id'])->order('title','asc')->get();
			foreach($brands['data'] as $brand)
			{
			
				if($info['b_id']==$brand['id'])
				{
					$selected=' selected="selected"';
				}
				else
				{
					$selected='';
				}
				echo '<option value="'.$brand['id'].'"'.$selected.'>'.$brand['title'].'</option>';
				
			}
			?>
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Ürün Adı</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="title" value="<?php echo $info['title']; ?>" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Ürün Fiyatı</label>
		<div class="col-lg-9">
			<input type="number" class="form-control" name="price" value="<?php echo $info['price']; ?>" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Ürün Barkodu</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" name="gtin_no" value="<?php echo $info['gtin_no']; ?>">
		</div>
	</div>

	<div>
		<button type="submit" class="btn btn-primary">Kaydet <i class="icon-paperplane ml-2"></i></button>
	</div>
</form>
</div>
</div>
</div>
