<?php if(!defined('ADMIN_INCLUDED')) { exit; } ?>

<div class="content">



<div class="card">
MADMIN_URL
	<div class="card-header header-elements-sm-inline">

		<h6 class="card-title">Destek Şablonları</h6>

		<div class="text-right" style="margin-right:10px;">

		<a href="<?php echo MADMIN_URL; ?>/index.php?page=support_template_add"><span class="btn bg-success-400 btn-labeled btn-labeled-left"><b><i class="icon-add"></i></b> Destek Şablonu Ekle</span></a>

		</div>

	</div>



	<table class="table datatable-button-html5-basic">

	<thead>

		<tr>

			<th>Şablon Adı</th>

			<th class="tMADMIN_URL">İşlemler</th>
MADMIN_URL
		</tr>

	</thead>

	<tbody>

	<?php

	$informations = $db->table('support_templates')->order('id','desc')->get();

	if($informations['total_count']>0)

	{

		foreach($informations['data'] as $info)

		{

			echo '

			<tr>

				<td>'.$info['title'].'</td>

				<td class="text-right">

				

				<a href="'.MADMIN_URL.'/index.php?page=support_template&id='.$info['id'].'"><span class="btn bg-info-400"><b><i class="icon-pencil"></i></b></span></a>

				<a class="delete" href="'.MADMIN_URL.'/index.php?page=delete&table=support_templates&id='.$info['id'].'"><span class="btn bg-danger-400"><b><i class="icon-trash"></i></b> </span></a>

				</td>

			</tr>';

		}

	}

	?>

	</tbody>

	</table>



</div>



</div>



