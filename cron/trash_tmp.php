<?php
include('../init.php');
exit;
$files = glob(TMP_UPLOAD_DIR.'/images/*.{jpg,png,jpeg,webp,bmp}', GLOB_BRACE);
foreach($files as $file)
{
	
		if ((time()-filectime($file)) > 172800) {  // 86400 = 60*60*24*2
          
            unlink($file);
            unlink(UPLOAD_TMP_THUMB_DIR.'/'.basename($file));
          
        }
}