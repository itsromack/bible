<?php
include_once('config.php');
include_once('BibleDAO.php');

$keyword = (isset($_GET['keyword'])) ? $_GET['keyword']: false;
$result = BibleDAO::search($keyword);

if ($result == false) {
	echo json_encode(
			array(
				'status' => 'failed',
				'message' => 'No word or phrase found'
			)
		);
} else {
	echo json_encode(
			array(
				'status' => 'success',
				'result' => $result
			)
		);
}