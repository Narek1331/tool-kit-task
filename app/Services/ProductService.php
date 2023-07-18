<?php
namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductService{


    /**
     * Create product service.
     */
    public function store($name, $desc, $user_id){
        return Product::create([
            'name' => $name,
            'description' => $desc,
            'user_id' => $user_id
        ]);
    }

    /**
     * Get products by user_id.
     */
    public function getByUserId($user_id){
        return Product::where('user_id',$user_id)->get();
    }

    /**
     * Update product by product_id.
     */
    public function updateByProductId($data,$product_id,$user_id){
        $product = Product::findOrFail($product_id);

        if($product['user_id'] != $user_id){
            throw new HttpResponseException(response()->json([
                'success'   => false,
                'message'   => 'Validation error',
                'data'      => 'You do not have access to edit the product'
            ]));
        }

        $product->update($data->toArray());

        return $product->refresh();
    }

    /**
     * Destroy product by product_id.
     */
    public function destroyByProductId($product_id,$user_id){
        $product = Product::findOrFail($product_id);

        if($product['user_id'] != $user_id){
            throw new HttpResponseException(response()->json([
                'success'   => false,
                'message'   => 'Validation error',
                'data'      => 'You do not have access to destroy the product'
            ],422));
        }

        return $product->delete();
    }
}

?>
