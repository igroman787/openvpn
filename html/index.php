<!-- Styles -->
<style>

@font-face {
	font-family: "Anonymous Pro";
	src: url("includes/fonts/Anonymous Pro.ttf");
}

html {
	background-image: url("http://schistory.space/includes/seamless-background-wall.png");
	background-repeat: repeat;
	font-family: "Anonymous Pro";
	font-size: large;
}

table {
	margin-right: 15px;
	background-color: rgba(166, 255, 112, 0.88);
}

tr:hover {
	background-color: #e8e8e8;
}

th, td {
	padding-left: 5px;
	padding-right: 5px;
}

form {
	padding: 0;
	margin: 0;
}

input {
	padding: 0;
	margin: 0;
}

.button {
	color:#000000;
	background:#adfb7d;
	border:solid 1px #004F72;
}

.inputtext {
	background: rgb(220, 220, 220);
}

.offline {
	background: #ff000054;
}

</style>

<?php
	/**
	 * Главная программа
	 */
	$openvpn_ipp = file_get_contents('/var/log/openvpn/ipp.txt');
	$openvpn_status = file_get_contents('/var/log/openvpn/openvpn-status.log');
	$openvpn_status_list = preg_split("/\n|,/", $openvpn_status);
	
	$lines = explode("\n", $openvpn_ipp);
	$lines = array_filter($lines);
	
	echo('<link rel="icon" href="http://schistory.space/favicon.ico">');
	
	echo('<table border="1">');
	echo('<thead>');
	echo('<tr>');
	echo('<th>IP-адрес</th>');
	echo('<th>Имя устройства</th>');
	echo('<th>Комментарий</th>');
	echo('<th>Статус</th>');
	echo('</tr>');
	echo('</thead>');
	echo('<tbody>');
	
	foreach ($lines as &$line)
	{
		$arr = explode(",", $line);
		$name = $arr[0];
		$ip = $arr[1];
		$status = "<font color='red'>Offline</font>";
		$trClassName = "offline";
		if (in_array($name, $openvpn_status_list))
		{
			$status = "<font color='green'>Online</font>";
			$trClassName = "online";
		}
		if (empty($_COOKIE[$name]))
		{
			$comment = "<form action='setcookie.php'> <input type='text' name='$name' class='inputtext'> <input type='submit' class='button' value='изменить'>";
		}
		else
		{
			$commentText = $_COOKIE[$name];
			$comment = "<form action='setcookie.php'> <input type='text' name='$name' class='inputtext' value='$commentText'> <input type='submit' class='button' value='изменить'>";
		}
		
		echo("<tr class='$trClassName'>");
		echo('<td>' . $ip . '</td>');
		echo('<td>' . $name . '</td>');
		echo('<td>' . $comment . '</td>');
		echo('<td>' . $status . '</td>');
		echo('</tr>');
	}
	
	echo('</tbody>');
	echo('</table>');
	
	
	/**
	 * Дополнительные функции
	 */
	function vardump($var)
	{
		echo '<pre>';
		var_dump($var);
		echo '</pre>';
	}
?>
