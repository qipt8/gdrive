<?php
require __DIR__ . '/vendor/autoload.php';
use \Marxvn\gdrive;

$gdrive = new gdrive;

$gdrive->getLink('LINK_GOOGLE_DRIVE');

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Videojs</title>
	<link href="http://vjs.zencdn.net/5.11.9/video-js.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/videojs-resolution-switcher/0.4.2/videojs-resolution-switcher.css" rel="stylesheet">

	<!-- If you'd like to support IE8 -->
	<script src="http://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
</head>
<body>
	<video id="videojs_id" class="video-js" controls preload="auto">
		<p class="vjs-no-js">
			To view this video please enable JavaScript, and consider upgrading to a web browser that
			<a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
		</p>
	</video>
	<script type="text/javascript">
		videojs('videojs_id', {
	        width: "640",
	        height: "360",
	        autoplay: true,
	        language: "vi",
	        sources: <?php echo $gdrive->getSources();?>,
	        plugins: {
	            videoJsResolutionSwitcher: {
	                default: '360p',
	                dynamicLabel: true
	            }
	        }
	    });
	</script>
</body>
</html>