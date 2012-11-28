<?php require_once '../includes/application.start.php';
$login = new View_User_Login();
$view = new View_User_Registrer();


if($view->userRegisterSuccess)
{
	$redirectUrl = 'userSite.php?EditUserId='.$view->registeredUser->GetUserId();
	header("Location: $redirectUrl");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Registrer - Al-Jah-Ha-Ha</title>
<link href="layout.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="container">
  <div id="header">
    <h1>Register ny bruker</h1>
  </div>
  <div id="content">
          <form action="" method="post">
        <fieldset>
        <legend>Registerer ny bruker:</legend>
          <?php if($view->user != null && $view->user->GetGroup() == 'Admin'):?>
         	 <label>Gruppe:</label><br />
          	<select name="Group">
          		<option <?php if($view->registerForm['Group']['Value'] == 'User') echo ' selected="selected" ';?> value="User">Bruker</option>
          		<option <?php if($view->registerForm['Group']['Value'] == 'Moderator') echo ' selected="selected" ';?> value="Moderator">Moderator</option>
          		<option <?php if($view->registerForm['Group']['Value'] == 'Admin') echo ' selected="selected" ';?> value="Admin">Administrator</option>
           	</select>
           	<?php if($view->registerForm['Group']['Error']) echo '<span class="FormError">'.$view->registerForm['Group']['ErrorMessage'].'</span>';?>
           	<br />
          <?php endif; ?>
          
          
          <label>Brukernavn:</label><br />
          <input type="text" name="Username" value="<?php echo $view->registerForm['Username']['Value'];?>" size="20" maxlength="30" />
          <?php if($view->registerForm['Username']['Error']) echo '<span class="FormError">'.$view->registerForm['Username']['ErrorMessage'].'</span>';?>
          <br />
         
          
          <label>Passord:</label><br />
          <input type="password" name="Password" value="" size="20" maxlength="30" />
          <?php if($view->registerForm['Password']['Error']) echo '<span class="FormError">'.$view->registerForm['Password']['ErrorMessage'].'</span>';?>
          <br />
          <label>Gjenta passord:</label><br />
          <input type="password" name="RepeatPassword" value="" size="20" maxlength="30" />
          <?php if($view->registerForm['RepeatPassword']['Error']) echo '<span class="FormError">'.$view->registerForm['RepeatPassword']['ErrorMessage'].'</span>';?>
          <br />
          <label>Fornavn:</label>
	  <br />
          <input type="text" name="GivenName" value="<?php echo $view->registerForm['GivenName']['Value'];?>" size="20" maxlength="30" />
	  <br />
          <label>Mellomnavn: </label>
	  <br />
          <input type="text" name="AdditionalName" value="<?php echo $view->registerForm['AdditionalName']['Value'];?>" size="20" maxlength="30" />
	  <br />
          <label>Etternavn: </label>
	  <br />
          <input type="text" name="FamilyName" value="<?php echo $view->registerForm['FamilyName']['Value'];?>" size="20" maxlength="30" />
	  <br />
          <label>E-post: </label>
	  <br />
          <input type="text" name="Email" value="<?php echo $view->registerForm['Email']['Value'];?>" size="35" maxlength="100" />
          <?php if($view->registerForm['Email']['Error']) echo '<span class="FormError">'.$view->registerForm['Email']['ErrorMessage'].'</span>';?>
          
	  <br />
          <label>Kj&oslash;nn: </label>
	  <br />
          <select name="Gender">
            <option <?php if($view->registerForm['Gender']['Value'] == "Female") echo 'selected="selected"';?> value="Female">Hun</option>
            <option <?php if($view->registerForm['Gender']['Value'] == "Male") echo 'selected="selected"';?> value="Male">Han</option>
            <option <?php if($view->registerForm['Gender']['Value'] == "Unknown") echo 'selected="selected"';?> value="Unknown">Hemmelig</option>
          </select>
          <?php if($view->registerForm['Gender']['Error']) echo '<span class="FormError">'.$view->registerForm['Gender']['ErrorMessage'].'</span>';?>
          
	  <br />
          <label>F&oslash;dselsdag: (YYYY-MM-DD)</label>
	  <br />
          <input type="text" name="Birthday" value="<?php echo $view->registerForm['Birthday']['Value'];?>" size="20" />
	  <br />
          
          <button type="submit" name="Action" value="register">Registrer bruker</button>
          
            <input type="hidden" name="Module" value="<?php echo $view->module; ?>" />
      		<input type="hidden" name="Controller" value="<?php echo $view->controller; ?>" />
      	
      	       
        </fieldset>
      </form>
    
    
    
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
  <div id="advertising">Innhold for annonser plasseres her.</div>
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