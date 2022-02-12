<?php
	
	namespace App\Http\Controllers\Product;
	
	use App\Http\Controllers\ApiController;
	use Illuminate\Http\Request;
	use App\Models\Product;
	
	class ProductController extends ApiController
	{
		public function index()
		{
			$products = Product::all();
			return $this->showAll($products);
		}
		
		public function show(Product $product)
		{
			return $this->showOne($product);
		}
//
//		public function store(Request $request) {
//			$rules = [
//				'name' => 'required',
//				'email' => 'required|email|unique:users',
//				'password' => 'required|min:6|confirmed'
//			];
//			$this->validate($request, $rules);
//
//			$data = $request->all();
//
//			$data['password'] = bcrypt($request->password);
//			$data['verified'] = User::UNVERIFIED_USER;
//			$data['verification_token'] = User::generateVerificationCode();
//			$data['admin'] = User::REGULAR_USER;
//
//			$user = User::create($data);
//
//			return response()->json(['data' => $user], 200);
//		}
//
//		public function update(Request $request, User $user)
//		{
//			$user->fill($request->only('email', 'name'));
//			if($user->isClean()){
//				return response()->json(['error' => 'You need to specify any diff value to update', 'code' => '422'], 422);
//			}
//
//			$rules = [
//				'email' => 'email|unique:users,email,' . $user->id,
//				'password' => 'min:6|confirmed',
//				'admin' => 'in:' . User::ADMIN_USER . ',' . User::REGULAR_USER,
//			];
//
//			$this->validate($request, $rules);
//
//			if($request->has('email') && $user->email != $request->email){
//				$user->verified = User::UNVERIFIED_USER;
//				$user->verification_token = User::generateVerificationCode();
//			}
//
//			if($request->password) {
//				$user->password = bcrypt($request->password);
//			}
//
//			if($request->has('admin')) {
//				if(!$user->isVerified()) {
//					return response()->json(['error' => 'Only verified users can modify the admin field', 'code' => 409], 409);
//				}
//				$user->admin = $request->admin;
//			}
//
//			if(!$user->isDirty()){
//				return response()->json(['error' => ' You need to specify a diffirent value to update', 'code' =>  422], 422);
//			}
//
//			$user->save();
//
//			return response()->json(['data' => $user], 200);
//		}
//
		public function destroy ($id) {
			$product = Product::findOrFail($id);
			$product->delete();
			return response()->json(['data' => $product], 200);
		}
	}