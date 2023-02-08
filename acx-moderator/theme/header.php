<?php if(!defined('ADMIN_INCLUDED')) { exit; } ?>
<!DOCTYPE html>
<html lang="tr-TR">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
	<meta charset="utf-8">
	<meta name="robots" content="noindex">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title><?php echo PROJECT; ?> - Yetkili Paneli</title>

	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="<?php echo ADMIN_THEME_URL; ?>/global_assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="<?php echo ADMIN_THEME_URL; ?>/global_assets/css/icons/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo ADMIN_THEME_URL; ?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo ADMIN_THEME_URL; ?>/assets/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo ADMIN_THEME_URL; ?>/assets/css/layout.min.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo ADMIN_THEME_URL; ?>/assets/css/components.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo ADMIN_THEME_URL; ?>/assets/css/colors.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo ADMIN_THEME_URL; ?>/assets/css/custom.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo ADMIN_THEME_URL; ?>/plugins/summernote/summernote-bs4.min.css" rel="stylesheet" type="text/css">
	<script src="<?php echo ADMIN_THEME_URL; ?>/global_assets/js/main/jquery.min.js"></script>
	<script src="<?php echo ADMIN_THEME_URL; ?>/global_assets/js/main/bootstrap.bundle.min.js"></script>
	<script src="<?php echo ADMIN_THEME_URL; ?>/global_assets/js/plugins/loaders/blockui.min.js"></script>
	<script src="<?php echo ADMIN_THEME_URL; ?>/global_assets/js/plugins/tables/datatables/datatables.min.js?v=<?php echo time(); ?>"></script>
	<script src="<?php echo ADMIN_THEME_URL; ?>/global_assets/js/plugins/tables/datatables/extensions/jszip/jszip.min.js"></script>
	<script src="<?php echo ADMIN_THEME_URL; ?>/global_assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>
	<script src="<?php echo ADMIN_THEME_URL; ?>/global_assets/js/plugins/tables/datatables/extensions/buttons.print.min.js"></script>
	<script src="<?php echo ADMIN_THEME_URL; ?>/assets/js/buttons.html5.min.js"></script>
	<script src="<?php echo ADMIN_THEME_URL; ?>/global_assets/js/plugins/forms/selects/select2.min.js"></script>
	<script src="<?php echo ADMIN_THEME_URL; ?>/global_assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script src="<?php echo ADMIN_THEME_URL; ?>/global_assets/js/plugins/notifications/sweet_alert.min.js"></script>
	<script src="<?php echo ADMIN_THEME_URL; ?>/global_assets/js/plugins/ui/moment/moment.min.js"></script>
	<script src="<?php echo ADMIN_THEME_URL; ?>/global_assets/js/plugins/pickers/daterangepicker.js"></script>
	<script src="<?php echo ADMIN_THEME_URL; ?>/global_assets/js/plugins/pickers/anytime.min.js"></script>
	<script src="<?php echo ADMIN_THEME_URL; ?>/global_assets/js/plugins/pickers/pickadate/picker.js"></script>
	<script src="<?php echo ADMIN_THEME_URL; ?>/global_assets/js/plugins/pickers/pickadate/picker.date.js"></script>
	<script src="<?php echo ADMIN_THEME_URL; ?>/global_assets/js/plugins/pickers/pickadate/picker.time.js"></script>
	<script src="<?php echo ADMIN_THEME_URL; ?>/global_assets/js/plugins/pickers/pickadate/legacy.js"></script>
	<script src="<?php echo ADMIN_THEME_URL; ?>/global_assets/js/plugins/forms/inputs/duallistbox/duallistbox.min.js?v=2"></script>
	<script src="<?php echo ADMIN_THEME_URL; ?>/global_assets/js/plugins/media/fancybox.min.js"></script>
	<script src="<?php echo ADMIN_THEME_URL; ?>/global_assets/js/plugins/notifications/pnotify.min.js"></script>
	<script src="<?php echo ADMIN_THEME_URL; ?>/plugins/jQuery.print.js"></script>
	<script src="<?php echo ADMIN_THEME_URL; ?>/plugins/summernote/summernote-bs4.min.js"></script>
	<script src="<?php echo ADMIN_THEME_URL; ?>/plugins/summernote/lang/summernote-tr-TR.min.js"></script>
	<script src="<?php echo ADMIN_THEME_URL; ?>/plugins/summernote/summernote-cleaner.js"></script>
	<script src="<?php echo ADMIN_THEME_URL; ?>/plugins/d3v5.min.js"></script>
	<script src="<?php echo ADMIN_THEME_URL; ?>/plugins/c3.min.js"></script>

	

	
	<script src="<?php echo ADMIN_THEME_URL; ?>/assets/js/app.js"></script>
	<script src="<?php echo ADMIN_THEME_URL; ?>/assets/js/custom.js?v=<?php echo time(); ?>"></script>
	
</head>

<body>
	<div class="navbar navbar-expand-md navbar-dark">
		<div class="navbar-brand">
			<a href="<?php echo MODERATOR_URL; ?>">
			<img src="<?php echo m_setting('logo'); ?>" style="height:3rem">
			</a>
		</div>

		<div class="d-md-none">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
				<i class="icon-tree5"></i>
			</button>
			<button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
				<i class="icon-paragraph-justify3"></i>
			</button>
		</div>

		<div class="collapse navbar-collapse" id="navbar-mobile">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
						<i class="icon-paragraph-justify3"></i>
					</a>
				</li>

			</ul>

			<span class="badge bg-success ml-md-3 mr-md-auto date_time"><?php echo date('d.m.Y H:i:s'); ?></span>  
			<ul class="navbar-nav">
				<li class="nav-item dropdown dropdown-user">
					<a href="#" class="navbar-nav-link d-flex align-items-center dropdown-toggle" data-toggle="dropdown">
						<img src="<?php echo ADMIN_THEME_URL; ?>/profil.png" class="rounded-circle mr-2" height="34" alt="">
						<span><?php echo m_moderator('name'); ?> <?php echo m_moderator('lastname'); ?></span>
					</a>

					<div class="dropdown-menu dropdown-menu-right">
						<a href="<?php echo MODERATOR_URL; ?>/index.php?page=account" class="dropdown-item"><i class="icon-cog3"></i> Hesap Bilgilerim</a>
						<a href="<?php echo MODERATOR_URL;?>/logout.php" class="dropdown-item"><i class="icon-switch2"></i> Çıkış</a>
					</div>
				</li>
			</ul>
		</div>
	</div>
	<div class="page-content">
	
		<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">
			<div class="sidebar-mobile-toggler text-center">
				<a href="#" class="sidebar-mobile-main-toggle">
					<i class="icon-arrow-left8"></i>
				</a>
				Menü
				<a href="#" class="sidebar-mobile-expand">
					<i class="icon-screen-full"></i>
					<i class="icon-screen-normal"></i>
				</a>
			</div>
			<div class="sidebar-content">

				<div class="sidebar-user">
					<div class="card-body">
						<div class="media">
							<div class="mr-3">
								<a href="#"><img src="<?php echo ADMIN_THEME_URL; ?>/profil.png" width="38" height="38" class="rounded-circle" alt=""></a>
							</div>

							<div class="media-body">
								<div class="media-title font-weight-semibold"><?php echo m_moderator('name'); ?> <?php echo m_moderator('lastname'); ?></div>
								<div class="font-size-xs opacity-50">
									<i class="fa fa-info-circle"></i> &nbsp;Moderatör
								</div>
							</div>

							<div class="ml-3 align-self-center">
								<a href="<?php echo MODERATOR_URL; ?>/index.php?page=account" class="text-white"><i class="icon-cog3"></i></a>
							</div>
						</div>
					</div>
				</div>
				<div class="card card-sidebar-mobile">
					<ul class="nav nav-sidebar sidebar_informations" data-nav-type="accordion">
						
						<?php
						
						$waiting_support = m_number_format($db->table('support')->where('to_admin','=','0')->where('status','=','0')->count());
						$waiting_support_count ='';
						if($waiting_support>0)
						{
							$waiting_support_count = $waiting_support;
						}
						
						?>
						
						<li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Menü</div> <i class="icon-menu" title="Main"></i></li>
						<li class="nav-item nav-item-submenu <?php if(m_a_g('page')=='') { echo 'nav-item-expanded nav-item-open'; } ?>">
							<a href="<?php echo MODERATOR_URL; ?>" class="nav-link"><i class="icon-home4"></i> <span>Anasayfa</span></a>
						</li>
						<li class="nav-item nav-item-submenu <?php if(strstr(m_a_g('page'),'review') and !strstr(m_a_g('page'),'review_statistics')) { echo 'nav-item-expanded nav-item-open'; } ?>">
							<a href="<?php echo MODERATOR_URL; ?>/index.php?page=reviews" class="nav-link"><i class="icon-pencil7"></i> <span>İncelemeler</span> <span class="badge badge-warning align-self-center ml-auto"><?php echo m_number_format($db->table('reviews')->where('plagiarism','=',1)->where('status','=','0')->count()); ?></span></a>
						
						</li>
						<li class="nav-item nav-item-submenu <?php if(strstr(m_a_g('page'),'comments')) { echo 'nav-item-expanded nav-item-open'; } ?>">
							<a href="<?php echo MODERATOR_URL; ?>/index.php?page=comments" class="nav-link"><i class="icon-comment-discussion"></i> <span>Yorumlar</span> <span class="badge badge-warning align-self-center ml-auto"><?php echo m_number_format($db->table('comments')->where('status','=','0')->count()); ?></span></a>
						</li>
						
						<li class="nav-item nav-item-submenu <?php if(strstr(m_a_g('page'),'product') or strstr(m_a_g('page'),'brand') or strstr(m_a_g('page'),'cate')) { echo 'nav-item-expanded nav-item-open'; } ?>">
							<a href="#" class="nav-link"><i class="icon-cart2"></i> <span>Mağaza</span></a>
							<ul class="nav nav-group-sub" data-submenu-title="Mağaza">
							<li class="nav-item"><a href="<?php echo MODERATOR_URL; ?>/index.php?page=products" class="nav-link"><i class="icon-basket"></i> <span>Ürünler</span></a></li>
							</ul>
						</li>
						
					
					
					
						
						
						
						<li class="nav-item nav-item-submenu <?php if(strstr(m_a_g('page'),'add_comment')) { echo 'nav-item-expanded nav-item-open'; } ?>">
							<a href="<?php echo MODERATOR_URL; ?>/index.php?page=add_comment" class="nav-link"><i class="icon-comment"></i> <span>Yorumla</span></a>
						</li>
						

					</ul>
				</div>

			</div>
			
		</div>

<div class="content-wrapper">