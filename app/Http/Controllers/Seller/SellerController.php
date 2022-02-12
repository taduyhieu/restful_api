<?php
	
	namespace App\Http\Controllers\Seller;
	
	use App\Models\Seller;
	use Illuminate\Http\Request;
	use App\Http\Controllers\ApiController;
	
	class SellerController extends ApiController
	{
		public function __construct()
		{
		}
		
		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function index()
		{
			$sellers = Seller::all();
			
			return $this->showAll($sellers);
		}
		
		/**
		 * Display the specified resource.
		 *
		 * @param  int  $id
		 * @return \Illuminate\Http\Response
		 */
		public function show(Seller $seller)
		{
			return $this->showOne($seller);
		}
	}