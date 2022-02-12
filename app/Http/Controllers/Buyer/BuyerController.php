<?php
	
	namespace App\Http\Controllers\Buyer;
	
	use App\Http\Controllers\ApiController;
	use App\Models\Buyer;
	
	class BuyerController extends ApiController
	{
		public function index()
		{
			$buyers = Buyer::all();
			return $this->showAll($buyers);
		}
		
		public function show(Product $product)
		{
			return $this->showOne($product);
		}
	}
