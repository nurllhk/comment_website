<?php
require_once('init.php');
define('SITE_INCLUDED', TRUE);
if(m_setting('maintenance')==1)
{
	include('bakim.html');
	exit;
}
switch(m_u_g('page'))
{
	case 'login':
		if(USER) { m_redirect(SITE_DOMAIN); }
		$meta_informations = m_meta('login',m_permalink('login'));
		require_once(SITE_THEME_DIR.'/login.php');
	break;
	case 'register':
		if(USER) { m_redirect(SITE_DOMAIN); }
		$meta_informations = m_meta('register',m_permalink('register'));
		require_once(SITE_THEME_DIR.'/register.php');

	break;
	case 'logout':
		m_delete_session('m_user');
		m_redirect(SITE_DOMAIN);
	break;
	case 'messages':
		if(!USER) { m_redirect(m_permalink('login')); }
		$meta_informations = m_meta('messages',m_permalink('messages'));
		require_once(SITE_THEME_DIR.'/messages.php');
	break;
	case 'messages_user':
		if(!USER) { m_redirect(m_permalink('login')); }
		$meta_informations = m_meta('messages_user',m_permalink('messages_user',m_u_g('id')));
		require_once(SITE_THEME_DIR.'/messages_user.php');
	break;
	case 'account_notifications':
		if(!USER) { m_redirect(m_permalink('login')); }
		$meta_informations = m_meta('account_notifications',m_permalink('account_notifications'));
		require_once(SITE_THEME_DIR.'/account_notifications.php');
	break;
	case 'account':
		if(!USER) { m_redirect(m_permalink('login')); }
		$meta_informations = m_meta('account',m_permalink('account'));
		require_once(SITE_THEME_DIR.'/account.php');
	break;
	case 'account_blocks':
		if(!USER) { m_redirect(m_permalink('login')); }
		$meta_informations = m_meta('account_blocks',m_permalink('account_page','engellenenler'));
		require_once(SITE_THEME_DIR.'/account_blocks.php');
	break;
	case 'account_followers':
		if(!USER) { m_redirect(m_permalink('login')); }
		$meta_informations = m_meta('account_followers',m_permalink('account_page','takipciler'));
		require_once(SITE_THEME_DIR.'/account_followers.php');
	break;
	case 'account_followeds':
		if(!USER) { m_redirect(m_permalink('login')); }
		$meta_informations = m_meta('account_followeds',m_permalink('account_page','takip-edilenler'));
		require_once(SITE_THEME_DIR.'/account_followeds.php');
	break;
	case 'account_blocks':
		if(!USER) { m_redirect(m_permalink('login')); }
		$meta_informations = m_meta('account_blocks',m_permalink('account_page','engellenenler'));
		require_once(SITE_THEME_DIR.'/account_blocks.php');
	break;
	case 'account_balance':
		if(!USER) { m_redirect(m_permalink('login')); }
		$meta_informations = m_meta('account_balance',m_permalink('account_page','bakiye'));
		require_once(SITE_THEME_DIR.'/account_balance.php');
	break;
	case 'account_comments':
		if(!USER) { m_redirect(m_permalink('login')); }
		$meta_informations = m_meta('account_comments',m_permalink('account_page','yorumlar'));
		require_once(SITE_THEME_DIR.'/account_comments.php');
	break;
	case 'account_reviews':
		if(!USER) { m_redirect(m_permalink('login')); }
		$meta_informations = m_meta('account_reviews',m_permalink('account_page','incelemeler'));
		require_once(SITE_THEME_DIR.'/account_reviews.php');
	break;
	case 'account_waiting_reviews':
		if(!USER) { m_redirect(m_permalink('login')); }
		$meta_informations = m_meta('account_waiting_reviews',m_permalink('account_page','bekleyen-duzenleme'));
		require_once(SITE_THEME_DIR.'/account_waiting_reviews.php');
	break;
	case 'support':
		if(!USER) { m_redirect(m_permalink('login')); }
		$meta_informations = m_meta('support',m_permalink('support'));
		require_once(SITE_THEME_DIR.'/support.php');
	break;
	case 'support_new':
		if(!USER) { m_redirect(m_permalink('login')); }
		$meta_informations = m_meta('support_new',m_permalink('support_new'));
		require_once(SITE_THEME_DIR.'/support_new.php');
	break;
	case 'support_detail':
		if(!USER) { m_redirect(m_permalink('login')); }
		$meta_informations = m_meta('support_detail',m_permalink('support_detail',m_u_g('id')));
		require_once(SITE_THEME_DIR.'/support_detail.php');
	break;
	case 'forgot_password':
		if(USER) { m_redirect(SITE_DOMAIN); }
		$meta_informations = m_meta('forgot_password',m_permalink('forgot_password'));
		require_once(SITE_THEME_DIR.'/forgot_password.php');
	break;
	case 'renew_password':
		if(USER or m_u_g('hash')=='') { m_redirect(SITE_DOMAIN); }
		$meta_informations = m_meta('renew_password',SITE_DOMAIN.'/sifre-yenileme/'.m_u_g('hash').'');
		require_once(SITE_THEME_DIR.'/renew_password.php');
	break;
	case 'add_product':
		if(!USER) { m_redirect(m_permalink('login')); }
		$meta_informations = m_meta('add_product',m_permalink('add_product'));
		require_once(SITE_THEME_DIR.'/add_product.php');
	break;
	case 'first_review_step':
		if(!USER) { m_redirect(m_permalink('login')); }
		$meta_informations = m_meta('first_review_step',m_permalink('first_review_step'));
		require_once(SITE_THEME_DIR.'/first_review_step.php');
	break;
	case 'add_review':
		if(!USER) { m_redirect(m_permalink('login')); }
		$meta_informations = m_meta('add_review',m_permalink('add_review'));
		require_once(SITE_THEME_DIR.'/add_review.php');
	break;
	case 'add_review_detail':
		if(!USER) { m_redirect(m_permalink('login')); }
		$meta_informations = m_meta('add_review',m_permalink('add_review_detail',m_u_g('id')));
		require_once(SITE_THEME_DIR.'/add_review_detail.php');
	break;
	case 'revise_review':
		if(!USER) { m_redirect(m_permalink('login')); }
		$meta_informations = m_meta('revise_review',m_permalink('revise_review',m_u_g('id')));
		require_once(SITE_THEME_DIR.'/revise_review.php');
	break;
	case 'profile':
		$user_detail = $db->table('users')->where('id','=',m_u_g('id'))->get_vars();
		$m_title = $user_detail['username'];
		$m_image = m_user_avatar($user_detail['gender'],$user_detail['avatar']);
		$meta_informations = m_meta('profile',m_permalink('user_profile',$user_detail['sef'],$user_detail['id']),$m_title,$m_image);
		require_once(SITE_THEME_DIR.'/profile.php');
	break;
	case 'profile_comments':
		$user_detail = $db->table('users')->where('id','=',m_u_g('id'))->get_vars();
		$m_title = $user_detail['username'];
		$m_image = m_user_avatar($user_detail['gender'],$user_detail['avatar']);
		$meta_informations = m_meta('profile_comments',m_permalink('user_profile_comments',$user_detail['sef'],$user_detail['id']),$m_title,$m_image);
		require_once(SITE_THEME_DIR.'/profile_comments.php');
	break;
	case 'category':
		$category_detail = $db->table('categories')->where('id','=',m_u_g('id'))->get_vars();
		if(m_u_g('order')=='')
		{
			$link = m_permalink('category',$category_detail['sef'],$category_detail['id']);
		}
		else
		{
			if(m_u_g('order')=='point')
			{
				$link = m_permalink('category',$category_detail['sef'],$category_detail['id']).'/sira/puan';
			}
			else
			{
				$link = m_permalink('category',$category_detail['sef'],$category_detail['id']);
			}
		}
		$m_title = $category_detail['title'];
		$meta_informations = m_meta('category',$link,$m_title);
		require_once(SITE_THEME_DIR.'/category.php');
	break;
	case 'category_liste':
		$category_detail = $db->table('categories')->where('id','=',m_u_g('id'))->get_vars();
		$m_title = $category_detail['title'];
		$meta_informations = m_meta('category_liste',m_permalink('category',$category_detail['sef'],$category_detail['id']).'/liste',$m_title);
		require_once(SITE_THEME_DIR.'/category_liste.php');
	break;
	case 'brand':
		$brand_detail = $db->table('brands')->where('id','=',m_u_g('id'))->get_vars();
		if(m_u_g('order')=='')
		{
			$link = m_permalink('brand',$brand_detail['sef'],$brand_detail['id']);
		}
		else
		{
			if(m_u_g('order')=='point')
			{
				$link = m_permalink('brand',$brand_detail['sef'],$brand_detail['id']).'/sira/puan';
			}
			else
			{
				$link = m_permalink('brand',$brand_detail['sef'],$brand_detail['id']);
			}
		}
		$m_title = $brand_detail['title'];
		$m_image = m_image_url($brand_detail['image']);
		$meta_informations = m_meta('brand',$link,$m_title,$m_image);
		require_once(SITE_THEME_DIR.'/brand.php');
	break;
	case 'brand_liste':
		$brand_detail = $db->table('brands')->where('id','=',m_u_g('id'))->get_vars();
		$m_title = $brand_detail['title'];
		$m_image = m_image_url($brand_detail['image']);
		$meta_informations = m_meta('brand_liste',m_permalink('brand',$brand_detail['sef'],$brand_detail['id']).'/liste',$m_title,$m_image);
		require_once(SITE_THEME_DIR.'/brand_liste.php');
	break;
	case 'reviews':
		if(m_u_g('type')=='positive')
		{
			$m_type = 'positive_reviews';
			$url = m_permalink('positive_reviews');
		}
		else
		{
			$m_type = 'negative_reviews';
			$url = m_permalink('negative_reviews');
		}
		$meta_informations = m_meta($m_type,$url);
		require_once(SITE_THEME_DIR.'/reviews.php');
	break;
	case 'product':
		$product_detail = $db->table('products')->where('id','=',m_u_g('id'))->get_vars();
		$m_title = $product_detail['title'];
		$m_image = m_image_url($product_detail['image']);
		$meta_informations = m_meta('product',m_permalink('product',$product_detail['sef'],$product_detail['id']),$m_title,$m_image);
		require_once(SITE_THEME_DIR.'/product.php');
	break;
	case 'review':
		$review_detail = $db->table('reviews')->where('id','=',m_u_g('id'))->get_vars();
		$review_title = str_replace('"',"'",mb_substr($review_detail['title'],0,60,'UTF-8'));
		$review_id = $review_detail['id'];
		$p_id = $review_detail['p_id'];
		$m_image = m_image_url($db->table('products')->where('id','=',$p_id)->get_var('image'));
		$review_description = trim(str_replace('"',"'",mb_substr(strip_tags($review_detail['content']),0,147,'UTF-8'))).'...';
		$m_title = $review_detail['title'];
		$meta_informations = m_meta('review',m_permalink('review',$review_detail['sef'],$review_detail['sef']),$m_title,$m_image);
		require_once(SITE_THEME_DIR.'/review.php');
	break;
	case 'brands':
		$meta_informations = m_meta('brands',m_permalink('brands'));
		require_once(SITE_THEME_DIR.'/brands.php');
	break;
	case 'tops':
		$meta_informations = m_meta('tops',m_permalink('tops'));
		require_once(SITE_THEME_DIR.'/tops.php');
	break;
	case 'how_to_work':
		$meta_informations = m_meta('how_to_work',m_permalink('how_to_work'));
		require_once(SITE_THEME_DIR.'/how_to_work.php');
	break;
	case 'rejected_types':
		$meta_informations = m_meta('rejected_types',m_permalink('rejected_types'));
		require_once(SITE_THEME_DIR.'/rejected_types.php');
	break;
	case 'page':
		$page_detail = $db->table('pages')->where('sef','=',m_u_g('sef'))->get_vars();
		$m_title = $page_detail['title'];
		$meta_informations = m_meta('page',m_permalink('page',$page_detail['sef']),$m_title);
		require_once(SITE_THEME_DIR.'/page.php');
	break;
	case 'contact':
		$meta_informations = m_meta('contact',m_permalink('contact'));
		require_once(SITE_THEME_DIR.'/contact.php');
	break;
	case 'search':
		$meta_informations = m_meta('search',m_permalink('search_q',m_u_g('q')));
		require_once(SITE_THEME_DIR.'/search.php');
	break;
	case '404':
		$meta_informations = m_meta('404',''.SITE_DOMAIN.'/404');
		require_once(SITE_THEME_DIR.'/404.php');
	break;
	default;
		$meta_informations = m_meta('home',SITE_DOMAIN);
		require_once(SITE_THEME_DIR.'/home.php');
}
?>