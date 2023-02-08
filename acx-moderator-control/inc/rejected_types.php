<?php if(!defined('ADMIN_INCLUDED')) { exit; } ?>

<div class="content">



<div class="card">
MADMIN_URL
	<div class="card-header header-elements-sm-inline">

		<h6 class="card-title">Red Nedenleri</h6>

		<div class="text-right" style="margin-right:10px;">

		<a href="<?php echo MADMIN_URL; ?>/index.php?page=rejected_type_add"><span class="btn bg-success-400 btn-labeled btn-labeled-left"><b><i class="icon-add"></i></b> Red Nedeni Ekle</span></a>

		</div>

	</div>



	<table class="table datatable-button-html5-basic">

	<thead>

		<tr>

			<th>Kısa İsim</th>

			<th>İkon</th>

			<th>Görünüm Sırası</th>

			<th>Kopya Kullanımı</th>

			<th class="tMADMIN_URL">İşlemler</th>
MADMIN_URL
		</tr>

	</thead>

	<tbody>

	<?php

	$informations = $db->table('rejected_types')->order('id','desc')->get();

	if($informations['total_count']>0)

	{

		foreach($informations['data'] as $info)

		{

			echo '

			<tr>

				<td>'.$info['title'].'</td>

				<td><i class="'.$info['icon'].'"></i></td>

				<td>'.$info['rt_rank'].'</td>

				<td>'.m_yes_no($info['copy']).'</i></td>

				<td class="text-right">

				

				<a href="'.MADMIN_URL.'/index.php?page=rejected_type&id='.$info['id'].'"><span class="btn bg-info-400"><b><i class="icon-pencil"></i></b></span></a>

				<a class="delete" href="'.MADMIN_URL.'/index.php?page=delete&table=rejected_types&id='.$info['id'].'"><span class="btn bg-danger-400"><b><i class="icon-trash"></i></b> </span></a>

				</td>

			</tr>';

		}

	}

	?>

	</tbody>

	</table>



</div>



</div>



