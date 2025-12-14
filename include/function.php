<?php
function getIndex($index, $value='')
{
	$data = isset($_GET[$index])? $_GET[$index]:$value;
	return $data;
}

function postIndex($index, $value='')
{
	$data = isset($_POST[$index])? $_POST[$index]:$value;
	return $data;
}

function requestIndex($index, $value='')
{
	$data = isset($_REQUEST[$index])? $_REQUEST[$index]:$value;
	return $data;
}

function input($index, $value = '')
{
    if (isset($_POST[$index])) return $_POST[$index];
    if (isset($_GET[$index]))  return $_GET[$index];
    return $value;
}

function formatMoney($amount) {
    return number_format($amount, 0, ',', '.');
}