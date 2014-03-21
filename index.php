 <?php 
        $orig = yahoo_get_data(YIV_GET, 'orig', YIV_FILTER_COOKED);
	function removeSrc($matches)
	{
		$str = $matches[1].$matches[2].$matches[4];
		return $str;
	}

	$type =  $_GET['type'];
	if($type == 1) {
		$contents = file_get_contents("./mail_list.html");
		echo $contents;
	}else if($type == 2) {

		$contents = file_get_contents("./mail_read.html");
                if ($orig == 1) {
			echo $contents;
                }
                else {
			$blackList = file_get_contents("./blacklist.txt");
			$blackList = trim($blackList);
			$blackListArr = explode("\n", $blackList);

			$patterns = array();	
			foreach($blackListArr as $bitem) {
				# $pattern = "http://static.jabong.com";
				$searchPattern = "|(<img.*)(src=\")(.*?".addslashes($bitem).".*?)(\".*?>)|";
				array_push($patterns, $searchPattern);
				error_log( $searchPattern);
			}

			error_log(print_r($patterns, 1));
				
			$replacedStr = preg_replace_callback($patterns, "removeSrc", $contents);

			error_log($replacedStr);
			#file_put_contents("/tmp/out.html", $replacedStr);
			echo $replacedStr;
                }
	}
?> 
