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
<a href="<?php echo ADMIN_URL; ?>/index.php?page=reviews&status=0" style="color:black;">
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
<a href="<?php echo ADMIN_URL; ?>/index.php?page=reviews&status=3" style="color:black;">
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




<div class="col-sm-6 col-xl-6">
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


<div class="col-sm-6 col-xl-6">
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




</div>





</div>