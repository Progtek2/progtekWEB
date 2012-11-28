<?php
require_once '../includes/application.start.php';
$view = new View_User_Userdetails();


if($view->user === null)
	header("Location: /news/public_html");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Brukerside - Al-Jah-Ha-Ha</title>
<link href="layout.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="container">
  <div id="header">
    <div id="logo">
      <h1>Al-jah-ha-ha</h1>
    </div>
    <h1>Brukerdetaljer</h1>
  </div>
  <div id="content">
    <div id="left">
     
	<form name="categories" action="" method="post">
	<fieldset>
		<legend>Nyhetskategorier</legend>
    <?php  
    	foreach($view->categories as $category)
    	{
    		$checked = ''; 
    		foreach($view->editUser->GetCategories() as $userCategory)
    			if($userCategory->GetId() == $category->GetId())
    				$checked = ' checked="checked" ';
    ?>
    <?php for($i=0; $i < $category->GetLevel(); $i++){ ?>&nbsp;&nbsp;&nbsp;<?php }?>
    <input type="checkbox" name="CategoryIds[<?php echo $category->GetId(); ?>]" <?php echo $checked;?>><?php echo $category->GetName(); ?><br />
      <?php }?>
      
      	<input type="submit" name="" value="Lagre endringer" />
                <input type="hidden" name="Module" value="<?php echo $view->module; ?>" />
      		<input type="hidden" name="Controller" value="<?php echo $view->controller; ?>" />
      		<input type="hidden" name="Action" value="saveCategories" />
      		            <input type="hidden" name="EditUserId" value="<?php echo $view->editUser->GetUserId(); ?>" />      
      		
      		</fieldset>
      </form>
      
	<form name="categories" action="" method="post">
		<fieldset>
			<legend>S&oslash;keord</legend>  
            <input type="hidden" name="Module" value="<?php echo $view->module; ?>" />
      		<input type="hidden" name="Controller" value="<?php echo $view->controller; ?>" />
      		<input type="hidden" name="EditUserId" value="<?php echo $view->editUser->GetUserId(); ?>" />      
      		
      				            
      		<input type="text" name="Keyword" value="" size="20" />
      		<button type="submit" name="Action" value="addKeyword">Legg til s&oslash;keord</button>
			
			 
			 <?php 
			 $keywords = $view->editUser->GetKeywords();
			 foreach($keywords as $keyword){ ?>
			
      			<div><input type="checkbox" name="KeywordIds[<?php echo $keyword->GetId(); ?>]" />&nbsp;&nbsp;"<?php echo $keyword->GetKeyword(); ?>"</div>
            <?php }?>
             <button type="submit" name="Action" value="deleteSelectedKeywords">Slett valgte s&oslash;keord</button>
            
      	</fieldset>
      </form>      
      
      
	</div>
    <div id="right">	  
      <form action="" method="post">
        <fieldset>
        <legend>Personlig informasjon:</legend>
         	<?php if($view->user->GetGroup() == 'Admin'):?>
         	 <label>Gruppe:</label><br />
          	<select name="Group">
          		<option <?php if($view->editUser->GetGroup() == 'User') echo ' selected="selected" ';?> value="User">Bruker</option>
          		<option <?php if($view->editUser->GetGroup() == 'Moderator') echo ' selected="selected" ';?> value="Moderator">Moderator</option>
          		<option <?php if($view->editUser->GetGroup() == 'Admin') echo ' selected="selected" ';?> value="Admin">Administrator</option>
           	</select>
           	<br />
          <?php endif; ?>
        
        
          <label>Brukernavn:</label> <?php echo $view->editUser->GetUsername();?><br />
          <label>Fornavn:</label>
	  <br />
          <input type="text" name="GivenName" value="<?php echo $view->editUser->GetGivenName();?>" size="20" maxlength="30" />
	  <br />
          <label>Mellomnavn: </label>
	  <br />
          <input type="text" name="AdditionalName" value="<?php echo $view->editUser->GetAdditionalName();?>" size="20" maxlength="30" />
	  <br />
          <label>Etternavn: </label>
	  <br />
          <input type="text" name="FamilyName" value="<?php echo $view->editUser->GetFamilyName();?>" size="20" maxlength="30" />
	  <br />
          <label>E-post: </label>
	  <br />
	        
	        <?php if($view->detailsFormWasSubmitted && $view->detailsForm['Email']['Error']) echo '<span class="FormError">'.$view->detailsForm['Email']['ErrorMessage'].':'.$view->detailsForm['Email']['Value'].'</span><br />';?>
	  
          <input type="text" name="Email" value="<?php echo $view->editUser->GetEmail();?>" size="35" maxlength="100" />
	  <br />
          <label>Kj&oslash;nn: </label>
	  <br />
          <select name="Gender">
            <option <?php if($view->editUser->GetGender() == "Female") echo 'selected="selected"';?> value="Female">Hun</option>
            <option <?php if($view->editUser->GetGender() == "Male") echo 'selected="selected"';?> value="Male">Han</option>
            <option <?php if($view->editUser->GetGender() == "Unknown") echo 'selected="selected"';?> value="Unknown">Hemmelig</option>
          </select>
	  <br />
          <label>F&oslash;dselsdag: </label>
	  <br />
          <input type="text" name="Birthday" value="<?php echo $view->editUser->GetBirthday();?>" size="20" />
	  <br />
          
          <input type="submit" value="Lagre detaljer" name="Update" />
            <input type="hidden" name="EditUserId" value="<?php echo $view->editUser->GetUserId(); ?>" />
          
            <input type="hidden" name="Module" value="<?php echo $view->module; ?>" />
      		<input type="hidden" name="Controller" value="<?php echo $view->controller; ?>" />
      		<input type="hidden" name="Action" value="saveDetails" />
      	
      	     <div><label>Medlem av gruppe: </label><?php echo $view->editUser->GetGroup(); ?></div>
      	     <div><label>Registrert siden: </label><?php echo $view->editUser->GetRegisterDate(); ?></div>
      	     <div><label>Antall innlogginger: </label><?php echo $view->editUser->GetNumberOfLogins(); ?></div>
      	     <div><label>Sist innlogget: </label><?php echo $view->editUser->GetLastLoginDate(); ?></div>
      	     
      	     
        </fieldset>
      </form>
      
      <form action="" method="post">
      	<fieldset>
      		<legend>Adresser</legend>
      	

      		<?php  
    		foreach($view->editUser->GetAddresses() as $address)
    		{
    			echo '<div>'.$address->GetLabel().'&nbsp;&nbsp;&nbsp;<a href="?Module='.$view->module.'&Controller='.$view->controller.'&Action=deleteAddress&AddressId='.$address->GetId().'&EditUserId='.$view->editUser->GetUserId().'">[x] Slett denne adressen</a></div>';
    			echo $address->ToHtmlForm();
    		}
    		if($view->requestedAddAddress)
    			echo '<div>'.Address::ToHtmlCreateForm().'</div>';
    		else
    			echo '<br /><a href="?Module='.$view->module.'&Controller='.$view->controller.'&Action=requestAddAddress&EditUserId='.$view->editUser->GetUserId().'">Legg til adresse</a><br />';
      	
			?>
			
		  	<button type="submit" name="Action" value="saveAddresses">Lagre adresser</button>
		    <?php if($view->requestedAddAddress): ?>
		   		<button type="submit" name="Action" value="index">Avbryt</button>
		    <?php endIf; ?>
            
            <input type="hidden" name="EditUserId" value="<?php echo $view->editUser->GetUserId(); ?>" />      
            <input type="hidden" name="Module" value="<?php echo $view->module; ?>" />
      		<input type="hidden" name="Controller" value="<?php echo $view->controller; ?>" />
      		
      	
      	</fieldset>
      	</form>
      	
      	
    </div>
  </div>
  <div id="login">
       <form action="/news/public_html/index.php" method="post">
      <fieldset>
        <legend>Velkommen: <?php echo $view->user->GetGivenName().' '.$view->user->GetFamilyName();?></legend>
                  <label>Gruppe:</label> <?php echo $view->user->GetGroup();?><br />
          <label>Registrert siden:</label> <?php echo $view->user->GetRegisterDate();?><br />
          <label>Antall innlogginger:</label> <?php echo $view->user->GetNumberOfLogins();?><br />
        <div><a href="/news/public_html">G&aring; til forsiden</a></div>
        <input type="submit" value="Logg ut" name="Logout" />
      	<input type="hidden" name="Module" value="user" />
      	<input type="hidden" name="Controller" value="login" />
      	<input type="hidden" name="Action" value="logout" />
      </fieldset>
    </form>
  </div>
  
  <?php if ($view->user->GetGroup() == 'Admin'):?>
  <div id="adminActions"><h2>Administrasjon</h2>
      <a href="register.php">Legg til ny bruker</a>
      <form action="" method="post">
          <fieldset>
            <legend>Endre eksisterende bruker:</legend>
       		<input type="hidden" name="Module" value="user" />
   	  		<input type="hidden" name="Controller" value="login" />
    
             <select name="EditUserId">
                         	 <option value="0" selected="selected">-- Velg bruker --</option>
             
             <?php 
             	$users = $view->GetAllUsers(); 
             	foreach($users as $user)
             		echo '<option value="'.$user->GetUserId().'">'.$user->GetUsername().' - '.$user->GetGivenName().' '.$user->GetFamilyName().'</option>';
             	?>
             </select>     
      	<button type="submit" name="Action" value="index">Endre bruker</button>
      </fieldset>
    </form>
  </div>
  <?php endif;?>
  
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
