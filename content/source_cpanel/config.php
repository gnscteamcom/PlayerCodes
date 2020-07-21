<?php 

	/**
	 * CPanel Configuration
	**/

	//Secret key for CPanel
	$secret_key = 'admin';

	//Domain configuration
	$currentDomain = ( (isset($_SERVER['HTTPS']) || ($_SERVER['SERVER_PORT'] == 443) ) ? "https" : "http") . "://" . $_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF']);

	/**
	 * Host configuration
	**/
	
	//Google Drive Proxy configuration
	$proxyDomain = 'https://proxy.apicodes.ml';

	//SoundCloud configuration
	$client_id = '95f22ed54a5c297b1c41f72d713623ef';
	
	//Core
	include_once 'curl.php';

	include_once 'library.php';

	include_once 'packer.php';

	include_once 'unpacker.php';


?>