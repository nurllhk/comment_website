<?php if(!defined('ADMIN_INCLUDED')) { exit; } ?>

<div class="content">



<div class="card">

	<div class="card-header header-elements-sm-inline">

		<h6 class="card-title">Moderatörler</h6>

		<div class="text-right" style="margin-right:10px;">

		<a href="<?php echo MADMIN_URL; ?>/index.php?page=moderator_add"><span class="btn bg-success-400 btn-labeled btn-labeled-left"><b><i class="icon-add"></i></b> Moderatör Ekle</span></a>

		</div>

	</div>



	<table class="table datatable-button-html5-basic">

	<thead>

		<tr>

			<th>İsim</th>

			<th>Son Giriş</th>

			<th>Bugün</th>

			<th>Bu Hafta</th>

			<th>Bu Ay</th>

			<th>Toplam</th>

			<th>Durum</th>

			<th class="text-right">İşlemler</th>

		</tr>

	</thead>

	<tbody>

	<?php

	$informations = $db->table('moderators')->get();

	if($informations['total_count']>0)

	{

		foreach($informations['data'] as $info)

		{

			$moderator_actions = $db->query("select 

			SUM(case when DATE(date) = CURDATE()then 1 else 0 end) as today,

			SUM(case when YEARWEEK(date) = YEARWEEK(CURRENT_DATE) then 1 else 0 end) as week,

			SUM(case when MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE()) then 1 else 0 end) as month,

			COUNT(*) as total

			from moderator_actions

			where m_id='".$info['id']."'")->fetchAll(PDO::FETCH_ASSOC)[0];

			

			$moderator_actions_reviews = $db->query("select 

			SUM(case when DATE(date) = CURDATE()then 1 else 0 end) as today,

			SUM(case when YEARWEEK(date) = YEARWEEK(CURRENT_DATE) then 1 else 0 end) as week,

			SUM(case when MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE()) then 1 else 0 end) as month,

			COUNT(*) as total

			from moderator_actions

			where m_id='".$info['id']."' and data_type='review'")->fetchAll(PDO::FETCH_ASSOC)[0];

			

			$moderator_actions_comments = $db->query("select 

			SUM(case when DATE(date) = CURDATE()then 1 else 0 end) as today,

			SUM(case when YEARWEEK(date) = YEARWEEK(CURRENT_DATE) then 1 else 0 end) as week,

			SUM(case when MONTH(date) = MONTH(CURRENT_DATE()) AND YEAR(date) = YEAR(CURRENT_DATE()) then 1 else 0 end) as month,

			COUNT(*) as total

			from moderator_actions

			where m_id='".$info['id']."' and data_type='comment'")->fetchAll(PDO::FETCH_ASSOC)[0];

			

			echo '

			<tr>

				<td>'.$info['name'].'<br>

				<td><span class="btn btn-sm btn-success" style="width:120px"><i class="fa fa-clock"></i> '.m_time_ago($info['last_login']).'</span></td>

				<td>

				  <button type="button" class="btn btn-sm btn-success text-left mb-2" style="width:70px"><i class="fa fa-pen-square"></i> '.m_number_format($moderator_actions_reviews['today']).'</button>

				  <button type="button" class="btn btn-sm btn-primary text-left mb-2" style="width:70px"><i class="fa fa-comments"></i> '.m_number_format($moderator_actions_comments['today']).'</button>

				</td>

				<td>

				  <button type="button" class="btn btn-sm btn-success text-left mb-2" style="width:70px"><i class="fa fa-pen-square"></i> '.m_number_format($moderator_actions_reviews['week']).'</button>

				  <button type="button" class="btn btn-sm btn-primary text-left mb-2" style="width:70px"><i class="fa fa-comments"></i> '.m_number_format($moderator_actions_comments['week']).'</button>

				</td>

				<td>

				  <button type="button" class="btn btn-sm btn-success text-left mb-2" style="width:70px"><i class="fa fa-pen-square"></i> '.m_number_format($moderator_actions_reviews['month']).'</button>

				  <button type="button" class="btn btn-sm btn-primary text-left mb-2" style="width:70px"><i class="fa fa-comments"></i> '.m_number_format($moderator_actions_comments['month']).'</button>

				</td>

				<td>'.m_number_format($moderator_actions['total']).'</td>

				<td>'.m_status($info['status']).'</td>

				<td class="text-right">

				

				<a href="'.MADMIN_URL.'/index.php?page=moderator&id='.$info['id'].'"><span class="btn bg-info-400 btn-block mb-2"><b><i class="icon-pencil"></i></b></span></a>

				<a class="delete" href="'.MADMIN_URL.'/index.php?page=delete&table=moderators&id='.$info['id'].'"><span class="btn bg-danger-400 btn-block mb-2"><b><i class="icon-trash"></i></b> </span></a>

				</td>

			</tr>';

		}

	}

	?>

	</tbody>

	</table>



</div>



</div>



