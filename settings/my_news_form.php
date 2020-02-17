<?php
//rotate

	
?>

<script type="text/javascript">
//NewsFeedTicker2_Data["number of news?news_id=id_of_news_in_db"] = ["page_link of news", "Title / Topic Of News", "Date of News", "Little Part of the News"];
//NewsFeedTicker2_Data[5] = ["#", "2013 / 2014 Acceptance Fee Payment For Undergraduate", "Fri, 24 Oct 2014 10:09:15 GMT", "Payment of Acceptance Fees for Undergraduate Admissions commence 12 November, 2013 ...Click for Procedures and Payment"];
$(document).ready(function()
{
   var NewsFeedTicker2_Data = new Array();
   <?php 
   $my_file="";
	
	$stmt = $conn->prepare("SELECT * FROM news ORDER BY id DESC Limit 10");
	$stmt->execute();
	$affected_rows = $stmt->rowCount();
	if($affected_rows >= 1) 
	{	
		$j=0;
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
		
			
			$path="read_information_details.php?news_id=".$row['news_id'];
			//$title ="<p style='color:yellow'>".$row['news_head']."</p>";
			$title =$row['news_head'];
			
			$date500 = new DateTime($row['news_date']);
			$date = date_format($date500,"m/d/Y");
			//$date = "<p style="color:black">10/23/2015"</p>";
			//$date = '<p style="color:black">'.$date.'</p>';
			//$date = htmlspecialchars_decode($date);
			$subj="";
			$subj = substr($row['news_info'],0,100);
			$body = $subj."...";
			$body=strip_tags($body);
			$body= str_ireplace('<p>','',$body);
			$my_file=$my_file.'NewsFeedTicker2_Data['.$j.'] = ["'.$path.'", "'.$title.'", "'.$date.'", "'.$body.'"];';

			$j=$j+1;
		}
		echo $my_file;
	}
	?>
	
    $("#NewsFeedTicker2").newsviewer({ mode: 'scroller', pause: 5000, pause: 5000, animation: 4, animationDuration: 500, sortOrder: 0, dataSource: 'local', param: NewsFeedTicker2_Data, target: '_self', dateFormat: 'DD, d MM, yy', maxItems: 10});
});
</script>

<script type="text/javascript">
//NewsFeedTicker2_Data["number of news?news_id=id_of_news_in_db"] = ["page_link of news", "Title / Topic Of News", "Date of News", "Little Part of the News"];
//NewsFeedTicker2_Data[5] = ["#", "2013 / 2014 Acceptance Fee Payment For Undergraduate", "Fri, 24 Oct 2014 10:09:15 GMT", "Payment of Acceptance Fees for Undergraduate Admissions commence 12 November, 2013 ...Click for Procedures and Payment"];
$(document).ready(function()
{
   var NewsFeedTicker1_Data = new Array();
   <?php 
   $my_file="";
	
	$stmt = $conn->prepare("SELECT * FROM store_articles ORDER BY id DESC Limit 10");
	$stmt->execute();
	$affected_rows = $stmt->rowCount();
	if($affected_rows >= 1) 
	{	
		$j=0;
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
		
			
			$path="read_articles_details.php?article_id=".$row['article_id'];
			//$title ="<p style='color:yellow'>".$row['news_head']."</p>";
			$title ="Author : ".$row['author'];
			
			$date500 = new DateTime($row['date_register']);
			$date = date_format($date500,"m/d/Y");
			$subj="";
			$subj = substr($row['article_title'],0,300);
			$body = "Article Title : ".$subj." ...";
			$body=strip_tags($body);
			$body= str_ireplace('<p>','',$body);
			$my_file=$my_file.'NewsFeedTicker1_Data['.$j.'] = ["'.$path.'", "'.$title.'", "'.$date.'", "'.$body.'"];';

			$j=$j+1;
		}
		echo $my_file;
	}
	?>
	
	 $("#NewsFeedTicker1").newsviewer({ mode: 'rotate', pause: 3000, pause: 3000, animation: 4, animationDuration: 500, sortOrder: 1, dataSource: 'local', param: NewsFeedTicker1_Data, target: '_self', dateFormat: 'DD, d MM, yy', maxItems: 10});
});
</script>