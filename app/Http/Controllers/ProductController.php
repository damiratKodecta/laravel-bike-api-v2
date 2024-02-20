<?php


namespace App\Http\Controllers;

use OpenApi\Annotations as OA;
use App\Models\Product;
use Illuminate\Http\Request;



/**
 * @OA\Tag(
 *     name="Products",
 *     description="API Endpoints for Products"
 * )
 */

 /**
 * @OA\Schema(
 *     schema="Product",
 *     required={"product_type_id", "name", "price"},
 *     @OA\Property(
 *         property="product_type_id",
 *         type="integer",
 *         format="int64",
 *         description="The ID of the product type",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         maxLength=255,
 *         description="The name of the product",
 *         example="Product 1"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="The description of the product",
 *         example="This is a product description"
 *     ),
 *     @OA\Property(
 *         property="price",
 *         type="number",
 *         format="decimal",
 *         description="The price of the product",
 *         example=19.99
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="The creation timestamp of the product",
 *         readOnly=true
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="The last update timestamp of the product",
 *         readOnly=true
 *     )
 * )
 */

class ProductController extends Controller
{

    //-------------------------------------------
    // Version 1 controller methods
    //-------------------------------------------
     
    /**
     * Display a listing of the tasks.
     *
     * @return Response
     *
     * @OA\Get(
     *      path="/api/v1/products",
     *      operationId="getProductsList",
     *      tags={"Products"},
     *      summary="Get list of products",
     *      description="Returns list of products",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/Product")
     *          )
     *      )
     * )
     */
    public function indexV1()
    {
        return Product::all();
        /* TODO 
        try catch 
        */
    }
    
   
    /**
     * Create a newly created resource in storage.
     */


         /**
     * @OA\Post(
     *     path="/api/v1/products",
     *     tags={"Products"},
     *     summary="Create a new product",
     *     operationId="createProduct",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Product created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="The given data was invalid."
     *             ),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 example={
     *                     "name": {"The name field is required."},
     *                     "price": {"The price field is required."}
     *                 }
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Server Error"
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Internal Server Error"
     *             )
     *         )
     *     ), 
     *      @OA\Response(
     *         response=503,
     *         description="Database error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Database Error"
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Database Server Error"
     *             )
     *         )
     *     )
     * )
     */

    public function storeProductV1(Request $request)
    {
        try {
            $request->validate([
                'product_type_id' => 'required',
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0' //numeric, not number, not float, etc...
            ]);
    
            $product = Product::create($request->all());

            return response()->json($product, 201);
    
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation Error', 'errors' => $e->errors()], 422);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Database Error', 'error' => $e->getMessage()], 503);
        } catch (Exception $e) {
            return response()->json(['message' => 'Server Error', 'error' => $e->getMessage()], 500);
        }
    }
        

    /**
     * Display the specified product.
     *
     * @param  int  $id
     * @return Response
     *
     * @OA\Get(
     *      path="/api/v1/products/{id}",
     *      summary="Get a single product by ID",
     *      tags={"Products"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID of the product to retrieve",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="The product with the specified ID ($id) retrieved successfully.",
     *          @OA\JsonContent(ref="#/components/schemas/Product"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Product with the specified ID ($id) not found"
     *      )
     * )
     */ 

    public function showProductV1(string $id)
    {
        //
         $product = Product::find($id);

         if (!$product) {
            $resp = 'Product with the specified ID :id not found';
             return response()->json(['error' => trans($resp, ['id' => $id]) ], 404);
         }
 
         return $product;
    }




    /**
     * Display the specified variant within specified product .
     *
     * @param  int  $productId
     * @param  int  $variantId
     * @return Response
     *
     * @OA\Get(
     *      path="/api/v1/products/{productId}/{variantId}",
     *      summary="Get a single variant for a specified product by ID",
     *      tags={"Products"},
     *      @OA\Parameter(
     *          name="productId",
     *          in="path",
     *          required=true,
     *          description="ID of the product containing the variant to retrieve",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     * *      @OA\Parameter(
     *          name="variantId",
     *          in="path",
     *          required=true,
     *          description="ID of the variant to retrieve",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     
     *      @OA\Response(
     *          response=200,
     *          description="The variant with the specified ID ($variantId) of the product with the specified ID ($productId) retrieved successfully.",
     *          @OA\JsonContent(ref="#/components/schemas/Product"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="The variant with the specified ID ($variantId) of the product with the specified ID ($productId) not found"
     *      )
     * )
     */ 

     public function showProductVariantV1(string $productId, string $variantId)
     {
         //
          $product = Product::find($productId);
 
          if (!$product) {
              return response()->json(['error' => "The variant with the specified ID $variantId of the product with the specified ID $productId not found" ], 404);
          }

          $variation = $product->find($variantId);

          if (!$variation) {
            return response()->json(['error' => "The variant with the specified ID $variantId of the product with the specified ID $productId not found" ], 404);
          }          
  
          return $variation;
     }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     */

    /**
     * Display the specified product.
     *
     * @param  int  $id
     * @return Response
     *
     * @OA\Delete(
     *      path="/api/v1/products/{id}",
     *      summary="Delete a single product by ID",
     *      tags={"Products"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID of the product to delete",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="The product with the specified ID ($id) deleted successfully!",
     *          @OA\JsonContent(ref="#/components/schemas/Product"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="The product with the specified ID ($id) not found!"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Failed to delete the product with the specified ID ($id)!"
     *      ) 
     * )
     */ 

    public function deleteProductV1(string $id)
    {
        //

        try {
            $product = Product::find($id);

            if (!$product) {
                return response()->json(['error' => "The product with the specified ID $id not found!"], 404);
            }

            $product->delete();
            return response()->json(['message' => "The product with the specified ID $id deleted successfully!"], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => "Failed to delete the product with the specified ID $id!"], 500);
        }

        return $product; //never triggers

    }
}
