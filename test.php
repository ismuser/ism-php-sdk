<html>
<head><title>Pimba</title></head>
<body>
<?php
	require 'IsmuserSDK.php';
	$API_KEY = '123456789'; // Enter your API KEY
	$API_SECRET = '0123456789abcdefg'; // Enter your API SECRET

	$sdk = new IsmuserSDK($API_KEY, $API_SECRET);
	$room = $sdk->createRoom();
	echo 'RoomID: ' . $room->getRoomID();
?>
</body>
</html>