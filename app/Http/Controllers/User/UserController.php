<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Mail\UserCreated;
use Validator;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Services\AuthenService;

class UserController extends ApiController
{
	private $authenService;
	
	public function __construct(
		AuthenService $authenService
	)
	{
		$this->authenService = $authenService;
	}
    public function index()
    {
			$users = User::all();
			return $this->showAll($users);
    }
	
	public function show(User $user)
	{
		return $this->showOne($user);
	}
	
	public function store(Request $request) {
		$rules = [
			'name' => 'required',
			'email' => 'required|email|unique:users',
			'password' => 'required|min:6|confirmed'
		];
		$this->validate($request, $rules);
		$data = $request->all();
		
		$data['password'] = bcrypt($request->password);
		$data['verified'] = User::UNVERIFIED_USER;
		$data['verification_token'] = User::generateVerificationCode();
		$data['admin'] = User::REGULAR_USER;
		
		$user = User::create($data);
		
		return response()->json(['data' => $user], 200);
	}
	
	public function update(Request $request, User $user)
	{
		$user->fill($request->only('email', 'name'));
		if($user->isClean()){
			return response()->json(['error' => 'You need to specify any diff value to update', 'code' => '422'], 422);
		}
		
		$rules = [
			'email' => 'email|unique:users,email,' . $user->id,
			'password' => 'min:6|confirmed',
			'admin' => 'in:' . User::ADMIN_USER . ',' . User::REGULAR_USER,
		];
		
		$this->validate($request, $rules);
		
		if($request->has('email') && $user->email != $request->email){
			$user->verified = User::UNVERIFIED_USER;
			$user->verification_token = User::generateVerificationCode();
		}
		
		if($request->password) {
			$user->password = bcrypt($request->password);
		}
		
		if($request->has('admin')) {
			if(!$user->isVerified()) {
				return response()->json(['error' => 'Only verified users can modify the admin field', 'code' => 409], 409);
			}
			$user->admin = $request->admin;
		}
		
		if(!$user->isDirty()){
			return response()->json(['error' => ' You need to specify a diffirent value to update', 'code' =>  422], 422);
		}
		
		$user->save();
		
		return response()->json(['data' => $user], 200);
	}
	
	public function destroy ($id) {
		$user = User::findOrFail($id);
		$user->delete();
		return response()->json(['data' => $user], 200);
	}
	
	public function verify($token) {
		$user = User::where('verification_token', $token)->firstOrFail();
		$user->verified = User::VERIFIED_USER;
		$user->verification_token = null;
		
		$user->save();
		
		return $this->showMessage('The account has been verified succesfully');
	}
	
	public function resend(User $user) {
		if($user->isVerified()){
			return $this->errorResponse('This user is already verified', 409);
		}
		
		Mail::to($user)->send(new UserCreated($user));
		return $this->showMessage('The verification email has been resend');
	}
	
	public function login(Request $request) {
		$validator = Validator::make($request->all(), [
			'email' => 'required|email',
			'password' => 'required',
		]);
		
		$accessToken = $this->authenService->setToken(['id' => 1, 'email' => 'taduyhieucntt98@gmail.com']);
		
		return $this->successResponse(['token' => $accessToken], 200);
	}
	
	public function getUserInfo(Request $request) {
		$user = $request->get('userInfo');
		return $this->successResponse(['user' => $user], 200);
	}

	protected function createNewToken($token){
		return response()->json([
			'access_token' => $token,
			'token_type' => 'bearer',
			'expires_in' => auth()->factory()->getTTL() * 60,
			'user' => auth()->user()
		]);
	}
	
	
}
