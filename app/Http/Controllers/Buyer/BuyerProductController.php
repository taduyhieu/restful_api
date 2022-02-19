<?php
	
	namespace App\Http\Controllers\Buyer;
	
	use App\Http\Controllers\ApiController;
	use App\Models\Buyer;
	
	class BuyerProductController extends ApiController
	{
		public function index(Buyer $buyer)
		{
			$products = $buyer->transactions()->with('product')->get()->pluck('product');
			return $this->showAll($products);
		}
	}
