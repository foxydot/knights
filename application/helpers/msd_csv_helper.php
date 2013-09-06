<?php
if(!function_exists('parse_csvfile')){
	function parse_csvfile($file,$delimiter=",",$indexrow=TRUE){
		$csv_handle = fopen($file, "rb");
		while (($data = fgetcsv($csv_handle, 1000, $delimiter)) !== FALSE) {
			$csv_array[] = $data;
		}
		fclose($csv_handle);
		if($indexrow){
			//remove the title level from the csv
			$csv_index = array_shift($csv_array);
		}
		$i = 0;
		//get the categories and reorganize the array
		foreach($csv_array AS $csv_item){
			$j = 0;
			foreach($csv_item AS $csv_datum){
				if($indexrow){
					$list[$i][$csv_index[$j]] = $csv_datum;
				} else {
					$list[$i][$j] = $csv_datum;
				}
				$j++;
			}
			$i++;
		}
		return $list;
	}
}