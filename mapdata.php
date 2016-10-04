<?php                                                             
    // Defining the basic cURL function
    function curl($url) {
        $ch = curl_init();  // Initialising cURL
        curl_setopt($ch, CURLOPT_URL, $url);    // Setting cURL's URL option with the $url variable passed into the function
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); // Setting cURL's option to return the webpage data
        $data = curl_exec($ch); // Executing the cURL request and assigning the returned data to the $data variable
        curl_close($ch);    // Closing cURL
        return $data;   // Returning the data from the function
    }                                   
?>
<?php
	

	 set_time_limit(0);

	if (ob_get_level() == 0) ob_start();
	$str = file_get_contents("mapdata.json");
	$json = json_decode($str, true);
	$baseUrl = "https://code.highcharts.com/mapdata/";
	$baseFileUrl = "mapdata/";
	foreach($json as $val1){
		foreach($val1 as $val2){
			print_r($val2);
			$dir = explode('/', $val2);
			array_pop($dir);
			$dir_str = implode('/',$dir);
			echo "<br/>";
			$dir_str = $baseFileUrl.$dir_str;
			print_r($dir_str);
			if(!is_dir($dir_str)) {
				mkdir($dir_str);
		    }
			$file = fopen($baseFileUrl.$val2,"w");
			$pageUrl = $baseUrl.$val2;
			print_r($pageUrl);
			$js_file = curl($pageUrl);
			print_r($js_file);
			ob_flush();
			flush();
			fwrite($file,$js_file);
			fclose($file);
			echo "<br/>";
		}
		echo "<br/>";
	}
	ob_end_flush();
    //State Page End
 ?>