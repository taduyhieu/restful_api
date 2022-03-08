<?php
	
	namespace App\Http\Controllers\Product;
	
	use App\Http\Controllers\ApiController;
	use Illuminate\Http\Request;
	use App\Services\RedisService;
	
	use Storage;
	use App\Models\Product;
	
	class ProductController extends ApiController
	{
		private $redisService;
		public function __construct(
			RedisService $redisService
		){
			$this->redisService = $redisService;
		}
		/**
		 * @OA\Get(
		 *     path="/api/products",
		 *     tags={"Products"},
		 *     summary="Get list products",
		 *     description="Returns products data",
		 *      @OA\Parameter(
		 *          name="name",
		 *          description="product name",
		 *          required=false,
		 *          in="path",
		 *          @OA\Schema(
		 *              type="string"
		 *          )
		 *      ),
		 *      @OA\Parameter(
		 *          name="greater_price",
		 *          description="All products with a price greater than greater_price",
		 *          required=false,
		 *          in="path",
		 *          @OA\Schema(
		 *              type="integer"
		 *          )
		 *      ),
		 *     @OA\Response(response="default", description="Welcome page")
		 * )
		 * @SWG\Parameters(
		 *    required: false,
		 *    in: user_id
		 * )
		 */
		public function index()
		{
			$products = Product::all();
			return $this->showAll($products);
		}
		
		/**
		 * @OA\Get(
		 *      path="/api/products/{id}",
		 *      operationId="show",
		 *      tags={"Products"},
		 *      summary="Get product information",
		 *      description="Returns product data",
		 *      @OA\Parameter(
		 *          name="id",
		 *          description="Project id",
		 *          required=true,
		 *          in="path",
		 *          @OA\Schema(
		 *              type="integer"
		 *          )
		 *      ),
		 *      @OA\Response(
		 *          response=200,
		 *          description="Successful operation",
		 *       ),
		 *      @OA\Response(
		 *          response=400,
		 *          description="Bad Request"
		 *      ),
		 *      @OA\Response(
		 *          response=401,
		 *          description="Unauthenticated",
		 *      ),
		 *      @OA\Response(
		 *          response=403,
		 *          description="Forbidden"
		 *      )
		 * )
		 */
		public function show(Product $product)
		{
			dd($product);
			return $this->showOne($product);
		}

		public function store(Request $request) {
			$data = $request->all();
			$data['image'] = $request->image->store('path', 'public');
			$product = Product::create($data);
			return $this->showOne($product);
		}

		public function update(Request $request, Product $product)
		{
			$product->fill($request->only('name', 'description', 'quantity', 'status', 'seller_id'));
			if($request->hasFile('image')) {
				Storage::delete($product->image);
				$product->image = $request->image->store('path', 'public');
			}
			
			$product->save();
			return $this->showOne($product);
		}

		public function destroy ($id) {
			$product = Product::findOrFail($id);
			$product->delete();
			return response()->json(['data' => $product], 200);
		}
	}
