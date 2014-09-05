<?php

class hunspell {

	private $language = "en_US"; // en_US, ar, etc
	private $encoding = "en_US.utf-8";
	
	private $raw;
	private $hunspellVersion;
	
	// Identify a 'miss'. See [man hunspell]
	private $matcher = "/^(?P<type>&)\s(?P<original>\w+)\s(?P<count>\d+)\s(?P<offset>\d+):\s(?P<misses>.*+)$/u";
	private $allowedLanguages = array("en_US","de_DE", "ar", "fr","he_IL");
	
	private $response = array();
	
	
	public function __construct($input, $language = null){
		if($language != null && in_array($language, $this->allowedLanguages) == true) {
			$this->language = $language;
		}
		
		$command = "LANG={$this->encoding}; echo '{$input}' | hunspell -d {$this->language} ";
		
		$this->raw = shell_exec($command);		
	
		$this->parse();
	}

	private function parse(){
		if($this->raw == null) throw new Exception("Can't parse: no response.");
		
		// Split the response into lines.
		$lines = explode("\n", $this->raw);
		
		// First item is the version #
		$this->hunspellVersion = $lines[0];
		
		unset($lines[0]);
		
		foreach($lines as $line){
			preg_match($this->matcher, $line, $matches);
			
			if(count($matches) == 0) continue;

			if($matches['type'] == "&") {
			
				$this->response[$matches['original']] = array(
					"count" => $matches['count'],
					"offset" => $matches['offset'],
					"misses" => explode(", ", $matches['misses'])
				);
			
			}
		}
	}
	
	public function get(){
		return $this->response;
	}
	
	public function getGoogleFormatted(){
		$wrapper = "<spellresult>";
		
		foreach($this->response as $res){
			$wrapper .= "<c o=\"" . $res['offset'] . "\" l=\"" . $res['count'] . "\">" . implode("\t", $res['misses']) . "</c>";
		}
		
		$wrapper .= "</spellresult>";
		
		return $wrapper;
	}

}

?>
