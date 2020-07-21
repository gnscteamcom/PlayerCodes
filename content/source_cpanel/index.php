<?php 
/**
 * Name: APICodes CPanel
 * Version: 1.0, Last updated: June 30, 2020
 * Website: https://apicodes.com
 * Contact: Support@apicodes.com
 */ 
?>
<?php include_once 'config.php'; global $secret_key, $currentDomain; ?>
<?php if (isset($_GET['login']) && $_GET['login'] == $secret_key): ?>
<!DOCTYPE html>
<html>
<head>
	<title>APICodes CPanel</title>
	<link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" type="text/css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" type="text/css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.1.1/css/fileinput.min.css" type="text/css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.1.1/themes/explorer-fas/theme.min.css" type="text/css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.css" type="text/css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.buttons.css" type="text/css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.brighttheme.css" type="text/css" />
	<link rel="stylesheet" type="text/css" href="assets/css/main.min.css">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.1.1/js/fileinput.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.1.1/themes/explorer-fas/theme.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.buttons.js"></script>
	<script type="text/javascript" src="assets/js/main.min.js"></script>
</head>
<body>

	<header>
	  <div class="bg-dark collapse" id="navbarHeader" style="">
	    <div class="container">
	      <div class="row">
	        <div class="col-sm-8 col-md-7 py-4">
	          <h4 class="text-white">About</h4>
	          <p class="text-muted">APICodes CPanel is a powerful tool that helps you encrypt streaming links so no one can steal it. This tool supports creating streaming links on 20 websites with multiple subtitles. You can use the link or iframe after encryption into your website easily and quickly.</p>
	        </div>
	        <div class="col-sm-4 offset-md-1 py-4">
	          <h4 class="text-white">Contact</h4>
	          <ul class="list-unstyled">
	            <li><a href="#" class="text-white">Follow on Twitter</a></li>
	            <li><a href="#" class="text-white">Like on Facebook</a></li>
	            <li><a href="#" class="text-white">Email me</a></li>
	          </ul>
	        </div>
	      </div>
	    </div>
	  </div>
	  <div class="navbar navbar-dark bg-dark shadow-sm">
	    <div class="container d-flex justify-content-between">
	      <a href="<?php echo "http" . (($_SERVER['SERVER_PORT'] == 443) ? "s" : "") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" class="navbar-brand d-flex align-items-center">
	        <img src="assets/images/logo-header.png" alt="APICodes CPanel" class="img-fluid mw-186">
	      </a>
	      <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="navbar-toggler-icon"></span>
	      </button>
	    </div>
	  </div>
	</header>

	<main role="main">
		<section class="jumbotron text-center">
		    <div class="container">
		      <h1 class="jumbotron-heading">APICodes CPanel</h1>
		      <p class="lead text-muted">A powerful tool that helps you encrypt streaming links so no one can steal it. This tool supports creating streaming links on 20+ websites with multiple subtitles. You can use the link or iframe after encryption into your website easily and quickly.</p>
		      <p>
		        <a href="javascript:void(0);" id="try_now" class="btn btn-primary my-2">👌 Try now!</a>
		        <a href="javascript:void(0);" id="supported_sites" class="btn btn-secondary my-2"><i class="fas fa-list-alt fa-fw"></i> Supported Sites</a>
		      </p>
		    </div>
		</section>
		
		<section>

			<div class="container bg-light apicodes-box">
			     
				<form id="action-form" action="action.php" method="POST" accept-charset="utf-8">
					<div class="form-group">
						<label class="font-weight-500">Link:</label>
						<input type="text" name="link" class="form-control" placeholder="Put your link here..." onclick="this.select()" required>
					</div>

					<div class="form-group">
						
						<div id="sub" class="mb-3">
							<div id="sub-block">
								<div class="row">

							    <div class="col-md-3">
							        <div class="form-group m-0">
							        	<label class="font-weight-500">Closed Captions:</label>
										<select data-placeholder="Choose a Language..." name="caption[]" class="form-control">
										  <option value="Afrikaans">Afrikaans</option>
										  <option value="Albanian">Albanian</option>
										  <option value="Arabic">Arabic</option>
										  <option value="Armenian">Armenian</option>
										  <option value="Basque">Basque</option>
										  <option value="Bengali">Bengali</option>
										  <option value="Bulgarian">Bulgarian</option>
										  <option value="Catalan">Catalan</option>
										  <option value="Cambodian">Cambodian</option>
										  <option value="Chinese (Mandarin)">Chinese (Mandarin)</option>
										  <option value="Croatian">Croatian</option>
										  <option value="Czech">Czech</option>
										  <option value="Danish">Danish</option>
										  <option value="Dutch">Dutch</option>
										  <option value="English" selected>English</option>
										  <option value="Estonian">Estonian</option>
										  <option value="Fiji">Fiji</option>
										  <option value="Finnish">Finnish</option>
										  <option value="French">French</option>
										  <option value="Georgian">Georgian</option>
										  <option value="German">German</option>
										  <option value="Greek">Greek</option>
										  <option value="Gujarati">Gujarati</option>
										  <option value="Hebrew">Hebrew</option>
										  <option value="Hindi">Hindi</option>
										  <option value="Hungarian">Hungarian</option>
										  <option value="Icelandic">Icelandic</option>
										  <option value="Indonesian">Indonesian</option>
										  <option value="Irish">Irish</option>
										  <option value="Italian">Italian</option>
										  <option value="Japanese">Japanese</option>
										  <option value="Javanese">Javanese</option>
										  <option value="Korean">Korean</option>
										  <option value="Latin">Latin</option>
										  <option value="Latvian">Latvian</option>
										  <option value="Lithuanian">Lithuanian</option>
										  <option value="Macedonian">Macedonian</option>
										  <option value="Malay">Malay</option>
										  <option value="Malayalam">Malayalam</option>
										  <option value="Maltese">Maltese</option>
										  <option value="Maori">Maori</option>
										  <option value="Marathi">Marathi</option>
										  <option value="Mongolian">Mongolian</option>
										  <option value="Nepali">Nepali</option>
										  <option value="Norwegian">Norwegian</option>
										  <option value="Persian">Persian</option>
										  <option value="Polish">Polish</option>
										  <option value="Portuguese">Portuguese</option>
										  <option value="Punjabi">Punjabi</option>
										  <option value="Quechua">Quechua</option>
										  <option value="Romanian">Romanian</option>
										  <option value="Russian">Russian</option>
										  <option value="Samoan">Samoan</option>
										  <option value="Serbian">Serbian</option>
										  <option value="Slovak">Slovak</option>
										  <option value="Slovenian">Slovenian</option>
										  <option value="Spanish">Spanish</option>
										  <option value="Swahili">Swahili</option>
										  <option value="Swedish ">Swedish </option>
										  <option value="Tamil">Tamil</option>
										  <option value="Tatar">Tatar</option>
										  <option value="Telugu">Telugu</option>
										  <option value="Thai">Thai</option>
										  <option value="Tibetan">Tibetan</option>
										  <option value="Tonga">Tonga</option>
										  <option value="Turkish">Turkish</option>
										  <option value="Ukrainian">Ukrainian</option>
										  <option value="Urdu">Urdu</option>
										  <option value="Uzbek">Uzbek</option>
										  <option value="Vietnamese">Vietnamese</option>
										  <option value="Welsh">Welsh</option>
										  <option value="Xhosa">Xhosa</option>
										</select>
							        </div>
							    </div>

							    <div class="col-md-7">
							        <div class="form-group m-0">
							        	<label class="font-weight-500">Subtitle:</label>
							        	<input type="text" class="form-control" id="sub" name="sub[]" value="" placeholder="Ex: https://demo.apicodes.com/the.boss.baby.srt (optional)" onclick="this.select()"> 
							        </div>
							    </div>

							    <div class="col-md-1">
							        <div class="form-group m-0">
							        	<label class="font-weight-500">Upload:</label>
							        	<input id="subFile" name="subFile[]" type="file" accept=".srt, .vtt" class="btn btn-info btn-block" data-show-preview="false">
							        </div>
							    </div>
							    
							    <div class="col-md-1" style="margin-top: 32px">
							    	<button type="button" id="add_new_sub" data-total="1" class="btn btn-success btn-block"><i class="fas fa-plus"></i></button>
								</div>
							</div>
						</div>

					</div>

					<div class="form-group">
						<label class="font-weight-500">Poster:</label>
						<input type="text" name="poster" class="form-control" placeholder="Ex: https://demo.apicodes.com/the-boss-baby-poster.jpg (optional)" onclick="this.select()">
					</div>

					<div class="form-group">
						<label class="control-label font-weight-bold text-secondary" for="download_button">
							<input type="checkbox" name="button" id="download_button"> Show Download Button
						</label>

						<button type="submit" id="action_submit" class="btn btn-lg btn-primary btn-block"> <span id="fa_loading"><i class="fas fa-chevron-circle-right"></i></span> Generate</button>
					</div>
				</form>
				
				<div class="form-group">
					<label class="font-weight-500">Your link has been encrypted, no one can steal it. Just copy and paste the code below into your website.</label>
					<input type="text" id="link_encrypted" placeholder="The encrypted link will be displayed here..." class="form-control" onclick="this.select()">
				</div>

				<div class="form-group">
					<label class="font-weight-500">Your link with the Iframe has been encrypted, no one can steal it. Just copy and paste the code below into your website.</label>
					<textarea rows="5" class="form-control" id="iframe_encrypted" placeholder="The encrypted link with Iframe will be displayed here..." onclick="this.select()"></textarea>
				</div>
				
				<script type="text/javascript">
					jQuery(function ($) {
						$('#action-form').submit(function(e) {
							e.preventDefault();
							$('#action_submit').prop('disabled', !0);
							$('#fa_loading').html('<i class="fa fa-spinner fa-spin"></i>');
				       		var b = $(this).serializeArray(), c = $(this).attr('action');
							$.ajax({
						        type: 'POST',
						        dataType: 'text',
						        url: c,
						        data: b,
								error: function (result) {
									alert("Something went wrong. Please try again!");
									$('#fa_loading').html('<i class="fa fa-arrow-circle-right"></i>');
									$('#action_submit').removeAttr('disabled');
								},
								success: function (result) {
									$('#link_encrypted').val('<?php echo $currentDomain . '/embed.php?data=' ?>'+result+'');
									$('#iframe_encrypted').html('<iframe src="<?php echo $currentDomain . '/embed.php?data=' ?>'+result+'" width="100%" height="100%" frameborder="0" allowfullscreen></iframe>');
									$('#fa_loading').html('<i class="fa fa-arrow-circle-right"></i>');
									$('#action_submit').removeAttr('disabled');
								}
							});
						});
					});
				</script>
			</div><!-- /.container -->

		</section>

		<section>
			<div class="container my-3 sites">
				
				<div class="card bg-light text-dark">
				  <div class="card-header">⚡ Supported Sites</div>

				  <div class="card-body table-responsive">

				  	<div class="card-content mb-2">This tool supports creating streaming links on 20+ websites listed below. We are always developing to support more websites in the future. If the site you want to use is not listed below. Please don't hesitate to contact us. We will consider integrating into APICodes CPanel as we can.</div>

				  	<table class="table table-bordered table-hover">
				  		<thead class="thead-dark">
				  			<tr>
				  				<th>Favicon</th>
				  				<th>Host</th>
				  				<th>Status</th>
				  				<th>Link Format</th>
				  			</tr>
				  		</thead>
				  		<tbody>

				  			<tr>
				  				<td><img src="assets/images/favicon/amazon.png" alt="Amazon Drive"></td>
				  				<td>Amazon Drive</td>
				  				<td><span class="badge badge-success">Working</span></td>
				  				<td><input type="text" class="form-control" value="https://www.amazon.com/clouddrive/share/WLtmBIRgu7zFBdazabVBoBn5t4woYIKWWaWCO7X4NWs" readonly></td>
				  			</tr>

				  			<tr>
				  				<td><img src="assets/images/favicon/archive.png" alt="Archive"></td>
				  				<td>Archive</td>
				  				<td><span class="badge badge-success">Working</span></td>
				  				<td><input type="text" class="form-control" value="https://archive.org/details/The.Boss.Baby.Trailer" readonly></td>
				  			</tr>

				  			<tr>
				  				<td><img src="assets/images/favicon/blogger.png" alt="Blogger"></td>
				  				<td>Blogger</td>
				  				<td><span class="badge badge-success">Working</span></td>
				  				<td>
				  					<input type="text" class="form-control" value="https://www.blogger.com/video.g?token=AD6v5dxLUF8lLUrUQt0dzhaEA6jiQYRHoc81ATfR3kvbKFlNm5iNGGRxqFoxyzwLoek-IOx5SE1l89GTdVkjxEhSzaOSh6mpH0C_1rNEWkRlletN64HRbOW00kvCkLXgOe6lzP6Ze5M" readonly>
				  					<p class="mb-0 text-center">OR</p>
				  					<input type="text" class="form-control" value="https://helloplayer2020.blogspot.com/2020/04/tbbb.html" readonly>
				  				</td>
				  			</tr>

				  			<tr>
				  				<td><img src="assets/images/favicon/facebook.png" alt="Facebook"></td>
				  				<td>Facebook</td>
				  				<td><span class="badge badge-success">Working</span></td>
				  				<td><input type="text" class="form-control" value="https://www.facebook.com/thebossbaby/videos/1823982841164550/" readonly></td>
				  			</tr>

				  			<tr>
				  				<td><img src="assets/images/favicon/drive.png" alt="Google Drive"></td>
				  				<td>Google Drive</td>
				  				<td><span class="badge badge-success">Working</span></td>
				  				<td><input type="text" class="form-control" value="https://drive.google.com/file/d/0BwHxX3yoJoeuYzZlNm1jYVhwWWs/view" readonly></td>
				  			</tr>

				  			<tr>
				  				<td><img src="assets/images/favicon/photos.png" alt="Google Photos"></td>
				  				<td>Google Photos</td>
				  				<td><span class="badge badge-success">Working</span></td>
				  				<td>
				  					<input type="text" class="form-control" value="https://photos.app.goo.gl/C7Rv3EbKjyq32oKA8" readonly>
									<p class="mb-0 text-center">OR</p>
				  					<input type="text" class="form-control" value="https://photos.google.com/share/AF1QipMzQ6rOgZdsM0O7_68pxVqBLd3RIDCFXYxZhP_EgrGWt5a8ohgVfwL1bz2HJ4YU4w/photo/AF1QipN6Q_ofiK5UBHgmMlPzsWB760E6ofYDu0v4M0rr?key=c2lUUUNsQlpnbk5ZajlZRFp1MFFxRFo3QnNtQjZB" readonly>
				  				</td>
				  			</tr>

				  			<tr>
				  				<td><img src="assets/images/favicon/m3u8.png" alt="M3U8 (HLS)"></td>
				  				<td>M3U8 (HLS)</td>
				  				<td><span class="badge badge-success">Working</span></td>
				  				<td><input type="text" class="form-control" value="https://demo.apicodes.com/video.m3u8" readonly></td>
				  			</tr>

				  			<tr>
				  				<td><img src="assets/images/favicon/mp4.png" alt="MP4"></td>
				  				<td>MP4</td>
				  				<td><span class="badge badge-success">Working</span></td>
				  				<td><input type="text" class="form-control" value="https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/Sintel.mp4" readonly></td>
				  			</tr>

				  			<tr>
				  				<td><img src="assets/images/favicon/mp4upload.png" alt="MP4Upload"></td>
				  				<td>MP4Upload</td>
				  				<td><span class="badge badge-success">Working</span></td>
				  				<td><input type="text" class="form-control" value="https://www.mp4upload.com/07zev84kg3fb" readonly></td>
				  			</tr>

				  			<tr>
				  				<td><img src="assets/images/favicon/mediafire.png" alt="Mediafire"></td>
				  				<td>Mediafire</td>
				  				<td><span class="badge badge-success">Working</span></td>
				  				<td><input type="text" class="form-control" value="https://www.mediafire.com/file/1p1pmxinb322ira/The.Boss.Baby.Trailer.mp4" readonly></td>
				  			</tr>

				  			<tr>
				  				<td><img src="assets/images/favicon/onedrive.png" alt="OneDrive"></td>
				  				<td>OneDrive</td>
				  				<td><span class="badge badge-success">Working</span></td>
				  				<td><input type="text" class="form-control" value="https://1drv.ms/v/s!Av4hddTXHj0DhHMtSwJ1zVUHKoXE" readonly></td>
				  			</tr>

				  			<tr>
				  				<td><img src="assets/images/favicon/rumble.png" alt="Rumble"></td>
				  				<td>Rumble</td>
				  				<td><span class="badge badge-success">Working</span></td>
				  				<td><input type="text" class="form-control" value="https://rumble.com/v3wihl-the-boss-baby-trailer.html" readonly></td>
				  			</tr>

				  			<tr>
				  				<td><img src="assets/images/favicon/soundcloud.png" alt="SoundCloud"></td>
				  				<td>SoundCloud</td>
				  				<td><span class="badge badge-success">Working</span></td>
				  				<td><input type="text" class="form-control" value="https://soundcloud.com/tacomusic/piano-reflections-album" readonly></td>
				  			</tr>

				  			<tr>
				  				<td><img src="assets/images/favicon/streamable.png" alt="Streamable"></td>
				  				<td>Streamable</td>
				  				<td><span class="badge badge-success">Working</span></td>
				  				<td><input type="text" class="form-control" value="https://streamable.com/78q4gj" readonly></td>
				  			</tr>

				  			<tr>
				  				<td><img src="assets/images/favicon/tiktok.png" alt="TikTok"></td>
				  				<td>TikTok</td>
				  				<td><span class="badge badge-success">Working</span></td>
				  				<td><input type="text" class="form-control" value="https://www.tiktok.com/@lyothecat/video/6766975139570633990" readonly></td>
				  			</tr>

				  			<tr>
				  				<td><img src="assets/images/favicon/vimeo.png" alt="Vimeo"></td>
				  				<td>Vimeo</td>
				  				<td><span class="badge badge-success">Working</span></td>
				  				<td><input type="text" class="form-control" value="https://vimeo.com/259411563" readonly></td>
				  			</tr>

				  			<tr>
				  				<td><img src="assets/images/favicon/yandex.png" alt="Yandex"></td>
				  				<td>Yandex</td>
				  				<td><span class="badge badge-success">Working</span></td>
				  				<td><input type="text" class="form-control" value="https://yadi.sk/i/DFNMQ6YZ3MkXqd" readonly></td>
				  			</tr>


				  			<tr>
				  				<td><img src="assets/images/favicon/youtube.png" alt="Youtube"></td>
				  				<td>Youtube</td>
				  				<td><span class="badge badge-success">Working</span></td>
				  				<td><input type="text" class="form-control" value="https://www.youtube.com/watch?v=O2Bsw3lrhvs" readonly></td>
				  			</tr>

				  			<tr>
				  				<td><img src="assets/images/favicon/zippyshare.png" alt="ZippyShare"></td>
				  				<td>Zippyshare</td>
				  				<td><span class="badge badge-success">Working</span></td>
				  				<td><input type="text" class="form-control" value="https://www71.zippyshare.com/v/H6oOxEgL/file.html" readonly></td>
				  			</tr>

				  			<tr>
				  				<td><img src="assets/images/favicon/pcloud.png" alt="pCloud"></td>
				  				<td>pCloud</td>
				  				<td><span class="badge badge-success">Working</span></td>
				  				<td><input type="text" class="form-control" value="https://my.pcloud.com/publink/show?code=XZPWqxkZNXABDVPsX6B5YgsnkrH2rzpGdqck" readonly></td>
				  			</tr>

				  		</tbody>
				  	</table>

				  </div>
				</div>

			</div>
		</section>

	</main>

	<footer class="footer-wrapper mt-5 py-5 text-white bg-dark">
	  
	  <div class="container">
	  	
		  <div class="row">
		    <div class="col-12 col-md text-center">
		      <img src="assets/images/logo-header.png" class="img-fluid mb-4"/>
		      <p class="text-muted mb-4">APICodes CPanel is a powerful tool that helps you encrypt streaming links so no one can steal it. This tool supports creating streaming links on 20+ websites with multiple subtitles. You can use the link or iframe after encryption into your website easily and quickly.</p>
		    </div>
		  </div>

	</div>

		<div class="absolute-footer">
			<div class="container clearfix text-center">
				Copyright <?php echo date("Y"); ?> © <a href="https://apicodes.com/" title="APICodes" target="_blank">APICodes</a>. All rights reserved.
			</div>
		</div>

	</footer>
			
	<script>
		jQuery(document).ready(function() {

			var $el = $('input[type="file"]');
			$el.fileinput({
			    theme: 'explorer-fas',
			    uploadUrl:  "upload.php",
			    maxFileSize: 1024,
			    browseClass: "btn btn-block btn-info",
			    allowedFileExtensions: ["srt", "vtt"],
			    layoutTemplates: {progress: ''},
			    browseLabel: '',
			    browseIcon: '<i class="fas fa-upload"></i>',
			    initialPreviewAsData: true,
			    showCaption: false,
			    showCancel: false, 
				showDrag: false,
				showUpload: false,
				showRemove: false,
			}).on("filebatchselected", function(event, files) {
			    $el.fileinput("upload");
			}).on('fileuploaded', function(event, data, previewId, index) {
				jQuery('input#sub').val(data.response.initialPreview[index]);
				new PNotify({
				  title: 'Success!',
				  text: 'File uploaded successfully.',
				  type: 'success',
				  icon: ''
				});
    		}).on('fileuploaderror', function(event, data, msg) {
				if(data.response) {
					new PNotify({
					  title: 'Error!',
					  text: msg,
					  type: 'error',
					  icon: ''
					});
				}

    		});

		});
	</script>

</body>
</html>

<?php else : ?>

<!DOCTYPE html> <html> <head> <title>404 Not Found</title> <meta name="robots" content="noindex"> </head> <body> <div style="text-align: center;"><p>Silence is golden!</p></div> </body> </html>

<?php endif; ?>