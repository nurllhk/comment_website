<?php

// NORMAL SETTINGS

define('PROJECT','ACIKLIYORUM V11');
define('PROJECT_VERSION','300520220840');

define('DB_DATABASE','mysql');
define('DB_HOST','localhost');
define('DB_USERNAME','acikliyo_root');
define('DB_PASSWORD','8pCKJJ.5mOna!');
define('DB_NAME','acikliyo_databaxx');
define('DB_PREFIX','');
define('DB_PAGINATION_GET','page_no');

define('SITE_DOMAIN','https://www.acikliyorum.com');
define('SITE_THEME','default');

define('ADMIN_URL',SITE_DOMAIN.'/acx-admin');
define('MADMIN_URL',SITE_DOMAIN.'/acx-moderator-control');
define('MODERATOR_URL',SITE_DOMAIN.'/acx-moderator');
define('ADMIN_THEME_URL',ADMIN_URL.'/theme');
define('MODERATOR_THEME_URL',ADMIN_URL.'/theme');



// OTHER SETTINGS


define('UPLOAD_DIR_NAME','uploads');
define('UPLOAD_THUMB_DIR_NAME',UPLOAD_DIR_NAME.'/images/thumb');
define('UPLOAD_TMP_THUMB_DIR_NAME',UPLOAD_DIR_NAME.'/tmp/images/thumb');


define('UPLOAD_URL',SITE_DOMAIN.'/'.UPLOAD_DIR_NAME);
define('UPLOAD_DIR',dirname(__FILE__).'/'.UPLOAD_DIR_NAME);
define('TMP_UPLOAD_DIR',dirname(__FILE__).'/'.UPLOAD_DIR_NAME.'/tmp');
define('UPLOAD_THUMB_DIR',dirname(__FILE__).'/'.UPLOAD_THUMB_DIR_NAME);
define('UPLOAD_TMP_THUMB_DIR',dirname(__FILE__).'/'.UPLOAD_TMP_THUMB_DIR_NAME);




define('DEMO',false);
define('DEBUG',false);
define('DATABASE',true);
?>