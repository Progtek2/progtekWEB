<?php
require_once '../includes/application.start.php';
$login = new View_User_Login();
$news = new View_User_News();

if($login->requestRegister)
	header("Location: register.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Al-Jah-Ha-Ha</title>
<link href="layout.css" rel="stylesheet" type="text/css" />

    <script src="jQuery/jquery-1.8.3.min.js"></script>

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
	else
	{
		$("#news > div:last").animate({height:'show', opacity: 'show'},'slow',rotate).delay(rotateSpeed);
	}

}

$.ajaxSetup ({
// Disable caching of AJAX responses
cache: false
});



var auto_refresh = setInterval(
	function()
	{
		$('#content').fadeOut("fast").load('contentReload.php').fadeIn("fast");
		doRotate = false;

	}, 600000
);
</script>

</head>

<body>
<div id="container">
  <div id="header">
    <div id="logo">
      <h1>Al-jah-ha-ha</h1>
    </div>
    <h1>Nyheter</h1>
  </div>
  <div id="content">
  
  
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
  </div>
  
  <div id="login">
    <?php if(!$login->isLoggedIn): ?>
    
   
    <form action="" method="post">
      <fieldset>
        <legend>Logg inn</legend>
        <label>Brukernavn: </label>
        <input type="text" value="" name="Username" size="20" />
        <br />
        <label>Passord:</label>
	<br />
        <input type="password" value="" name="Password" size="20" />
            <?php if($login->loginAttemptFailed):?>
    			<div>Brukernavn eller passord er feil</div>
   			<?php endif;?>
   			<button type="submit" name="Action" value="login">Logg inn</button>
   			<button type="submit" name="Action" value="requestRegister">Registrer</button>
   		  	<input type="hidden" name="Module" value="<?php echo $login->module; ?>" />
      	<input type="hidden" name="Controller" value="<?php echo $login->controller; ?>" />
      </fieldset>
    </form>
    <?php else:?>
        <form action="" method="post">
      <fieldset>
        <legend>Velkommen: <?php echo $login->user->GetGivenName().' '.$login->user->GetFamilyName();?></legend>
                          <label>Gruppe:</label> <?php echo $login->user->GetGroup();?><br />
          <label>Registrert siden:</label> <?php echo $login->user->GetRegisterDate();?><br />
          <label>Antall innlogginger:</label> <?php echo $login->user->GetNumberOfLogins();?><br />
        <div><a href="userSite.php">Min side</a></div>
        <input type="submit" value="Logg ut" name="Logout" />
      	<input type="hidden" name="Module" value="<?php echo $login->module; ?>" />
      	<input type="hidden" name="Controller" value="<?php echo $login->controller; ?>" />
      	<input type="hidden" name="Action" value="logout" />
      </fieldset>
    </form>
    <?php endif;?>
  </div>
  <div id="advertising">
  
 <h3>Dine s&oslash;keord</h3>
  <?php foreach($news->keywordNews as $keyword=>$items){ ?>
    <h3><?php echo $keyword; ?></h3>
  	<?php foreach($items as $item){ ?> 
    <a href="<?php echo $item->GetLink(); ?>"><?php echo $item->GetTitle(); ?></a><br />
    <div><?php echo strip_tags($item->GetDescription()); ?></div><br />
    <?php }}?>

      <h2>Vis nyheter p&aring; ditt nettsted</h2>
  <p>Kopier koden under til din side. Du kan selv justere h&oslash;yde og bredde ved &aring; variere variablene height og width.</p>
  <textarea rows="10" cols="22"><iframe src="http://sandbox.kiiw.org:8001/news/public_html/widgets/widgetBasic.php?Height=400&Width=200" style="height: 400px; width:200px; border-width:0px;"></iframe></textarea>
    
  </div>
  <div id="about">
    <ul>
      <li><a href="#">Annonsering</a></li>
      <li><a href="#">Blog</a></li>
      <li><a href="#">Hjelp</a></li>
      <li><a href="#">Kontakt</a></li>
      <li><a href="#">Om</a></li>
      <li><a href="#">Opphavsrett</a></li>
      <li><a href="#">Ressurser</a></li>
      <li><a href="#">Utviklere</a></li>
    </ul>
  </div>
  <div id="footer"></div>
</div>
</body>
</html>
