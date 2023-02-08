<?php if(!defined('ADMIN_INCLUDED')) { exit; } ?>
<?php
	$informations = $db->table('contact')->where('id','=',m_a_g('id'))->get();
	if($informations['total_count']=='0')
	{
		m_redirect(MADMIN_URL);
	}
	$info = $informations['data'][0];
	$query = $db->table('contact')->where('id','=',m_a_g('id'))->update(array('status'=>'1'));
?>   
<div class="content">
<div class="navbar navbar-dark navbar-expand-md navbar-component">
<div class="d-md-none">
</div>
<div class="collapse navbar-collapse" id="navbar-component">
	<ul class="navbar-nav">
		<li class="nav-item">
			<a href="<?php echo MADMIN_URL;?>/index.php?page=contact" class="navbar-nav-link">Mesajlar</a>
		</li>
		<li class="nav-item">
			<a href="#" class="navbar-nav-link"><i class="fa fa-share"></i></a>
		</li>
		<li class="nav-item">
			<a href="#" class="navbar-nav-link">Mesaj</a>
		</li>
	</ul>

</div>
</div>
<div class="card">
<div class="card-header bg-dark text-white header-elements-inline">
<h5 class="card-title">Mesaj Detayları</h5>
</div>

<div class="card-body">
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Tarih</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" value="<?php echo m_date_to_tr($info['date']); ?>" disabled>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">IP</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" value="<?php echo $info['ip']; ?>" disabled>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">İsim</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" value="<?php echo $info['name']; ?>" disabled>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Email</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" value="<?php echo $info['email']; ?>" disabled>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Telefon</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" value="<?php echo $info['phone']; ?>" disabled>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Konu</label>
		<div class="col-lg-9">
			<input type="text" class="form-control" value="<?php echo $info['subject']; ?>" disabled>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-lg-3 col-form-label">Mesaj</label>
		<div class="col-lg-9">
			<textarea class="summernote"><?php echo $info['msg']; ?></textarea>
		</div>
	</div>
</div>
</div>
</div>
