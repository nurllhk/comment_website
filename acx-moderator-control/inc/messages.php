<?php if(!defined('ADMIN_INCLUDED')) { exit; } ?>

<style>

.chat_message_list

{

	width:100%;

	height:80vh;

	overflow-y:auto;

	background:#ffffff;

	padding:20px;

}

.chat_message_list .user

{

	width:140px;

	padding:10px;

	border:1px solid rgba(0,0,0,.125);

	border-radius:4px;

}

.chat_message_list .user .avatar

{

	width:100%;

	display:flex;

	align-items:center;

	justify-content:center;
MADMIN_URL
}

.chat_message_list .user .avatar img

{

	display:block;

	width:50px;

	height:50px;

	border-radius:50%;

}

.chat_message_list .username

{

	margin-top:10px;

	font-weight:bold;

}

  

</style>

<div class="content">

<div class="navbar navbar-dark navbar-expand-md navbar-component">

<div class="d-md-none">

</div>

<div class="collapse navbar-collapse" id="navbar-component">

	<ul class="navbar-nav">

		<li class="nav-item">

			<a href="<?php echo MADMIN_URL;?>/index.php" class="navbar-nav-link">Anasayfa</a>

		</li>

		<li class="nav-item">

			<a href="#" class="navbar-nav-link"><i class="fa fa-share"></i></a>

		</li>

		<li class="nav-item">

			<a href="#" class="navbar-nav-link">Sohbet</a>

		</li>

	</ul>



</div>

</div>





<div class="row mb-2">



	<div class="col-lg-2 col col-4"><div class="btn btn-light btn-block">GÖNDERİCİ</div></div>

	<div class="col-lg-8 col-4"><div class="btn btn-light btn-block"><i class="fa fa-spinner fa-spin"></i> MESAJ</div></div>

	<div class="col-lg-2 col-4"><div class="btn btn-light btn-block">ALICI</div></div>



</div>





<div class="chat_message_list">



</div>









</div>

