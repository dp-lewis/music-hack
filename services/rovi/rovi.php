<?php

class Rovi {
	  private $apikey = '';
	  private $sharedsecret = '';
	
      function __construct($apikey, $sharedsecret) {
	       $this->apikey = $apikey;
	       $this->sharedsecret = $sharedsecret;
      }

/*
A calculated authorization code. To perform the calculation, execute the MD5 function on the concatenation of the following three strings:
Your API key.
The secret key you received with your API key.
The Unix time. Unix time is a timestamp supported in most development environments, and is generally defined as the number of seconds since January 1, 1970 00:00:00 GMT.
Perform the calculation at the time of each request to be sure it's within a five-minute window of the server time. If you're testing the call in a browser, use our online signature generator to perform the calculation.
*/
	  private function createsig() { 
		  $sig = md5($this->apikey . $this->sharedsecret . mktime());  
		  return $sig;
	  }
	
	  private function searchurl() {
	//	$url = "http://api.rovicorp.com/search/v2.1/music/search?";
		
		$url = "http://api.rovicorp.com/search/v2/music/filterbrowse?";
		$url .= "apikey=" . $this->apikey;
		$url .= "&sig=" . $this->createsig();
		return $url;		
	  }
	
	  private function genreurl() {
          $url = "http://api.rovicorp.com/data/v1/descriptor/musicgenres";
          $url .= "?apikey=" . $this->apikey;
          $url .= "&sig=" . $this->createsig();		

          return $url;
	  }
	
	  public function datesearch($start, $end) {
		/*
		Romantic XA0000000758
		Sensual: XA0000000764
		Sexual: XA0000001091
		Sexy: XA0000000770
		Sleazy: XA0000001094
		Erotic: XA0000000710
		Hedonistic: XA0000001018
		Intimte: XA0000000722
		*/
		   $url  = "&query=";
		    // 		
		    // $url .= "&filter=moodid:XA0000000758";
		    // $url .= "|moodid:XA0000000764";
		    // $url .= "|moodid:XA0000001091";
		    // $url .= "|moodid:XA0000000770";
		    // $url .= "|moodid:XA0000001094";
		    // $url .= "|moodid:XA0000000710";
		    // $url .= "|moodid:XA0000001018";
		    // $url .= "|moodid:XA0000000722";
		
		  //$url .= "&filter=themeid:MA0000005076";
		
		   // genre
		
		// blues MA0000002467
		
		  // $url .= "&filter=genreid:MA0000002567"; // easy listening
	     //  $url .= "|genreid:MA0000002467";	// blues
	      // $url .= "|genreid:MA0000002592";// folk
		
		//subgenreid:
		  //  $url .= "|subgenreid:MA0000012141";	// country folk
		   
											
		   $url .= "&entitytype=song";
		   $url .= "&format=json";
		   $url .= "&filter=releasedate>" . $start;
		   $url .= "&filter=releasedate<" . $end;
		   $url .= "&size=10";
		
		   $cachefile = "../../cache/" . md5($url) . ".js";
		
		   $url = $this->searchurl() . $url;
		

		echo $url;

		   // check if this has been retrieved before
		   if (file_exists($cachefile)) {
			   return file_get_contents($cachefile);
		   } else {
		       $content = file_get_contents($url);
			   $fh = fopen($cachefile, 'w') or die("can't open file");
			   fwrite($fh, $content);
			   fclose($fh);	
			   return $content;
		   }
		

	  }
	
	
	  public function genres () {
		readfile($this->genreurl() . "&include=all");
	  }
}

?>