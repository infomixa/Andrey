<?php

define('ZWS_ID','X1-ZWz1frys6avsp7_1651t');

$activeForms = [34]; // add the active (step 2) forms here

add_action('gform_pre_submission', 'pre_submission_zillow');

function check_form_id($form) {
	if (!in_array($form['id'], $activeForms)) {
		return;
	}
	pre_submission_zillow($form);
}

function pre_submission_zillow($form) {

	$addrStreet = $_POST['input_2'];
	$citstat = $_POST['input_3'];

	$data = getDeepSearchResults($addrStreet,$citstat);

	if ($data) {

		$_POST['input_4'] = $data['bedr'];
		$_POST['input_5'] = $data['bath'];
		$_POST['input_6'] = $data['sftot'];
		$_POST['input_7'] = $data['zestimate'];
		$_POST['input_9'] = $data['lastSoldDate'];
		$_POST['input_10'] = $data['lastSoldPrice'];
		$_POST['input_11'] = $data['low'];
		$_POST['input_12'] = $data['high'];

	}else {
		return;
	}

}

function getDeepSearchResults($streetAddress,$citystatezip) {
	
	$search = 'https://www.zillow.com/webservice/GetDeepSearchResults.htm?zws-id='. ZWS_ID .'&address=' . urlencode($streetAddress) . '&citystatezip=' . urlencode($citystatezip);

	$doc = new DOMDocument();
	$doc->load($search);

	$xpath = new DOMXpath($doc);

	$status_code = trim($xpath->query("//code")->item(0)->nodeValue, " ");
	if (in_array($status_code,["502","507","508"])) {
		return;
	}elseif (in_array($status_code,["1","2","3","4","500","501","503","504","505","506"])) {
		return;
	}

	if ($xpath->query("//amount")->length == 1) {
		$zestimate = $xpath->query("//amount")->item(0)->nodeValue;
	}else {
		$zestimate = '';
	}

	if ($xpath->query("//bedrooms")->length == 1) {
		$bedrooms = $xpath->query("//bedrooms")->item(0)->nodeValue;
	}else {
		$bedrooms = '';
	}

	if ($xpath->query("//bathrooms")->length == 1) {
		$bathrooms = $xpath->query("//bathrooms")->item(0)->nodeValue;
	}else {
		$bathrooms = '';
	}

	if ($xpath->query("//finishedSqFt")->length == 1) {
		$finishedSqFt = $xpath->query("//finishedSqFt")->item(0)->nodeValue;
	}else {
		$finishedSqFt = '';
	}

	if ($xpath->query("//lotSizeSqFt")->length == 1) {
		$lotSizeSqFt = $xpath->query("//lotSizeSqFt")->item(0)->nodeValue;
	}else {
		$lotSizeSqFt = '';
	}

	if ($xpath->query("//yearBuilt")->length == 1) {
		$yearBuilt = $xpath->query("//yearBuilt")->item(0)->nodeValue;
	}else {
		$yearBuilt = '';
	}

	if ($xpath->query("//zpid")->length == 1) {
		$zpid = $xpath->query("//zpid")->item(0)->nodeValue;
	}else {
		$zpid = '';
	}
	
	if ($xpath->query("//lastSoldDate")->length == 1) {
		$lastSoldDate = $xpath->query("//lastSoldDate")->item(0)->nodeValue;
	}else {
		$lastSoldDate = '';
	}
	
	if ($xpath->query("//lastSoldPrice")->length == 1) {
		$lastSoldPrice = $xpath->query("//lastSoldPrice")->item(0)->nodeValue;
	}else {
		$lastSoldPrice = '';
	}
	
	if ($xpath->query("//low")->length == 1) {
		$low = $xpath->query("//low")->item(0)->nodeValue;
	}else {
		$low = '';
	}
	
	if ($xpath->query("//high")->length == 1) {
		$high = $xpath->query("//high")->item(0)->nodeValue;
	}else {
		$high = '';
	}
	

	return [
		'zestimate' => $zestimate,
		'bedr' => $bedrooms,
		'bath' => $bathrooms,
		'sftot' => $finishedSqFt,
		'lot' => $lotSizeSqFt,
		'year' => $yearBuilt,
		'zpid' => $zpid,
		'lastSoldDate' => $lastSoldDate,
		'lastSoldPrice' => $lastSoldPrice,
		'low' => $low,
		'high' => $high
	];

}
