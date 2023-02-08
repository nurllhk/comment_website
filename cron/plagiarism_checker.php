<?php
include('../init.php');

$reviews = $db->table('reviews')->where('status','=',0)->where('plagiarism','=',0)->order('id','asc')->limit(5)->get();

if($reviews['total_count']>0)
{
	$review_contents = array();

	$review_contents_data = $db->table('reviews')->where('status','=',1)->get();

	foreach($review_contents_data['data'] as $review_content)
	{
		$article = trim(strip_tags(htmlspecialchars_decode(html_entity_decode($review_content['content'],ENT_QUOTES,'UTF-8'))));
		
		array_push($review_contents,$article);
		
	}
	
	foreach($reviews['data'] as $review)
	{
		$review_id = $review['id'];
		$review_content = $review['content'];
		
		$plagiarism = new plagiarism();
		$result = $plagiarism->check($review_contents,$review_content);
		
		if($result->error)
		{
			$data = [
			'plagiarism_result' => 0,
			'original_content' => 0,
			'copy_content' => '-',
			'plagiarism' => 1
			
			];
		}
		else
		{
			
			$data = [
			'plagiarism_result' => $result['plagiarism_result'],
			'original_content' => $result['original'],
			'copy_content' => $result['copy'],
			'plagiarism' => 1
			
			];
		}
		$query = $db->table('reviews')->where('id','=',$review_id)->update($data);
		
	}
}