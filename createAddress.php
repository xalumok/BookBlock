<?php
    
    function createAddress($password)
    {
    	$ch = curL_init();
	    $url = "http://127.0.0.1:8001";
	    curl_setopt($ch, CURLOPT_URL, $url);
		$headers[] = "Content-type: application/json";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		$json = '{"jsonrpc":"2.0","method":"personal_newAccount","params":["'.$password.'"],"id":67}';
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

		$res = curl_exec($ch);

		$res = json_decode($res, true);
		$address = $res['result'];

	    curl_close($ch);
	    return $address;
    }
    

?>