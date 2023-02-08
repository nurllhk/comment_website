<?php if(!defined('SITE_INCLUDED')) { exit; } ?>
<!DOCTYPE html>
<html lang="tr-TR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<meta name="application-name" content="Açıklıyorum"/>
<meta name="apple-mobile-web-app-status-bar-style" content="#ffffff"/>
<meta name="apple-mobile-web-app-title" content="Açıklıyorum"/>
<meta name="theme-color" content="#ffffff"/>





<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2118676619714927"
     crossorigin="anonymous"></script>

<?php
if(m_u_g('page')=='review')
{
?>
<title><?php echo $review_title; ?></title>
<meta name="description" content="<?php echo $review_description; ?>" />
<?php
}
else
{
?>
<title><?php echo $meta_informations['title']; ?></title>
<meta name="description" content="<?php echo $meta_informations['description']; ?>" />
<?php
}
?>
<meta name="keywords" content="<?php echo $meta_informations['keywords']; ?>" />
<meta name="csrf-token" content="<?php echo $_SESSION['csrf_token']; ?>" />
<?php
if(m_u_g('page')=='review')
{
?>
<meta name="review-id" content="<?php echo $review_id; ?>" />
<?php
}
?>
<meta property="og:url" content="<?php echo $meta_informations['canoncial']; ?>" />
<meta property="og:title" content="<?php echo $meta_informations['title']; ?>" />
<meta property="og:description" content="<?php echo $meta_informations['description']; ?>" />
<meta property="og:site_name" content="<?php echo $meta_informations['site_name']; ?>" />
<meta property="og:locale" content="tr_TR" />
<meta property="og:type" content="website" />
<?php
if($meta_informations['image']!="")
{
?>
<meta property="og:image" content="<?php echo $meta_informations['image']; ?>" />
<?php
}
?>
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="<?php echo $meta_informations['title']; ?>" />
<meta name="twitter:description" content="<?php echo $meta_informations['description']; ?>" />
<meta name="twitter:url" content="<?php echo $meta_informations['canoncial']; ?>" />
<?php
if($meta_informations['image']!="")
{
?>
<meta name="twitter:image" content="<?php echo $meta_informations['image']; ?>" />
<?php
}
?>
<link rel="icon" href="<?php echo SITE_THEME_URL; ?>/assets/img/favicon.png" type="image/png" />
<link rel="canonical" href="<?php echo $meta_informations['canoncial']; ?>" />

<link rel="preconnect" href="https://fonts.gstatic.com">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Mulish:wght@200;300;400;500;600;700;800;900&display=swap">
<link rel="stylesheet" href="<?php echo SITE_THEME_URL; ?>/assets/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo SITE_THEME_URL; ?>/assets/fontawesome/css/all.min.css">
<?php
if(strstr(m_u_g('page'),'account') or strstr(m_u_g('page'),'support'))
{
?>

<link rel="stylesheet" href="<?php echo SITE_THEME_URL; ?>/assets/custom/datatable/dataTables.bootstrap5.min.css" />
<link rel="stylesheet" href="<?php echo SITE_THEME_URL; ?>/assets/custom/datatable/responsive.bootstrap5.min.css" />

<?php
}
?>
<link rel="preload" href="<?php echo SITE_THEME_URL; ?>/assets/custom/sweetalert2/sweetalert2.min.css" as="style" onload="this.rel='stylesheet'"/>
<link rel="preload" href="<?php echo SITE_THEME_URL; ?>/assets/custom/select2/select2.min.css" as="style" onload="this.rel='stylesheet'"/>
<link rel="preload" href="<?php echo SITE_THEME_URL; ?>/assets/custom/select2/select2-bootstrap-5-theme.css" as="style" onload="this.rel='stylesheet'"/>

<link rel="preload" href="<?php echo SITE_THEME_URL; ?>/assets/custom/fancybox/jquery.fancybox.min.css" as="style" onload="this.rel='stylesheet'"/>
<link rel="stylesheet" href="<?php echo SITE_THEME_URL; ?>/assets/custom/custom.min.css?v=<?php echo PROJECT_VERSION; ?>">

<?php
if(m_u_g('page')=='add_review_detail' or m_u_g('page')=='revise_review' or m_u_g('page')=='first_review_step')
{
?>

<link rel="stylesheet" href="<?php echo SITE_THEME_URL; ?>/assets/custom/review_add.min.css?v=<?php echo PROJECT_VERSION; ?>">

<?php
}
?>

<?php echo m_setting('head_codes'); ?>

<?php

$no_auto_ads = array(
'add_product',
'first_review_step',
'add_review',
'revise_review',
'tops',
'register',
'forgot_password',
'login',
'messages',
'messages_user'
);

if(!in_array(m_u_g('page'),$no_auto_ads) and !strstr(m_u_g('page'),'account'))
{

echo m_setting('auto_ads_code');

}
?>

</head>
<body>
		<div class="header">
		    <nav class="navbar navbar-expand header_nav">
			  <div class="container header_menu">
				<a class="d-none d-sm-block navbar-brand" href="<?php echo m_permalink('home'); ?>" title="Açıklıyorum"><img width="152" height="38" src="<?php echo UPLOAD_URL; ?>/1x1.gif" class="lazyload" data-src="<?php echo m_setting('logo'); ?>" alt="Açıklıyorum"></a>
				<a class="d-block d-sm-none navbar-brand" href="<?php echo m_permalink('home'); ?>" title="Açıklıyorum"><img width="50" height="50" src="<?php echo UPLOAD_URL; ?>/1x1.gif" class="lazyload" data-src="<?php echo m_setting('logo_mobile'); ?>" alt="Açıklıyorum"></a>
				<form class="d-none d-sm-block d-flex header_search search desktop_search" action="<?php echo m_permalink('search'); ?>" autocomplete="off">
					<input class="form-control search_input desktop_search_input" type="search" name="q" placeholder="Hangi ürün/hizmeti incelemek istersin ?" aria-label="Ara">		
					<div class="search__result">
						<div class="search__result-cover">
						  <ul>
						  </ul>
						</div>
					</div>
				</form>
				<ul class="navbar-nav mb-2 mb-lg-0">
					<li class="nav-item d-none d-sm-block">
					<a class="nav-link" href="<?php echo m_permalink('home'); ?>"><i class="fa fa-home"></i></a>
					</li>
					<li class="nav-item d-block d-sm-none">
					<a class="nav-link mobile_search_open" href="#mobile_search" data-bs-toggle="collapse" aria-expanded="false"><i class="fa fa-search"></i></a>
					</li>
					<?php
					$sm_block = 'd-none d-sm-block';
					if(!USER)
					{
						$sm_block = '';
					}
					?>
						
					<?php
					if(USER)
					{
					?>
					<li class="nav-item <?php echo $sm_block; ?>">
					<a class="nav-link" href="<?php echo m_permalink('add_review'); ?>"><i class="fa fa-pen-square"></i></a>
					</li>
					<?php
					}
					?>
					<li class="nav-item <?php echo $sm_block; ?>">
					<a class="nav-link" href="<?php echo m_permalink('how_to_work'); ?>"><i class="fa fa-question-circle"></i></a>
					</li>
					<li class="nav-item <?php echo $sm_block; ?>">
					<a class="nav-link" href="<?php echo m_permalink('rejected_types'); ?>"><i class="fa fa-exclamation-triangle"></i></a>
					</li>
					<li class="nav-item <?php echo $sm_block; ?>">
					<a class="nav-link" href="<?php echo m_permalink('contact'); ?>"><i class="fa fa-phone-square-alt"></i></a>
					</li>
					<?php
					if(USER)
					{
					?>
					<li class="nav-item account_messages_nav">
					<a href="<?php echo m_permalink('messages'); ?>"><i class="fa fa-comment-dots account_messages_nav_icon"></i></a>
					</li>
					<li class="nav-item account_notifications_nav">
					<a href="<?php echo m_permalink('account_notifications'); ?>"><i class="fa fa-bell account_notification_nav_icon"></i></a>
					</li>
					<li class="nav-item nav_user_balance">
					<i class="fa fa-coins"></i> <span class="user_balance"><?php echo m_currency(USER['balance']); ?></span> <i class="fa fa-lira-sign"></i>
					</li>
					<li class="nav-user">
					<a class="user_menu" data-bs-toggle="offcanvas" data-bs-target="#offcanvas" role="button"><img class="lazyload" width="40" height="4" data-src="<?php echo m_user_avatar(USER['gender'],USER['avatar'],true); ?>"></a>
					</li>
					<?php
					}
					else
					{
					?>
					<li class="nav-item">
					<a class="nav-link" href="<?php echo m_permalink('login'); ?>"><i class="fa fa-sign-in-alt"></i></a>
					</li>
					<?php
					}
					?>
				</ul>
			  </div>
			</nav>
			<?php
			if(USER)
			{
			?>
			<div class="offcanvas offcanvas-end user_menu_content" tabindex="-1" id="offcanvas" data-bs-keyboard="false" data-bs-backdrop="true">
				<div class="offcanvas-header align-items-end justify-content-end">
					<span class="user_menu_content_close" data-bs-dismiss="offcanvas" aria-label="Close"><i class="fa fa-times-circle"></i></span>
				</div>
				<div class="offcanvas-body justify-content-center">
					<div class="user">
							<div class="user_image">
							<a href="<?php echo m_permalink('user_profile',USER['sef'],USER['id']); ?>"><img src="<?php echo m_user_avatar(USER['gender'],USER['avatar'],true); ?>"></a>
							<div class="user_status <?php echo m_user_status(USER['last_login']); ?>"></div>
							</div>
							<div class="user_name">
							<a href="<?php echo m_permalink('user_profile',USER['sef'],USER['id']); ?>"><?php echo USER['username']; ?></a>
							</div>
					</div>
					<div class="user_balance_detail">
						<div class="user_balance_icon"><span class="user_balance_icon_head bg-brand"><i class="fa fa-wallet"></i></span></div>
						<div class="user_balance_amount"><span class="user_balance"><?php echo m_currency(USER['balance']); ?></span> <i class="fa fa-lira-sign"></i></div>
					</div>
					<div class="user_rank_detail">
						<?php
						$user_level = m_user_level(USER['user_level']); 
						?>
						<div class="user_rank_icon"><?php echo $user_level['icon']; ?></div>
						<div class="user_rank_informations">
						<div class="progress mb-1">
						  <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="<?php echo $user_level['percent']; ?>"
						  aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $user_level['percent']; ?>%">
							<span><?php echo $user_level['difficulty']; ?></span>
						  </div>
						</div>
						<div class="user_rank_title fw-bold" style="font-size:11px;"><?php echo $user_level['title']; ?></div>
						</div>
					</div>
					<div class="list-group">
					  <a href="<?php echo m_permalink('add_review'); ?>" class="list-group-item"><i class="fa fa-pen-square"></i> İnceleme Ekle</a>
					  <a href="<?php echo m_permalink('account_page','incelemeler'); ?>" class="list-group-item"><i class="fa fa-newspaper"></i> İncelemelerim</a>
					  <a href="<?php echo m_permalink('account_page','yorumlar'); ?>" class="list-group-item"><i class="fa fa-comments"></i> Yorumlarım</a>
					  <a href="<?php echo m_permalink('account_page','bakiye'); ?>" class="list-group-item"><i class="fa fa-wallet"></i> Bakiyem</a>
					  <a href="<?php echo m_permalink('account_page','takipciler'); ?>" class="list-group-item"><i class="fa fa-user-plus"></i> Takipçiler</a>
					  <a href="<?php echo m_permalink('account_page','takip-edilenler'); ?>" class="list-group-item"><i class="fa fa-user-friends"></i> Takip Edilenler</a>
					  <a href="<?php echo m_permalink('account_page','engellenenler'); ?>" class="list-group-item"><i class="fa fa-user-slash"></i> Engellenenler</a>
					  <a href="<?php echo m_permalink('messages'); ?>" class="list-group-item"><i class="fa fa-comment-dots"></i> Mesajlar</a>
					   <a href="https://www.acikliyorum.com/iletisim" class="list-group-item"><i class="fa fa-pen-square"></i> İletişim</a>
					  
					  <a href="<?php echo m_permalink('account','hesabim'); ?>" class="list-group-item"><i class="fa fa-cog"></i> Ayarlar</a>
					  <a href="<?php echo m_permalink('user_profile',USER['sef'],USER['id']); ?>" class="list-group-item"><i class="fa fa-user"></i> Profilim</a>
					  <a href="<?php echo m_permalink('logout'); ?>" class="list-group-item"><i class="fa fa-sign-out-alt"></i> Çıkış</a>
					</div>
				</div>
			</div>
			<?php
			}
			?>
		</div>
		<div class="collapse" id="mobile_search">
		<div class="d-block d-sm-none search_type">
			  <form class="header_search mobile_search" action="<?php echo m_permalink('search'); ?>" autocomplete="off">
					<input class="form-control search_input mobile_search_input" type="search" name="q" placeholder="Hangi ürün/hizmeti incelemek istersin ?" aria-label="Ara">
					<div class="search__result">
						<div class="search__result-cover">
						  <ul>
						  </ul>
						</div>
					</div>
			  </form>
		</div>
		</div>