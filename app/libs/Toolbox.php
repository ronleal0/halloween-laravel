<?php 

class Toolbox {

	// private $cachedir = storage_path().'/cache/_cache';

	private $queryBase = 'http://become_seo:5gZy1XRg@us.channel.become.com/livexml/3.1/become_seo-us.portal/query';
	private $ProductBase = 'http://become_seo:5gZy1XRg@us.channel.become.com/livexml/3.1/become_seo-us.portal/product';
	


	public static function clearCache($maxAge = 1440) {
		$caches = $this->cachedir . "*";
		$files = glob($caches);
			foreach($files as $file) {
					if(is_file($file)
					&& time() - filemtime($file) >= $maxAge) { // 2 days
							unlink($file);
					}
			}
	}

	public static function debug($obj){
		echo "<pre>";
		print_r($obj);
		echo "</pre>";
	}

	public static function _log($url) {
		if (!is_dir(storage_path().'/cache/_logs')) {mkdir(storage_path().'/cache/_logs');}
		$f = fopen(storage_path().'/cache/_logs/curl-'.date("Y-m-d").".log",'a');
		fwrite($f, date("H:i:s")."  ".$url."\n");
		fclose($f);
	}

	public static function getContentCached($url,$maxAge = 1440) { //maxAge in minutes -- default = 1 day
		//creates _cache dir if there is none
		if (!is_dir(storage_path().'/cache/_cache')) {mkdir(storage_path().'/cache/_cache');}

		//get cached file
		$cachedFile = storage_path().'/cache/_cache/'.md5($url).".html";
		//self::debug($cachedFile);
		//die();

		//if there is cached file and the time it was change is below 3 days, return the content. Otherwise, write again (this will reset the filemtime)
		if (file_exists($cachedFile) && (time() - filemtime($cachedFile)) < ($maxAge*60)) { //set to 3 days
			return file_get_contents($cachedFile);
		} else {
			$content = self::getContent($url);
			$fp = @fopen($cachedFile, 'w');
			@fwrite($fp, $content);
			@fclose($fp);
			return $content;
		}
	}

	public static function getContent($url) {
		self::_log($url);
		if (function_exists("curl_init"))
			return self::httpRequest($url);
		else 
			return file_get_contents($url);
	}


	public static function getXML($url) {
		$content = self::getContentCached($url);
		$xml = simplexml_load_string(str_replace('xmlns=','ns=',$content));
		return $xml;
	}


	public static function httpRequest($url) {
		global $sistrix;
		$url = str_replace(" ", "%20", $url);
	    $ch = curl_init();

	    curl_setopt_array($ch, array(
	        CURLOPT_URL => $url,
	        CURLOPT_RETURNTRANSFER => true,
	        CURLOPT_AUTOREFERER => true,
	        CURLOPT_TIMEOUT => 10,
	        CURLOPT_FRESH_CONNECT => true,
	        CURLOPT_FORBID_REUSE => true,
	        CURLOPT_SSL_VERIFYPEER => false,
	        CURLOPT_HEADER => true,
	        CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.79 Safari/535.11'
	    ));
	   
	    if (!ini_get('safe_mode') && ini_get('open_basedir') === null) {
	    	//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
	    	curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
	    }
			if ($sistrix) {
				curl_setopt($ch, CURLOPT_COOKIE, "sistrix-user=6557%3BRYEMhwk6snUeAbwzqZ9w29ShPhhZjLJhdchBx96MQMGYm5JdygfawzM7InFStQDq");		
			}
	    
	    $content = '';
	    $header = '';
	    
	    $response = curl_exec($ch); 
			
	    $info = curl_getinfo($ch);
	    if (!isset($info['http_code'])) {
	        $info['http_code'] = '200';
	    }
			/*
	    if ($statusCode === null) {
	    	$statusCode = $info['http_code'];
	    }*/
	    curl_close($ch);
	    $parts = preg_split('|(?:\r?\n){2}|m', $response, 2);
	    
	    if (isset($parts[0])) {
	        $content = str_replace($parts[0], '', $response);
	        $header = $parts[0];
	    }
	    if (preg_match_all('#([^:\n<]+):([^\n<]+)\r\n#',$header, $matches)) {
	    	foreach ($matches[0] as $i => $line) {
	    		if ($matches[1][$i] == 'Location') {
	    			
	    			//header('X-redirect-url: ' . trim($matches[2][$i]));
	    			if (isset($_GET['followRedirect']) && $_GET['followRedirect'] == 1) {
		    			return httpRequest(trim($matches[2][$i]), $statusCode);
		    		}
	    		}
	    	}
	    }
	    return trim($content);
	}


	public static function getProductsByCat($cid,$pge=NULL,$pgn=NULL){
		$url = "http://become_seo:5gZy1XRg@us.channel.become.com/livexml/3.1/become_discount-us.portal/browse;product-results/$cid?cf=od&pge=$pge&pgn=$pgn";
		$xml = self::getXML($url);
		$products = $xml->xpath('//product-results-module/product-results');
		return $products;
	}	
	

	public static function getSub($id){
		return DB::table('subcategories')->remember(1440)->where('parent_id', $id)->get();
	}
	
	public static function mergeObjects($ob1,$ob2){
		$obj_merged = (object) array_merge((array) $ob1, (array) $ob2);
		return $obj_merged;
	}	

	public static function getDiscount($old,$new){
		$discounts = (((int)$old - (int)$new)/(int)$old)*100;
		return intval($discounts); 
	}

	public static function cleanQuery($query, $delimiter='+') {
	$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $query);
	$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
	$clean = strtolower(trim($clean, '-'));
	$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

	return $clean;
	}

	public static function getSearchResults($query,$pge=NULL){
		$query = self::cleanQuery($query);
		$url = "http://become_seo:5gZy1XRg@us.channel.become.com/livexml/3.1/become_discount-us.portal/query;product-results/$query?cf=od&pge=". $pge;
		$xml = self::getXML($url);
		$products = $xml->xpath('//product-results-module/product-results/product');
		return $products;
	}

	public static function newgetSearchResults($query,$pge=NULL){
		$query = self::cleanQuery($query);
		$url = "http://become_seo:5gZy1XRg@us.channel.become.com/livexml/3.1/become_discount-us.portal/query;product-results/$query?cf=od&pge=". $pge;
		$xml = self::getXML($url);
		// $products = $xml->xpath('//product-results-module/product-results');
		return $xml;
	}

	public static function getPostByCat($catname){

		$string = file_get_contents("http://www.discountbee.com/blog/?json=get_category_posts&count=4&slug=$catname");
		$posts  =json_decode($string,true);
		$posts = $posts['posts'];

		return $posts;
	}

	public static function test($test){
		echo $test;
	}

	public static function getresultswithfilter($query,$pge=NULL){
		$query = self::cleanQuery($query);
		$url = "http://become_seo:5gZy1XRg@us.channel.become.com/livexml/3.1/become_discount-us.portal/query;result-filter;product-results/$query?pge=$pge&mode=default";
		$xml = self::getXML($url);
		// $products = $xml->xpath('//product-results-module/product-results');
		return $xml;
	}
}


