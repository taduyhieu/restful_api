<?php
	
	namespace App\Http\Controllers\Buyer;
	
	use App\Http\Controllers\ApiController;
	use App\Models\Buyer;
	
	class BuyerCategoryController extends ApiController
	{
		public function index(Buyer $buyer)
		{
			$categories = $buyer->transactions()->with('product.categories')->get()->pluck('product.categories')->collapse()->unique('id')->values();
			return $this->showAll($categories);
		}
	}
