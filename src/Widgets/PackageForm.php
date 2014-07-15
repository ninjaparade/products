<?php namespace Ninjaparade\Products\Widgets;

use Input;

class PackageForm {

	protected $amount;

	protected $slug;

	protected $id;

	protected $return;

	protected $checked;

	protected $disabled;

	public function __construct()
	{
		
	}


	public function show( $product, $package )
	{
		$this->amount = 0;
		
		$this->slug = $product->slug;
		
		$this->id = $product->id;
		
		$this->checked = "";

		$this->disabled = "disabled";

		if( $package->exists )
		{
			if( $package->items->find( $this->id))
			{
				$this->amount = $package->items->find($this->id)->pivot->qty;
			}
		}


		if($package->items->find($this->id) && $this->amount > 0 || Input::old($product->slug) )
		{
			$this->checked  = 'checked';		

			$this->disabled = '';		
		}
			
	
		$this->return = '<input name="products[]" type="checkbox" value="'.$this->id.'" class="data-select" data-select="'. $this->slug . '"' . $this->checked. '>'.
						'<input type="text" name="'. $product->slug. '" class="form-control" id="'. $this->slug. '" value="'. $this->amount .'"'. $this->disabled. '>';
		return $this->return;
		  
	}

}
