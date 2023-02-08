<?php

include('../init.php');

if(!m_admin_MADMIN_URL

{

	m_redirect(MADMIN_URL.'/login.php');

}

define('ADMIN_INCLUDED', TRUE);

?>



<!DOCTYPE html>

<html lang="en">

<head>

  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>MARKA RESİM DEĞİŞTİRİCİ</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

</head>

<body class="bg-light">

  <br>

  <div class="container">

 

  

  <?php

  if(m_u_g('page_no'))

  {

  $informations = $db->table('brands')->where_set('(image','=',"''")->where_set('image','IS','NULL)','OR')->pagination(5000)->order('id','asc')->get();

  foreach($informations['data'] as $info)

  {	  

	  echo '

	  <div class="card marka_'.$info['id'].' mb-2">

	  <div class="card-header bg-dark text-white">'.$info['title'].'</div>

	  <div class="card-body">

			<div class="result alert alert-danger" style="display:none;"></div>

			<form class="marka_degistir" rel="'.$info['id'].'" autocomplete="off">

			<input type="hidden" name="id" value="'.$info['id'].'">

			<input type="hidden" name="title" value="'.$info['title'].'">

			<input class="form-control" name="link" placeholder="YENİ MARKA RESİM LİNK" required type="text">

			<br>

			<a href="https://www.google.com/search?q='.urlencode("".$info['title']." logo").'&source=lnms&tbm=isch&tbs=isz:m" target="_blank" class="btn btn-block btn-light"><i class="fab fa-google"></i> GOOGLE ARA</a>

			<button id="submit" type="submit" class="btn btn-light btn-block"><i class="fa fa-check-circle"></i> DEĞİŞTİR</button>

			</form>

	  

	  </div>

	  </div>

	   

	  ';

  }

  }

  else

  {

	$informations = $db->table('brands')->where_set('(image','=',"''")->where_set('image','IS','NULL)','OR')->pagination(5000)->order('id','asc')->get();

	echo '<strong>TOPLAM '.m_number_format($informations['total_count']).' resimsiz marka bulunuyor, her sayfada 5000 adet olacak şekilde sayfalara bölündü. Karışıklık olmaması için herkes bir sayfayı düzenlemeli.</strong><br><br>';

	

	for ($x = 1; $x <= $informations['total_page']; $x++)

	{

	 

	 echo '<a href="no_image_brands.php?page_no='.$x.'" target="_blank" class="btn btn-block btn-dark">'.$x.'. Sayfa İçin Tıklayın</a> <br>';

	 

	}

	

  }

  ?>

  

  

  

  

  

  

  

  

  </div> 

  

  

  

  </div>



</body>

</html>

<script>



$(document).on('submit', ".marka_degistir", function (e) {

	e.preventDefault();

	var id =  $(this).attr('rel');

	var data = $(this).serialize();

	$.ajax({

					type: 'POST',

					url: 'degistir.php',

					data: data,

					dataType: 'json',

					success: function(data) {

						if(data.status)

						{

							$(".marka_"+id+"").hide();

						}

						else

						{

							

							$(".marka_"+id+"").find('.result').html('RESİM HATALI!');

							$(".marka_"+id+"").find('.result').show();

						}

						

					}

	})

	



});</script>