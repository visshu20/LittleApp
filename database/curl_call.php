<?php

    function curlcall($url,$content){
	
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
            $json_response = curl_exec($curl);
            $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            //if ( $status != 200 ) { die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));}
            curl_close($curl);
            //var_dump("here ::". $json_response."Type:".gettype($json_response)); var_dump("eqs:".$json_response->message);
            $response = json_decode($json_response, true);
            //echo 'Res Type:'.gettype($response); echo 'Res[0] Type:'.gettype($response['message']);echo "val:".$response['message'];
            return $response;
        
    }
?>


