<?php

function json($code='1', $msg='success'){
	$data['code']     = $code;
	$data['message']  = $msg;
	echo json_encode($data, JSON_UNESCAPED_UNICODE);
}

json();