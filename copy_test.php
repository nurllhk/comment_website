<?php
include('init.php');
class plagiarisme
{
	public $ips = array('193.53.103.34','193.53.103.35','193.53.103.36','193.53.103.37','193.53.103.38','193.53.103.39','193.53.103.40','193.53.103.41','193.53.103.42','193.53.103.43','193.53.103.44','193.53.103.45');
	public $last_usage  = 0;
	public $error  = false;
	
	public function __construct()
	{
		$cache_file = ROOT_FOLDER.'/yahoo_cookie.txt';
		
		if(filemtime($cache_file) > (time() - 60 * 5 ))
		{
			$ch = curl_init();
			curl_setopt ($ch, CURLOPT_URL, 'https://www.yahoo.com');
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_INTERFACE, $ip_select);
			curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1');
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_COOKIEJAR, realpath($cache_file));
			$data= curl_exec($ch);
		}
	}
	public function ip_select()
	{
		
		if($this->last_usage>(count($this->ips)-1))
		{
			$changed_usage = 0;
			$last_usage = 1;
		}
		else
		{
			$changed_usage = $this->last_usage;
			$last_usage = $this->last_usage+1;
		}
		
		$this->last_usage = $last_usage;
		return $this->ips[$changed_usage];
	}
	
	public function m_explode($data,$start,$finish,$s,$f)
	{
		$return = explode($start,$data);
		$return = explode($finish,$return[$s]);
		return $return[$f];
	}
	
	public function check_array($arr,$needle)
	{
	
		$found = array_reduce($arr, function($isFound, $value) use ($needle) {
			return $isFound || false !== strpos($value, $needle);
		}, false);

		return $found;
	}
	
	public function percent($a,$b)
	{
		$c = $a / 100;
 
		return number_format($b / $c,2);
	}
	
	public function yahoo($word)
	{
		$word = trim(html_entity_decode(htmlspecialchars_decode($word)));
		$word = trim($word,".");
		$word = trim($word,",");
		$word = trim($word);
		$search = '"'.$word.'"';
		$ip_select = $this->ip_select();
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, 'https://search.yahoo.com/search?p='.urlencode($search).'');
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_INTERFACE, $ip_select);
		curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1');
		curl_setopt($ch, CURLOPT_REFERER,'https://www.yahoo.com');
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 20);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
			'accept-language: tr-TR,tr;q=0.9,en-US;q=0.8,en;q=0.7',
			'cache-control: max-age=0',
			'sec-ch-ua: " Not A;Brand";v="99", "Chromium";v="101", "Google Chrome";v="101"',
			'sec-ch-ua-arch: "x86"',
			'sec-ch-ua-bitness: "64"',
			'sec-ch-ua-full-version: "101.0.4951.67"',
			'sec-ch-ua-mobile: ?0',
			'sec-ch-ua-model: ""',
			'sec-ch-ua-platform: "Windows"',
			'sec-ch-ua-platform-version: "10.0.0"',
			'sec-fetch-dest: document',
			'sec-fetch-mode: navigate',
			'sec-fetch-site: same-origin',
			'sec-fetch-user: ?1'
		));
		curl_setopt ($ch, CURLOPT_COOKIEFILE, realpath(ROOT_FOLDER.'/yahoo_cookie.txt'));
		$data = curl_exec($ch);
	
		$info = curl_getinfo($ch);
		
		if($info['http_code']!=200)
		{
			$this->error = true;
		}
		
		$result = trim(html_entity_decode(htmlspecialchars_decode(urldecode($data))));
		$data = trim($this->m_explode($result,'searchCenterMiddle">','<div class="yucs-app-footer">',1,0));
		
		if($data=='')
		{
			$data = trim($this->m_explode($result,'searchCenterMiddle">','<footer',1,0));
		}
	
		
		if(stristr($data,$word))
		{
			return true;
			
		}
		return false;
	}
	
	public function check($review_contents,$article)
	{
		$db = new DB();
		$result = array();
		$plagiarism_result = strip_tags($article,'<div><b><p><br>');
		
		
		$article = trim(strip_tags(htmlspecialchars_decode(html_entity_decode($article,ENT_QUOTES,'UTF-8'))));
		$article = preg_replace("/\s+/", " ", $article);
		$article = preg_replace('/\xc2\xa0/', ' ', $article);
		$article = preg_replace("/\s+/u", " ", $article);
		$article = trim($article, " \t.");
		$article = trim($article, "\x00..\x1F");
		$article =preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u', '', $article);
		$article = str_replace('"','',$article);
		$word_groups=array_chunk(explode(" ", $article),7);
		
		$word_groups=array_map(function($value){
			return implode(" ",$value);
		},$word_groups);
		
		
		$total_groups = count($word_groups);
		$original = 0;
		$copy = 0;
		
		foreach($word_groups as $word_group)
		{
			if($this->check_array($review_contents,$word_group) or $this->yahoo($word_group))
			{
				$plagiarism_result = str_replace($word_group,'<b style="color:red;">'.$word_group.'</b>',$plagiarism_result);
				$copy++;
			}
			else
			{
				$original++;
			}
		}
		
		$result['plagiarism_result'] = $plagiarism_result;
		$result['original'] = $this->percent($total_groups,$original);
		$result['copy'] = $this->percent($total_groups,$copy);
		$result['error'] = $this->error;
		
		return $result;
		
	}
	
}



	$review_contents = array();

	$review_contents_data = $db->table('reviews')->where('status','=',1)->get();

	foreach($review_contents_data['data'] as $review_content)
	{
		$article = trim(strip_tags(htmlspecialchars_decode(html_entity_decode($review_content['content'],ENT_QUOTES,'UTF-8'))));
		
		array_push($review_contents,$article);
		
	}
	
	
		$review_content = 'Tam tahıllar metabolizmamızın en sağlam yakıtlarıdırlar. Tam tahıl ürünleri, B vitaminlerinden ve posadan oldukça zengindir. B grubu vitaminleri, vücutta enerji üretiminde kullanılır. Posaların ise sindirimi daha uzun süre aldığı için vücudun enerji harcamasını arttırırlar. Beyaz un ve beyaz ekmek yerine tam tahıl unları ve ekmekleri tercih etmelisiniz.

Her çeşit et tüketin ve etlerin görünür yağlarından kaçının
Kırmızı et, tavuk ve balık eti hepsi birbirinden farklı lezzette ve farklı faydası olan etlerdir. Tavuğun derisi, yağlı etler ve etlerin görünür yağlanın tüketmeyin. Sağlıklı pişmiş etleri bol baharatlı olarak tüketebilirsiniz. Damak tadınızı sağlıklı beslenmeye paralel şekilde geliştirin.

Her gün; 2-3 bardak süt, yoğurt, kefir veya ayran tüketin
Süt besinsel kaynaklar içerisinde en iyi kalsiyum kaynağıdır. Kemiklerimizin sağlamlığının bir garantisi olan bu besin grubuna gereken önemi vermelisiniz. Günde 2-3 su bardağı süt, yoğurt, ayran veya kefir tüketmeye gayret edin.

Sebze ve meyveyi ihmal etmeyin
Günde 5-9 porsiyon taze-sebze ve meyve tüketmelisiniz. Her ana öğünde sebze yemeklerine ve salatalara yer vererek ve ara öğünlerde meyveleri daha sık tercih ederek beslenmemizde bu dengeyi rahatlıkla sağlayabiliriz.';
		
		$plagiarism = new plagiarisme();
		$result = $plagiarism->check($review_contents,$review_content);
		print_r($result);
		exit;
		


?>