<?php
	
	namespace App\Http\Controllers\Transaction;
	
	use App\Models\Transaction;
	use App\Http\Controllers\ApiController;
	
	class TransactionSellerController extends ApiController
	{
		public function __construct()
		{
		}
		
		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function index(Transaction $transaction)
		{
			$sellers = $transaction->product->seller;
			return $this->showOne($sellers);
		}
	}