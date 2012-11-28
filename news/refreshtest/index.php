<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script> 
<script> 
var auto_refresh = setInterval(
function()
{
$('#loaddiv').fadeOut('slow').load('reload.php').fadeIn("slow");
}, 20000);
</script>

<div id="loaddiv"> 
</div>