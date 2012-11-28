<script>
doRotate = true;
rotateSpeed = 1500;

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
		$("#news > div:eq(0)").animate({height:'hide', opacity: 'hide'},'slow', 
			function(){
				$("#news").append($("#news > div:eq(0)").animate({height:'show', opacity: 'show'},'slow',rotate));
				}).delay(rotateSpeed);
	}
	

}
</script>
<?php
require_once '../includes/application.start.php';
$login = new View_User_Login();
$news = new View_User_News();

if($login->requestRegister)
	header("Location: register.php");

?>


<?php if(count($news->news) < 1): ?>
    <div>Her var det f&aring; nyheter. F&aring; flere nyheter ved &aring; velge kategorier i minside.</div>
<?php endif;?>

<div id="news">
	<?php foreach($news->news as $item){ ?>
    <div><h1><?php echo $item->GetTitle(); ?></h1>
    <p><?php echo $item->GetDescription(); ?><br />
    <a href="<?php echo $item->GetLink(); ?>">Les mer ...</a></p></div>
    <?php }?>
</div>