<?php
	
	namespace App\Http\Controllers\Notification;
	
	use App\Http\Controllers\ApiController;
	use App\Models\User;
	use Illuminate\Http\Request;
	
	use App\Models\MongoDb\Notification;
	
	class NotificationController extends ApiController
	{
		public function __construct(
		){
		}
		public function index()
		{
			$notifications = Notification::all();
			return $this->showAll($notifications);
		}
		
		public function show(Product $product)
		{
			$user = $this->redisService->hSet('yyy', 1, "data", 10);
			return response()->json(['data' => $user], 200);
//			return $this->showOne($user);
		}
		
		public function store(Request $request) {
			$notification = Notification::create(['id' => 1, 'title' => 'The Fault in Our Stars']);
			
			return response()->json(['notification' => $notification], 200);
		}
	
		public function destroy ($id) {
			$product = Product::findOrFail($id);
			$product->delete();
			return response()->json(['data' => $product], 200);
		}
	}
