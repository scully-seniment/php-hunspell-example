<?php
error_reporting(E_ALL);
require_once('hunspell.class.php');

class Spellchecker extends hunspell
{
	private $language_array = array("en" => "en_US",
					"de" => "de_DE",
					"fr" => "fr",
					"ar" => "ar",
					"he" => "he_IL"); 	
	private $response_array = array("json","json_unescaped_unicode","xml","json_min","json_unescaped_unicode_min");
	
	private $response_type;
	private $result;

	public function __construct($p_text,$p_language,$p_response_type)
	{
		$language = $this->language_map($p_language);
		if (is_null($language)){
			throw new Exception("Unsupported language: {$p_language}");
		}
		if(!$this->check_response_type($p_response_type)){
			throw new Exception("Unsupported response type: {$p_response_type}");
		} else {
			$this->response_type = $p_response_type;
		}
		parent::__construct($p_text,$language);
	}

	public function validate()
        {
		$this->result = $this->get();
                switch($this->response_type){
			case 'xml':
				$this->xml_format();
				break;
			case 'json_unescaped_unicode_min':
				$this->minify();
                                $this->result = json_encode($this->result,JSON_UNESCAPED_UNICODE);
                                break;
                        case 'json_min':
				$this->minify();
                                $this->result = json_encode($this->result);
                                break;
			case 'json_unescaped_unicode':
                                $this->result = json_encode($this->result,JSON_UNESCAPED_UNICODE);
                                break;
			case 'json':
				$this->result = json_encode($this->result);
				break;
			
		}
                return $this->result;
        }

	private function minify()
	{
		$mini = array();
		foreach($this->result as $key => $value){
			$mini[$value['offset']] = $value['misses'];
		}
		$this->result = $mini;
	}	

	private function language_map($p_language)
	{
		foreach ($this->language_array as $key => $value){
			if ($p_language == $key){
				return $value;
			}
		}
		return null;
	}

	private function check_response_type($p_response_type){
		foreach ($this->response_array as $response){
			if ($p_response_type == $response){
				return true;	
			}
		}
		return false;
	}

	private function xml_format()
	{
		$xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8" ?><spellchecker />');
		foreach ($this->result as $key => $value){

			$error = $xml->addChild('error');
			$error->addChild('word', $key);

			foreach ($value as $sub_key => $sub_value){

				switch($sub_key){
					case 'count':
						$error->addChild('count',$sub_value);
						break;
					case 'offset':
						$error->addChild('offset',$sub_value);
						break;
					case 'misses':
						$misses = $error->addChild('misses');
						foreach ($sub_value as $miss){
							$misses->addChild('miss', $miss);
						}
						break;
				}
			}
		}
		$this->result = $xml->asXML();
	}
}


