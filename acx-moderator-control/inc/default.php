<?php if(!defined('ADMIN_INCLUDED')) { exit; } ?>
<div class="content site_informations">


<div class="row">


<div class="col-sm-3 col-lg-3">
<div class="card card-body">
<div class="media">
<div class="mr-3 align-self-center">
<i class="icon-list2 icon-2x text-info-400"></i>
</div>

<div class="media-body text-right">
<h3 class="font-weight-semibold mb-0">
<?php
echo m_number_format($db->table('categories')->count());
?>
</h3>
<span class="text-uppercase font-size-sm text-muted">KATEGORİLER</span>
</div>
</div>
</div>
</div>

<div class="col-sm-3 col-lg-3">
<div class="card card-body">
<div class="media">
<div class="mr-3 align-self-center">
<i class="icon-bookmark2 icon-2x text-info-400"></i>
</div>

<div class="media-body text-right">
<h3 class="font-weight-semibold mb-0">
<?php
echo m_number_format($db->table('brands')->count());
?>
</h3>
<span class="text-uppercase font-size-sm text-muted">MARKALAR</span>
</div>
</div>
</div>
</div>

<div class="col-sm-3 col-lg-3">
<div class="card card-body">
<div class="media">
<div class="mr-3 align-self-center">
<i class="icon-basket icon-2x text-info-400"></i>
</div>

<div class="media-body text-right">
<h3 class="font-weight-semibold mb-0">
<?php
echo m_number_format($db->table('products')->count());
?>
</h3>
<span class="text-uppercase font-size-sm text-muted">ÜRÜNLER</span>
</div>
</div>
</div>
</div>


<div class="col-sm-3 col-lg-3">
<div class="card card-body">
<div class="media">
<div class="mr-3 align-self-center">
<i class="icon-people icon-2x text-info-400"></i>
</div>

<div class="media-body text-right">
<h3 class="font-weight-semibold mb-0 total_users"><?php echo m_number_format($db->table('users')->count()); ?></h3>
<span class="text-uppercase font-size-sm text-muted">KULLANICILAR</span>
</div>
</div>
</div>
</div>



<div class="col-sm-3 col-lg-3">
<div class="card card-body">
<div class="media">
<div class="mr-3 align-self-center">
<i class="icon-pencil7 icon-2x text-success-400"></i>
</div>

<div class="media-body text-right">
<h3 class="font-weight-semibold mb-0">
<?php
echo m_number_format($db->table('reviews')->where('status','=','4')->count());
?> / <?php
echo m_number_format($db->table('reviews')->where('status','=','1')->count());
?>
</h3>
<span class="text-uppercase font-size-sm text-muted">PLANLI / YAYINDA</span>
</div>
</div>
</div>
</div>


<div class="col-sm-3 col-lg-3">
<a href="<?php echo MADMIN_URL; ?>/index.php?page=reviews&status=0" style="color:black;">
<div class="card card-body">
<div class="media">
<div class="mr-3 align-self-center">
<i class="icon-pencil7 icon-2x text-warning-400"></i>
</div>

<div class="media-body text-right">
<h3 class="font-weight-semibold mb-0">
<?php
echo m_number_format($db->table('reviews')->where('status','=','0')->where('plagiarism','=','0')->count());
?> / <?php
echo m_number_format($db->table('reviews')->where('status','=','0')->where('plagiarism','=','1')->count());
?>
</h3>
<span class="text-uppercase font-size-sm text-muted">Ö.K.B / ONAY B.</span>
</div>
</div>
</div>
</a>
</div>

<div class="col-sm-3 col-lg-3">
<a href="<?php echo MADMIN_URL; ?>/index.php?page=reviews&status=3" style="color:black;">
<div class="card card-body">
<div class="media">
<div class="mr-3 align-self-center">
<i class="icon-pencil7 icon-2x text-primary-400"></i>
</div>

<div class="media-body text-right">
<h3 class="font-weight-semibold mb-0">
<?php
echo m_number_format($db->table('reviews')->where('status','=','3')->count());
?>
</h3>
<span class="text-uppercase font-size-sm text-muted">D.B İNCELEMELER</span>
</div>
</div>
</div>
</a>
</div>

<div class="col-sm-3 col-lg-3">
<div class="card card-body">
<div class="media">
<div class="mr-3 align-self-center">
<i class="icon-pencil7 icon-2x text-danger-400"></i>
</div>

<div class="media-body text-right">
<h3 class="font-weight-semibold mb-0">
<?php
echo m_number_format($db->table('reviews')->where('status','=','2')->count());
?>
</h3>
<span class="text-uppercase font-size-sm text-muted">RED. İNCELEMELER</span>
</div>
</div>
</div>
</div>


<div class="col-sm-3 col-xl-3">
<div class="card card-body">
<div class="media">
<div class="mr-3 align-self-center">
<i class="fa fa-coins fa-2x text-primary-400"></i>
</div>

<div class="media-body text-right">
<h3 class="font-weight-semibold mb-0">
<?php
$total_balances = $db->select('sum(balance) as total')->table('users')->get();
echo m_currency($total_balances['data'][0]['total']);
?> <i class="fa fa-lira-sign"></i>
</h3>
<span class="text-uppercase font-size-sm text-muted">BAKİYELER</span>
</div>
</div>
</div>
</div>

<div class="col-sm-3 col-xl-3">
<div class="card card-body">
<div class="media">
<div class="mr-3 align-self-center">
<i class="fa fa-coins fa-2x text-danger-400"></i>
</div>

<div class="media-body text-right">
<h3 class="font-weight-semibold mb-0">
<?php
$total_balances = $db->select('sum(balance) as total')->table('users')->where('balance','>=',35)->get();
echo m_currency($total_balances['data'][0]['total']);
?> <i class="fa fa-lira-sign"></i>
</h3>
<span class="text-uppercase font-size-sm text-muted">35.00+ BAKİYELER</span>
</div>
</div>
</div>
</div>

<div class="col-sm-3 col-xl-3">
<div class="card card-body">
<div class="media">
<div class="mr-3 align-self-center">
<i class="icon-user-plus icon-2x text-success-400"></i>
</div>

<div class="media-body text-right">
<h3 class="font-weight-semibold mb-0">
<?php
echo m_number_format($db->table('users')->where_set('DATE(register_date)','=','CURDATE()')->count());
?>
</h3>
<span class="text-uppercase font-size-sm text-muted">BUGÜN ÜYELER</span>
</div>
</div>
</div>
</div>


<div class="col-sm-3 col-xl-3">
<div class="card card-body">
<div class="media">
<div class="mr-3 align-self-center">
<i class="fa fa-sync-alt fa-spin fa-2x text-danger-400"></i>
</div>

<div class="media-body text-right">
<h3 class="font-weight-semibold mb-0">
<?php
$total_online = $db->table('users')->where_set('last_login','>=','NOW() - INTERVAL 15 MINUTE')->count();
echo m_number_format($total_online);
?>
</h3>
<span class="text-uppercase font-size-sm text-muted">ONLİNE ( ÜYE )</span>
</div>
</div>
</div>
</div>

<div class="col-sm-4 col-lg-4">
<div class="card card-body">
<div class="media">
<div class="mr-3 align-self-center">
<i class="icon-headset icon-2x text-warning-400"></i>
</div>

<div class="media-body text-right">
<h3 class="font-weight-semibold mb-0">
<?php
echo m_number_format($db->table('support')->where('status','=','0')->count());
?>
</h3>
<span class="text-uppercase font-size-sm text-muted">YANIT BEKLEYEN TALEPLER</span>
</div>
</div>
</div>
</div>

<div class="col-sm-4 col-lg-4">
<div class="card card-body">
<div class="media">
<div class="mr-3 align-self-center">
<i class="icon-headset icon-2x text-success-400"></i>
</div>

<div class="media-body text-right">
<h3 class="font-weight-semibold mb-0">
<?php
echo m_number_format($db->table('support')->where('status','=','1')->count());
?>
</h3>
<span class="text-uppercase font-size-sm text-muted">YANITLANAN TALEPLER</span>
</div>
</div>
</div>
</div>

<div class="col-sm-4 col-lg-4">
<div class="card card-body">
<div class="media">
<div class="mr-3 align-self-center">
<i class="icon-headset icon-2x text-danger-400"></i>
</div>

<div class="media-body text-right">
<h3 class="font-weight-semibold mb-0">
<?php
echo m_number_format($db->table('support')->where('status','=','2')->count());
?>
</h3>
<span class="text-uppercase font-size-sm text-muted">KAPANMIŞ TALEPLER</span>
</div>
</div>
</div>
</div>


<div class="col-sm-4 col-lg-4">
<div class="card card-body">
<div class="media">
<div class="mr-3 align-self-center">
<i class="fa fa-download fa-2x text-warning-400"></i>
</div>

<div class="media-body text-right">
<h3 class="font-weight-semibold mb-0">
<?php
$total_withdrawals = $db->select('sum(amount) as total')->table('withdrawals')->where('status','=',0)->get();
echo m_currency($total_withdrawals['data'][0]['total']);
?> <i class="fa fa-lira-sign"></i>
</h3>
<span class="text-uppercase font-size-sm text-muted">BEKLEYEN PARA ÇEKİMLERİ</span>
</div>
</div>
</div>
</div>

<div class="col-sm-4 col-lg-4">
<div class="card card-body">
<div class="media">
<div class="mr-3 align-self-center">
<i class="fa fa-download fa-2x text-success-400"></i>
</div>

<div class="media-body text-right">
<h3 class="font-weight-semibold mb-0">
<?php
$total_withdrawals = $db->select('sum(amount) as total')->table('withdrawals')->where('status','=',1)->get();
echo m_currency($total_withdrawals['data'][0]['total']);
?> <i class="fa fa-lira-sign"></i>
</h3>
<span class="text-uppercase font-size-sm text-muted">TAMAMLANMIŞ PARA ÇEKİMLERİ</span>
</div>
</div>
</div>
</div>

<div class="col-sm-4 col-lg-4">
<div class="card card-body">
<div class="media">
<div class="mr-3 align-self-center">
<i class="fa fa-download fa-2x text-info-400"></i>
</div>

<div class="media-body text-right">
<h3 class="font-weight-semibold mb-0">
<?php
$total_withdrawals = $db->select('sum(amount) as total')->table('withdrawals')->where_set('MONTH(date)','=','MONTH(CURRENT_DATE())')->where_set('YEAR(date)','=','YEAR(CURRENT_DATE())')->where('status','=',1)->get();
echo m_currency($total_withdrawals['data'][0]['total']);
?> <i class="fa fa-lira-sign"></i>
</h3>
<span class="text-uppercase font-size-sm text-muted">BU AY TAMAMLANMIŞ PARA ÇEKİMLERİ</span>
</div>
</div>
</div>
</div>



</div>

<div class="balances">

	<div class="card"><div class="card-header"><h5 class="font-weight-bold card-title">BUGÜN - Toplam İşlem - En İyi Kullanıcı - En Fazla İşlem Tipi - Dağılım</h5></div></div>
	<div class="row">
	
	<div class="col-sm-3 col-xl-3">
	<div class="card card-body">
	<div class="media">
	<div class="mr-3 align-self-center">
	<i class="icon-cash4 icon-2x text-danger-400"></i>
	</div>

	<div class="media-body text-right">
	<div class="today_total mb-0"><i class="fa fa-spinner fa-spin"></i> Hesaplanıyor..</div>
	<span class="text-uppercase font-size-sm text-muted">T. İŞLEM</span>
	</div>
	</div>
	</div>
	</div>
	
	<div class="col-sm-3 col-xl-3">
	<div class="card card-body">
	<div class="media">
	<div class="mr-3 align-self-center">
	<i class="icon-user-check icon-2x text-primary-400"></i>
	</div>

	<div class="media-body text-right">
	<div class="today_best_user mb-0"><i class="fa fa-spinner fa-spin"></i> Hesaplanıyor..</div>
	<div class="today_best_user_total"></div>
	</div>
	</div>
	</div>
	</div>
	
	<div class="col-sm-6 col-xl-6">
	<div class="card card-body">
	<div class="media">
	<div class="mr-3 align-self-center">
	<i class="icon-info22 icon-2x text-warning-400"></i>
	</div>

	<div class="media-body text-right">
	<div class="today_best_type mb-0"><i class="fa fa-spinner fa-spin"></i> Hesaplanıyor..</div>
	<div class="today_best_type_total"></div>
	</div>
	</div>
	</div>
	</div>
	
	<div class="col-sm-6 col-xl-6">
	<div class="card card-body">
	<div class="media">
	<div class="mr-3 align-self-center">
	<i class="icon-pen-plus icon-2x text-success-400"></i>
	</div>

	<div class="media-body text-right">
	<div class="today_review_first_pay mb-0"><i class="fa fa-spinner fa-spin"></i> Hesaplanıyor..</div>
	<span class="text-uppercase font-size-sm text-muted">İNCELEME EKLEME KAZANCI</span>
	</div>
	</div>
	</div>
	</div>
	
	<div class="col-sm-6 col-xl-6">
	<div class="card card-body">
	<div class="media">
	<div class="mr-3 align-self-center">
	<i class="icon-eye-plus icon-2x text-primary-400"></i>
	</div>

	<div class="media-body text-right">
	<div class="today_review_pay mb-0"><i class="fa fa-spinner fa-spin"></i> Hesaplanıyor..</div>
	<span class="text-uppercase font-size-sm text-muted">İNCELEME GÖRÜNTÜLENME KAZANCI</span>
	</div>
	</div>
	</div>
	</div>
	
	<div class="col-sm-6 col-xl-6">
	<div class="card card-body">
	<div class="media">
	<div class="mr-3 align-self-center">
	<i class="icon-loop3 icon-2x text-warning-400"></i>
	</div>

	<div class="media-body text-right">
	<div class="today_time_pay mb-0"><i class="fa fa-spinner fa-spin"></i> Hesaplanıyor..</div>
	<span class="text-uppercase font-size-sm text-muted">SİTEDE KALMA KAZANCI</span>
	</div>
	</div>
	</div>
	</div>
	
	<div class="col-sm-6 col-xl-6">
	<div class="card card-body">
	<div class="media">
	<div class="mr-3 align-self-center">
	<i class="icon-user-plus icon-2x text-danger-400"></i>
	</div>

	<div class="media-body text-right">
	<div class="today_referer_withdraw_amount mb-0"><i class="fa fa-spinner fa-spin"></i> Hesaplanıyor..</div>
	<span class="text-uppercase font-size-sm text-muted">REFERANS PARA ÇEKİMİ</span>
	</div>
	</div>
	</div>
	</div>
	
	
	</div>
	

</div>



</div>