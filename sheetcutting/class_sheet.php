<?php

class Sheet
{
	public $parents = []; // array of Sheet objects
	
	public $material_name = "", $variant_name = "";
	public $id = 0;
	public $cut_id = 0;
    public $amount = 0;
	public $width = 0, $height = 0;
	public $price = 0;
	
	// Sheet class constructor.
	function __construct($material, $variant, $id_num, $cutId, $quantity, $w, $h, $cost) {
        $this->material_name = $material;
		$this->variant_name = $variant;
		$this->id = $id_num;
		$this->cut_id = $cutId;
		$this->amount = $quantity;
		$this->width = $w;
		$this->height = $h;
		$this->price = $cost;
    }
	
    public function toString() {
		$display = $this->material_name . " ";
		if($this->variant_name != NULL && $this->variant_name !== '') {
			$display .= '(' . $this->variant_name . ') ';
			$display .= 'variant_id = ' . $this->id . ', cut_id = ' . $this->cut_id;
		}
		$display .= 'size = ' . $this->width . 'x' . $this->height . ', price = $' . $this->price;
		return $display . ';';
    }
}

?>
