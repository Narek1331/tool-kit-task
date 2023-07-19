<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use Illuminate\Support\Facades\Auth;
use App\Services\ProductService;

/**
 * @OA\Info(title="My First API", version="0.1")
 */
class ProductController extends Controller
{
    /**
     * Create a new ProductController instance.
     *
     * @return void
     */
    public function __construct(ProductService $product_service)
    {
        $this->product_service = $product_service;
    }


    /**
     * @OA\Get(
     * tags={"Product"},
     *      path="/api/product",
     *      security={{"bearer_token":{}}},
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *     @OA\Response(
     *          response=422,
     *          description="Unprocessable Content"
     *      )
     *     ),
     *     ),
     */
    public function index(){

        $datas = $this->product_service->getByUserId(Auth::user()->id); // or Auth::user()->products;

        return response()->json([
            'status' => true,
            'data' => $datas
        ],200);
    }

     /**
     * @OA\Post(
     * tags={"Product"},
     * @OA\RequestBody(
     *   @OA\JsonContent(
     *      type="object",
     *     @OA\Property(property="name", type="string"),
     *     @OA\Property(property="description", type="string")
     *  )
     *  ),
     *      path="/api/product",
     *       security={{"bearer_token":{}}},
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *     @OA\Response(
     *          response=422,
     *          description="Unprocessable Content"
     *      )
     *     ),
     *     ),
     */
    public function store(StoreRequest $data){

        $data = $this->product_service->store($data['name'],$data['description'],Auth::user()->id);

        return response()->json([
            'status' => true,
            'message' => 'Product created successfully',
            'data' => $data
        ],201);
    }

     /**
     * @OA\Put(
     * tags={"Product"},
     * @OA\RequestBody(
     *   @OA\JsonContent(
     *      type="object",
     *     @OA\Property(property="name", type="string"),
     *     @OA\Property(property="description", type="string")
     *  )
     *  ),
     *      path="/api/product/{id}",
     *       security={{"bearer_token":{}}},
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *     @OA\Response(
     *          response=422,
     *          description="Unprocessable Content"
     *      )
     *     ),
     *     ),
     */
    public function update($product_id,UpdateRequest $data){

        $product = $this->product_service->updateByProductId($data,$product_id,Auth::user()->id);

        return response()->json([
            'status' => true,
            'message' => 'Product updated successfully',
            'data' => $product
        ],200);
    }

    /**
     * @OA\Delete(
     * tags={"Product"},
     *      path="/api/product/{id}",
     *       security={{"bearer_token":{}}},
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *     @OA\Response(
     *          response=422,
     *          description="Unprocessable Content"
     *      )
     *     ),
     *     ),
     */
    public function destroy($product_id){

        $product = $this->product_service->destroyByProductId($product_id,Auth::user()->id);

        return response()->json([
            'status' => true,
            'message' => 'Product destroyed successfully',
        ],200);
    }
}
