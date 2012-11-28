<?php
require_once '../includes/application.start.php';

$login = new View_User_Login();


if(isset($_POST['Login']))
{
	$username = $_POST['Username'];
	$password = $_POST['Password'];
	
	Authenticate::Login($username, $password);

	if(!Authenticate::IsLoggedIn())
	{
		echo "Feil brukernavn eller passord";
	}
}
elseif(isset($_POST['Logout']))
{
	Authenticate::Logout();
}

if(Authenticate::IsLoggedIn())
	$user = UserDBManager::GetUserFromId(Authenticate::GetUserId());
else
	$user = null;
?>

<?php if($user != null):?>
<form action="" method="post">
<fieldset>
<legend>Logg ut</legend>
<input type="submit" value="Logg ut" name="Logout" />
</fieldset>
</form>

<?php else: ?>

<form action="" method="post">
<fieldset>
<legend>Logg inn</legend>
<label>Brukernavn: </label>
<input type="text" value="" name="Username" size="20" />
<label>Passord:</label>
<input type="password" value="" name="Password" size="20" />
<input type="submit" value="Logg inn" name="Login" />
</fieldset>
</form>

<?php endIf; ?>
