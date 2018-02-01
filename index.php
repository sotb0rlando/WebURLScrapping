<?php
error_reporting(1);
date_default_timezone_set('Asia/Kolkata');

//Different URLs
$multiUrl = array(0=>'sitenameA', 1=>'sitenameB', 2=>'sitenameC');

$rnd = rand(0,2);


function getUrlList($urlCode)
{
	$result = array(); 
	switch($urlCode)
	{
		case 'sitenameA' :
							$urlC = 'https://www.sitenameA.com';
							$urlContent = file_get_contents($urlC);
							$dom = new DOMDocument();
							@$dom->loadHTML($urlContent);
							$xpath = new DOMXPath($dom);
							// This below line will scrap all the anchor tag of the page who's rel attribute is havimg value 'noopener'
							$hrefs = $xpath->evaluate("/html/body//a[@rel='noopener']");
							for($i = 0; $i < $hrefs->length; $i++){
								$href = $hrefs->item($i);
								// To get href of that particular anchor tag
								$url = $href->getAttribute('href');
								$url = filter_var($url, FILTER_SANITIZE_URL);
								if(!filter_var($url, FILTER_VALIDATE_URL) === false){
									$result[$i] = $url;
								}
							}
							$result['meta'] = get_meta_tags($urlC);
							// This below line will get title of the page
							$title = $xpath->evaluate("string(/html/head/title)");
							if(isset($title) && $title!='')
							{
								$result['title'] = $title;
							}
							break;
		case 'sitenameB' :
							$urlC = 'http://www.sitenameB.com';
							$urlContent = file_get_contents($urlC);
							$dom = new DOMDocument();
							@$dom->loadHTML($urlContent);
							$xpath = new DOMXPath($dom);
							// This below line will get all anchor tags which comes under the div who's id is 'listcontent'
							$hrefs = $xpath->evaluate("/html/body//div[@id='listcontent']//a");
							for($i = 0; $i < $hrefs->length; $i++){
								$href = $hrefs->item($i);
								// To get href of that particular anchor tag
								$url = $href->getAttribute('href');
								$url = filter_var($url, FILTER_SANITIZE_URL);
								if(!filter_var($url, FILTER_VALIDATE_URL) === false){
									$result[$i] = $url;
								}
							}
							$result['meta'] = get_meta_tags($urlC);
							$title = $xpath->evaluate("string(/html/head/title)");
							if(isset($title) && $title!='')
							{
								$result['title'] = $title;
							}
							break;	
		case 'default':					
	}
	return $result;
}



// Final code goes here

if(isset($multiUrl[$rnd]) && $multiUrl[$rnd]!='')
{
	$finalResult = getUrlList($multiUrl[$rnd]);
	echo "<pre>"; print_r($finalResult);
	$arraycount= sizeof($finalResult)-3;
	$arrUrl = rand(sizeof($finalResult)-10,$arraycount);


	// Code if you want to get any random url with description and title	
	 $title = $finalResult['title'];
	 $description = $finalResult['meta']['description'];
 	 $url = $finalResult[$arrUrl];
	
	
}



?>