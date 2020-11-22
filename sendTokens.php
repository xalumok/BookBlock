<?php
    
    function sendTokens($from, $pass, $to, $amount)
    {
    	$ch = curL_init();
	    $url = "http://127.0.0.1:8001";
	    curl_setopt($ch, CURLOPT_URL, $url);
		$headers[] = "Content-type: application/json";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);

		$json = '{"jsonrpc":"2.0","method":"personal_unlockAccount","params":["'.$from.'", "'.$pass.'", 16],"id":67}';
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

		$res = curl_exec($ch);

		$res = json_decode($res, true);
		if (isset($res["error"]["message"]))
	    	return [false, $res["error"]["message"]];
		if ($res['result'] != true)
		{
			return "Wrong password";
		}

		$json = '{"jsonrpc":"2.0","method":"eth_sendTransaction","params":[{"from": "'.$from.'", "to": "'.$to.'","value": "0x'.dechex($amount).'"}],"id":67}';
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

		$res = curl_exec($ch);

		$res = json_decode($res, true);
	    curl_close($ch);
	    if (isset($res["error"]["message"]))
	    	return [false, $res["error"]["message"]];
	    else
	    	if (isset($res['result']))
	    	return [true, $res['result']];
	    else
	    	return [false, strval($res)];
    }
    

?>