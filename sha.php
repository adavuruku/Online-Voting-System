<?php
$J=100;
$d=mt_rand(1,$J);
echo $d.' YEA';
echo '<br /><br /><br />';

$J=100;
$d=mt_rand(1,$J);
echo $d.' YEA2';
echo '<br /><br /><br />';

echo ceil(4/3);
$y = strlen("Hello world");
echo $y;
echo '<br /><br /><br />';
echo substr("Hello world",0,2.98764);
echo '<br /><br /><br />';
$iteratepoint = 'c:/wamp/www/ninjanewswatch/resourcefile/News_Files/48639347419455/';
	$dir = new DirectoryIterator($iteratepoint);
	$j=0;
	foreach ($dir as $fileinfo) 
	{
		if (!$fileinfo->isDot()) 
		{
			$j =$j+1;
			/**$picky = $fileinfo->getFilename();
			 if(substr_count($picky,"news_file") > 0){
				$the_file = $picky;
			}**/
		}
	}
	$q = ceil($y / $j);
	echo $q;
echo '<br /><br /><br />';
$p = "111";
echo SHA1($p).'<br/>';
$d=mt_rand(10560,92070)+time();
$k="";
        $z =str_split($d);
        $add = array("pI","L4","W9","3N","Os","1K","Q8","xV","Se","Wo");
        foreach ($z as $value)
        {
			$f=$add[$value];
			$k=$k.$f;
			$serials="SUG".$k;
        }
		$serials="SUG".$k;
		echo $serials.'<br/>';
		echo sha1($serials);
		
		
		//date time additioning
		$startTime = date("d-m-Y h:i:s A");
		
		//display the start time
		echo 'start time :'. $startTime;
		
		//add 1 hr
		$convertedTime =date('d-m-Y h:i:s A' , strtotime ('+30 minutes', strtotime ($startTime)));
		echo $convertedTime. "<br>";
		$trans_code = (rand() + time());
			echo "SOSM/".$trans_code. "<br>";
		
echo(strtotime("now") . "<br>");
echo(strtotime("3 October 2005") . "<br>");
echo(strtotime("+5 hours") . "<br>");
echo(strtotime("+1 week") . "<br>");
echo(strtotime("+1 week 3 days 7 hours 5 seconds") . "<br>");
echo(strtotime("next Monday") . "<br>");
echo(strtotime("last Sunday"));

$str_time = date("Y-m-d H:i:s");
$str_time_l = '2017-01-30 18:28';

$str_time = strtotime($str_time);
$str_time_l = strtotime($str_time_l);
$hours = abs($str_time - $str_time_l) /(60*60);
if($hours>=1){
	echo '<br /> date diff : '.$hours.'<br />';
}


?>
		
?>