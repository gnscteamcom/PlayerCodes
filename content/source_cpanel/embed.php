<?php 
/**
 * Name: APICodes CPanel
 * Version: 1.0, Last updated: June 30, 2020
 * Website: https://apicodes.com
 * Contact: Support@apicodes.com
 */
?>
<!DOCTYPE html>
<html>
<head>
	<title>APICodes Video Player</title>
	<meta name="robots" content="noindex">
	<meta name="referrer" content="no-referrer" />
	<link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon" />
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
	<script type="text/javascript" src="https://ssl.p.jwpcdn.com/player/v/8.8.6/jwplayer.js"></script>
	<script type="text/javascript">jwplayer.key="64HPbvSQorQcd52B8XFuhMtEoitbvY/EXJmMBfKcXZQU2Rnn";</script>
	<style type="text/css" media="screen">html,body{padding:0;margin:0;height:100%}#apicodes-player{width:100%!important;height:100%!important;overflow:hidden;background-color:#000}</style>
</head>
<body>

<?php 
		error_reporting(0);
		
		$data = (isset($_GET['data'])) ? $_GET['data'] : '';

		if ($data != '') {
			
			include_once 'config.php';

			$data = json_decode(decode($data));

			$link = (isset($data->link)) ? $data->link : '';

			$sub = (isset($data->sub)) ? $data->sub : '';

			$button = (isset($data->button)) ? $data->button : '';

			$download_button = '';

			if ( $button == 'on') {

				$download_button .= 'player.addButton(
										"./assets/images/download.svg",
										"Download Video",
										function () {
											var win = window.open(player.getPlaylistItem()["file"],"_blank");
											win.focus();
										},
										"download"
									)';
			};

			$poster = (isset($data->poster)) ? $data->poster : '';

			$tracks = '';
			
			$index = 0; 

			foreach ($sub as $key => $value) {

				$index++;

				$default = ($index == 1) ? 'true' : 'false';

			    $tracks .= '{ 
						        "file": "'.$value.'", 
						        "label": "'.$key.'",
						        "kind": "captions",
						        "default": '.$default.'
							   },';
			};

			$pregAmazonDrive  = preg_match('/(www.?|)amazon.com\/.*/', $link, $match);

			$pregArchive      = preg_match('/(www.?|)archive.org\/.*/', $link, $match);
			
			$pregBlogger      = preg_match('/(www.?|)(blogspot.com|blogger.com)\/.*/', $link, $match);
			
			$pregFacebook     = preg_match('/(www.?|)facebook.com\/.*/', $link, $match);
			
			$pregGoogleDrive  = preg_match('/(www.?|)drive.google.com\/.*/', $link, $match);
			
			$pregGooglePhotos = preg_match('/(www.?|)(photos.google.com|photos.app.goo.gl)\/.*/', $link, $match);
			
			$pregMP4Upload    = preg_match('/(www.?|)mp4upload.com\/.*/', $link, $match);
			
			$pregMediafire    = preg_match('/(www.?|)mediafire.com\/.*/', $link, $match);
			
			$pregOneDrive     = preg_match('/(www.?|)1drv.ms\/.*/', $link, $match);
			
			$pregRumble       = preg_match('/(www.?|)rumble.com\/.*/', $link, $match);
			
			$pregSendSpace    = preg_match('/(www.?|)sendspace.com\/.*/', $link, $match);
			
			$pregSolidfiles   = preg_match('/(www.?|)solidfiles.com\/.*/', $link, $match);
			
			$pregSoundCloud   = preg_match('/(www.?|)soundcloud.com\/.*/', $link, $match);
			
			$pregStreamable   = preg_match('/(www.?|)streamable.com\/.*/', $link, $match);
			
			$pregTikTok       = preg_match('/(www.?|)tiktok.com\/.*/', $link, $match);
			
			$pregVimeo        = preg_match('/(www.?|)vimeo.com\/.*/', $link, $match);
			
			$pregYandex       = preg_match('/(www.?|)yadi.sk\/.*/', $link, $match);
			
			$pregYoutube      = preg_match('/(www.?|)youtube.com\/.*/', $link, $match);
			
			$pregZippyshare   = preg_match('/(www.?|)zippyshare.com\/.*/', $link, $match);
			
			$pregpCloud       = preg_match('/(www.?|)pcloud.com\/.*/', $link, $match);

			switch (true) {

				case $pregAmazonDrive:
						
						$sources = amazon_drive($link);

					break;

				case $pregArchive:
					
						$sources = archive($link);

					break;

				case $pregBlogger:
					
						$sources = blogger($link);

					break;

				case $pregFacebook:
					
						$sources = facebook($link);

					break;

				case $pregGoogleDrive:

						$sources = google_drive($link);
					
					break;

				case $pregGooglePhotos:

						$sources = google_photos($link);
					
					break;

				case $pregMP4Upload:
						
						$sources = mp4upload($link);

					break;

				case $pregMediafire:

						$sources = mediafire($link);
					
					break;

				case $pregOneDrive:
						
						$sources = onedrive($link);

					break;

				case $pregRumble:
						
						$sources = rumble($link);

					break;

				case $pregSoundCloud:

						$sources = soundcloud($link);
					
					break;

				case $pregStreamable:
						
						$sources = streamable($link);

					break;

				case $pregTikTok:
						
						$sources = tiktok($link);

					break;

				case $pregVimeo:
						
						$sources = vimeo($link);

					break;

				case $pregYandex:
						
						$sources = yandex($link);

					break;

				case $pregYoutube:
						
						$sources = youtube($link);

					break;

				case $pregZippyshare:
						
						$sources = zippyshare($link);

					break;

				case $pregpCloud:
						
						$sources = pcloud($link);

					break;
				
				default:
					 $sources = '[{"label":"HD","type":"video\/mp4","file":"https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/Sintel.mp4"}]';
					break;
			}

			$result = '<div id="apicodes-player"></div>';

			$data = 'var player = jwplayer("apicodes-player");
						player.setup({
							sources: '.$sources.',
							cast: {},
							aspectratio: "16:9",
							startparam: "start",
							primary: "html5",
							autostart: false,
							preload: "auto",
							image: "'.$poster.'",
						    captions: {
						        color: "#f3f368",
						        fontSize: 16,
						        backgroundOpacity: 0,
						        fontfamily: "Helvetica",
						        edgeStyle: "raised"
						    },
						    tracks: ['.$tracks.']
						});
						'.$download_button.';
			            player.on("setupError", function() {
			              swal("Server Error!", "Please contact us to fix it asap. Thank you!", "error");
			            });
						player.on("error" , function(){
							swal("Server Error!", "Please contact us to fix it asap. Thank you!", "error");
						});';
			
			$packer = new Packer($data, 'Normal', true, false, true);

			$packed = $packer->pack();

			$result .= '<script type="text/javascript">' . $packed . '</script>';

			echo $result;

		} else echo 'Link not found!';

?>

</body>
</html>
