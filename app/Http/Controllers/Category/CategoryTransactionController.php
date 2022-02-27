<?php
	
	namespace App\Http\Controllers\Category;
	
	use App\Models\Category;
	use Illuminate\Http\Request;
	use App\Http\Controllers\ApiController;
	
	class CategoryTransactionController extends ApiController
	{
		public function __construct()
		{
		}
		
		/**
		 * Display a listing of the resource.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function index(Category $category)
		{
			$transactions = $category->products()->whereHas('transactions')
													->with('transactions')
													->get()
													->pluck('transactions')
													->collapse()
													->unique('id')
													->values();
			
			return $this->showAll($transactions);
		}
	}