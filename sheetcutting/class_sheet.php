<?php

class Sheet
{
	public $parents = []; // array of Sheet objects
	
	public $material_name = "", $variant_name = "";
	public $id = 0;
    public $amount = 0;
	public $width = 0, $height = 0;
	public $price = 0;
	
	// Sheet class constructor.
	function __construct($material, $variant, $id_num, $quantity, $w, $h, $cost) {
        $this->material_name = $material;
		$this->variant_name = $variant;
		$this->id = $id_num;
		$this->amount = $quantity;
		$this->width = $w;
		$this->height = $h;
		$this->price = $cost;
    }
	
	//
    public function toString() {
		$display = $material_name . " ";
		if($variant_name != NULL && $variant_name !== '') {
			$display .= '(' . $variant_name . ') ';
		}
		$display .= 'size = ' . $width . 'x' . $height . ', price = $' . $price;
		return $display;
    }
}

?>