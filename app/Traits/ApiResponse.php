<?php
	namespace App\Traits;
	use Illuminate\Support\Collection;
	use Illuminate\Support\Facades\Cache;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Support\Facades\Validator;
	use Illuminate\Pagination\LengthAwarePaginator;;
	
	trait ApiResponse
	{
		protected function successResponse($data, $code)
		{
			return response()->json($data, $code);
		}
		
		protected function errorResponse($message, $code)
		{
			return response()->json(['error' => $message, 'code' => $code], $code);
		}
		
		protected function showAll(Collection $collection, $code = 200)
		{
			if (!$collection->isEmpty()) {
				return $this->successResponse(['data' => $collection], $code);
			}
		}
		
		protected function showOne(Model $model, $code = 200)
		{
			return $this->successResponse($model, $code);
		}
	}
	