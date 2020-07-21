<?php 

/**
 * Name: APICodes CPanel
 * Version: 1.0, Last updated: June 29, 2020
 * Website: https://apicodes.com
 * Contact: Support@apicodes.com
 */ 

error_reporting(0);
include_once 'library.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	if (isset($_POST['link'])) {
		
		$link = (!empty($_POST['link'])) ? $_POST['link'] : '';

		$poster = (!empty($_POST['poster'])) ? $_POST['poster'] : '';

		$caption = (!empty($_POST['caption'])) ? $_POST['caption'] : '';

		$button = (!empty($_POST['button'])) ? $_POST['button'] : 'off';

		$data = array();
		$data['link'] = trim($link);
		$data['poster'] = trim($poster);
		$data['button'] = trim($button);

		$dataSub = array();
	
		$sub = $_POST['sub'];
		
		foreach ($sub as $key => $value) {
			if ($value != '') {
				$dataSub[$caption[$key]] = trim($value);
			}
		}

		$data['sub'] = $dataSub;
		
		//echo encode($_POST['link']);
		echo encode(json_encode($data));

	} else echo 'Error Isset!';
} else echo 'Error Request!';

?>