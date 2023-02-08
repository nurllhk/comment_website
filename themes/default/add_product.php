<?php
	m_header();
?>  
<div class="main">
	<div class="container">
		<div class="row">
		<div class="col-xl-12 col-lg-12 col-sm-12 col-12">
		<div class="page_head">
		<div class="page_icon"><i class="fa fa-plus-circle"></i></div>
		<div class="page_title"><h1>Ürün Ekle</h1></div>
		</div>
		<div class="mt-3">
		<div class="row">
		
		<div class="col-xl-12 col-lg-12 col-sm-12">
		
		<div class="card">
		<div class="card-header card_tab_header">
			  <ul class="nav nav-tabs card-header-tabs" id="pills-tab" role="tablist">
			  <li class="nav-item">
				<a class="nav-link active" href="<?php echo m_permalink('add_product'); ?>">Yeni Ekle</a>
			  </li>
			  <li class="nav-item">
			   <a class="nav-link" href="<?php echo m_permalink('add_review'); ?>">Önce Sitede Bul</a>
			  </li>
			  </ul>
		</div>
		  <div class="card-body">  

			<?php
			if($_POST['title'])
			{
				if(m_u_p('title')=='' or m_u_p('c_id')=='' or m_u_p('title')=='' or $_FILES['image']['name']=='')
				{
					echo m_alert('Hata','Lütfen, ürün başlığı, kategori ve ürün görselini ekleyiniz');
				}
				else
				{
					  
							$upload	= m_image_uploader('image','product_'.m_sef(m_u_p('title')).'_'.uniqid(),true,true);
							
							if($upload[0]!='')
							{
								$image = $upload[0];
								$data = [
								'add_user' => USER['id'],
								'c_id' => $_POST['c_id'],
								'b_id' => m_u_p('b_id'),
								'title' => m_u_p('title'),
								'sef' => m_sef(m_u_p('title')),
								'image' => $image,
								'status' => 0
								
								];
								
								$product_id = $db->table('products')->insert($data);
								m_redirect(m_permalink('add_review_detail',$product_id));
							}
							else
							{
								echo m_alert('Hata','Ürün Görseli 2 MB dan daha büyük veya JPEG/PNG formatında değil. Lütfen tekrar yüklemeyi deneyiniz.');
							}
					 
				}
			}
			?>
			 <form method="post" action="" class="add_product data-edit mb-3"  enctype="multipart/form-data" autocomplete="off">
				<div class="mb-3">
				  <label class="form-label">Kategori</label>
				  <select class="form-select select2" name="c_id" style="width:100%" id="product_select">
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
				<div class="mb-3">
				  <label class="form-label">Marka</label>
				  <select class="form-select select2 brand_search" name="b_id" style="width:100%" id="brand_select">
				  </select>
				</div>
				<div class="mb-3">
				  <label class="form-label">Ürün Başlığı</label>
				  <input class="form-control" name="title" type="text" required value="<?php echo m_u_p('title'); ?>">
				</div>
				<div class="mb-3">
				  <label class="form-label">Ürün Görseli</b></label>
				  <input class="form-control" name="image" type="file" accept="image/png, image/jpeg">
				</div>
				 <button id="" type="submit" class="btn btn-default btn-sm"><i class="fa fa-arrow-right"></i> Sonraki Adım</button>
			</form>
			
		  </div>
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