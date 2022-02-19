<?php
	
	namespace App\Http\Controllers\Buyer;
	
	use App\Http\Controllers\ApiController;
	use App\Models\Buyer;
	
	class BuyerSellerController extends ApiController
	{
		public function index(Buyer $buyer)
		{
			$sellers = $buyer->transactions()->with('product.seller')->get()->pluck('product.seller');
			return $this->showAll($sellers);
		}
	}
