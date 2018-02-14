<?php

class CutListEntry {
	public $width = 0;
	public $height = 0;
	public $price = 0;
	public $count = 0;
	
	public function __construct($width, $height, $price, $count) {
		$this->width = $width;
		$this->height = $height;
		$this->price = $price;
		$this->count = $count;
	}
	
	public function stringify() {
		return 'size:'.$this->width.'x'.$this->height.',price:'.round($this->price,2).',count:'.$this->count;
	}
}

class CutList {
	public $list = array();
	
	// Create the CutList object from a string in the database
	public function __construct($parse_list_string) {
		$parse_list_string = strtolower($parse_list_string); // make sure that the string is entirely lowercase.
		$entries = explode(';', $parse_list_string);
		foreach($entries as $entry) {
			$attributes = explode(',', $entry);
			$width = 0;
			$height = 0;
			$price = 0;
			$count = 0;
			foreach($attributes as $attribute) {
				$key_value = explode(':', $attribute);
				switch($key_value[0]){
					case 'size':
						consoleLog('Size is '.$key_value[1]);
						$width_height = explode('x', $key_value[1]);
						$width = intval($width_height[0]);
						$height = intval($width_height[1]);
						break;	
					case 'price':
						consoleLog('Price is $'.$key_value[1]);
						$price = floatval($key_value[1]);
						break;	
					case 'count':
						consoleLog('The database contains '.$key_value[1]);
						$count = intval($key_value[1]);
						break;	
				}
			}
			array_push($this->list, new CutListEntry($width, $height, $price, $count));
		}
	}
	
	public function stringify() {
		$stored = '';
		
		$list_length = count($this->list);
		for($i = 0; $i < $list_length; $i++){
			$stored .= $this->list[$i]->stringify();
			if($i < $list_length - 1)
				$stored .= ';';
		}
		
		return $stored;
	}
}

?>