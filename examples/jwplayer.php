<?php
require __DIR__ . '../vendor/autoload.php';
use \Marxvn\gdrive;

$gdrive = new gdrive;

$gdrive->getLink('LINK_GOOGLE_DRIVE');

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Jwplayer</title>
</head>
<body>
	<div id='player'></div>

	<script type='text/javascript'>
		jwplayer.key='your_jwp_key';
		var playerInstance = jwplayer(player);
		playerInstance.setup({
			sources: <?php echo $gdrive->getSources('jwplayer');?>,
			width: '100%',
		    height: '100%',
		    aspectratio: '16:9',
		    fullscreen: 'true', 
			autostart: 'true',	
		});
	</script>
</body>
</html>