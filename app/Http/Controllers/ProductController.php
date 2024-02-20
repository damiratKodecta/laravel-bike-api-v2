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
 *         format="float",
 *         description="The price of the product",
 *         example=19.99
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
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
