<?php
	foreach ($_GET as $key => $value)
	{
		setcookie($key, $value, time()+31536000);  /* срок действия 1 год */
	}
	header('Location: index.php');
?>
