<?php
	m_header();
?>   
<div class="main">
	<div class="container">
		<div class="row">

		
		<div class="col-xl-12 col-lg-12 col-sm-12">
		<div class="page_head">
		<div class="page_icon"><i class="fa fa-comments"></i></div>
		<div class="page_title"><h1>Yorumlarım</h1></div>
		</div>
		<div class="row">
		
		<div class="col-xl-4 col-lg-4 col-sm-4 col-12">
			
			<?php require_once('account_part.php'); ?>
		
		</div>
		
		<div class="col-xl-8 col-lg-8 col-sm-8 col-12">
		
		
		<div class="card mb-3">
		<div class="card-body">
         	<table class="table table-bordered nowrap datatable dt-responsive" style="width:100%">
			<thead>
				<tr>
					<th>İnceleme</th>
					<th>Tarih</th>
					<th>Durum</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$user_comments = $db->table('comments')->where('u_id','=',USER['id'])->order('id','desc')->get();
			if($user_comments['total_count']>0)
			{
				foreach($user_comments['data'] as $comment)
				{
					$r_detail = $db->table('reviews')->where('id','=',$comment['r_id'])->get_vars();
					echo '
					<tr>
						<td><a href="'.m_permalink('review',$r_detail['sef'],$r_detail['id']).'">'.$r_detail['title'].'</a></td>
						<td>'.m_date_to_tr($comment['date']).'</td>
						<td>'.m_comment_status($comment['status']).'</td>
					</tr>';
				}
			}
			?>
			</tbody>
			</table>
		</div>
		</div>
		
		</div>
		
		
		
		</div>
		</div>
		
		
		
		</div>
	</div>
</div>
<?php
	m_footer();
?>
					