<html>
<head><title>Ismuser PHP SDK - Test page</title></head>
<body>
<?php
	require 'IsmuserSDK.php';
	$API_KEY = '1234'; // Enter your API KEY
	$API_SECRET = '1234'; // Enter your API SECRET
	$roomProperties = array(
		"videoconference_mod" => true,
		"magicboard_mod" => true,
		"chat_mod" => true,
		"debug" => false,
	);

	$sdk = new IsmuserSDK($API_KEY, $API_SECRET);
	$room = $sdk->createRoom($roomProperties);

	echo 'RoomID: ' . $room->getRoomID() . '<br/>';
	echo 'Room properties: ';	var_dump($room->getPermissions()); echo '<br/>';
	echo 'Debug: '; var_dump($room->isDebug()); echo '<br/>';
?>
</body>
</html>