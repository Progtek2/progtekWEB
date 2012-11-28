<?php
require_once '../../includes/application.start.php';
$news = new View_User_News();

if(isset($_GET['Height']))
	$height = $_GET['Height'];
else
	$height = 350;


if(isset($_GET['Width']))
	$width = $_GET['Width'];
else
	$width = 300;



if(!is_numeric($height) || $height > 2000)
	$height = 350;

if(!is_numeric($width) || $width > 800)
	$width = 300;


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="refresh" content="600">
    <title>Demo</title>
    <script src="../jQuery/jquery-1.8.3.min.js"></script>
    
      <style type="text/css">
      body {margin: 0px; padding:0px;}
  		ul#news {overflow: hidden; list-style-type: none; width: <?php echo $width; ?>px; height: <?php echo $height; ?>px; margin: 0px; padding:0px;}
  		ul#news li {padding: 3px 0px 3px 3px; border-width: 0px 0px 1px 0px; border-color: #cccccc; border-style: solid;}
  	
  		ul#news li a{ display: block; text-decoration: none; color: #333333;}
  		ul#news li a:hover{ text-decoration: underline;}
  		
  	
	  </style>
  </head>
  <body>

<script type="text/javascript">

doRotate = true;
rotateSpeed = 1000;

$(document).ready(function(){

	$("#news").hover(
		function() {doRotate = false;},
		function() {doRotate = true;}

			);
	
	rotate();

	}


	);


function rotate(){


	if(doRotate)
	{
		$("#news > li:eq(0)").animate({height:'hide', opacity: 'hide'},'slow', 
			function(){
				$("#news").append($("#news > li:eq(0)").animate({height:'show', opacity: 'show'},'slow',rotate));
				}).delay(rotateSpeed);
	}
	else
	{
		$("#news > li:last").animate({height:'show', opacity: 'show'},'slow',rotate).delay(rotateSpeed);
	}

}
</script>

   <ul id="news">
  	<?php
  	$count = 0;
  	$newsPerSlider = 5; 
  	foreach($news->news as $item){ ?>
    <li><a href="<?php echo $item->GetLink(); ?>" title="<?php echo htmlspecialchars($item->GetDescription()); ?>" target="_blank"><?php echo $item->GetTitle(); ?></a></li>
    <?php    	}?>    
    </ul>

  
   
  </body>
</html>