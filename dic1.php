



<?php



require ("vendor/autoload.php");
use PHPHtmlParser\Dom;

// Assuming you installed from Composer:

    $your_word=$_POST["word"];

	$dom = new Dom;
	$dom->loadFromUrl("https://fastdic.com/word/$your_word");
	
    //not-found
	$contents1=$dom->find('.not-found');
	
	//Change Page
	$contents2=$dom->find('.auth__form');
	
	////English Word
	$contents3 = $dom->find('.js-definitions');
	
	//Persian Search
	$contents4=$dom->find('.js-result');
	
	
	
    $number1=count($contents1);
	$number2=count($contents2);
	$number3=count($contents3);
	$number4=count($contents4);
	
	/* echo $contents1;
	echo $contents2;
	echo $contents3;
	echo $contents4;
	echo $number1;
	echo $number2;
	echo $number3;
	echo $number4; */
	 
	if ($number1> 0 or $number2>0 )
	{
		
		//echo'<!DOCTYPE html><html><head></head><body dir=rtl>';
		//echo ("<h1  style=color:red;margin-right:100px;>$main_mean</h1>");
		//echo '</body></html>';
		$Result["Result"]="لغت مورد نظر یافت نشد";
		echo preg_replace_callback("/\\\\u([a-f0-9]{4})/iu", function($m){return iconv('UCS-4LE','UTF-8',pack('V', hexdec('U'.$m[1])));}, json_encode($Result));
		//$dic_res->result="لغت مورد نظر یافت نشد";
		//$myJSON = json_encode($dic_res);

		//echo $myJSON;
		
	}
	elseif ($number3>0)
	{
		$contents3 = $dom->find('.js-definitions');
		$main_mean=$contents3->find('.js-definitions');
		$main_mean=$contents3->text;
		$contents3 = $contents3->find('.result__sentences li');
		//$contents3 = $contents3->find('li');
		//echo'<!DOCTYPE html><html><head></head><body dir=rtl>';
		//echo ("<h1  style=color:red;margin-right:100px;>$main_mean</h1>");

		foreach ($contents3 as $key => $value) {
				
				$res[]= $value->text;
				
				
				//$id=0;
			//echo "<h3  lstyle=color:blue;text-align:center>$value</h3>";
			//$res[]=$value;
			//$dic_res->result=$value->text;
			//$id++;
			//echo $value;
			//echo $contents3;

		}
		foreach ($res as $key=>$value)
		
		{
			
			if (fmod($key, 2)==0)
			{
				
				$Result["Result"][]=array($res[$key]=>$res[$key+1]);
			}
			
		} 
		
		//echo var_dump($Result);
		 //$res=implode(" ",$res);
		//echo $res;
		echo preg_replace_callback("/\\\\u([a-f0-9]{4})/iu", function($m){return iconv('UCS-4LE','UTF-8',pack('V', hexdec('U'.$m[1])));}, json_encode($Result));
		//$myJSON = json_encode($Result);
		//echo $myJSON;
		
		
		
	}elseif($number4>0)
	{
		$contents4 =$dom->find('.js-word');
		$contents4=$dom->find('.js-result');
		$contents4=$contents4->find('li');
		$contents4=$contents4->text;
		echo "<h3  style=color:#59c9cd;margin-top:50px;text-align:center;>$contents4</h3>";
		
	}
	  

?>