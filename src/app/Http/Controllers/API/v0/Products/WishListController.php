<?php namespace App\Http\Controllers\API\v0\Products;


use App\Http\Controllers\API\Controller;
use App\Http\Resources\WishlistResource;
use App\Modules\Products\Models\Product;
use App\Modules\Products\Models\Wishlist;
use App\Modules\Products\Requests\WishlistDeleteRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;


class WishListController extends Controller
{
    /**
     * @OA\Post (
     *     path="/products/wishlists/",
     *     tags={"Wishlists"},
     *     operationId="wishlistAdd",
     *     security={{"bearerAuth":{}}},
     *     summary="Add to wishlists",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Pass user credentials",
     *         @OA\JsonContent(
     *             required={"product_id"},
     *             @OA\Property(property="product_id", type="integer", example="2")
     *         ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Everything is fine",
     *         @OA\MediaType(
     *             mediaType="application/json"
     *         ),
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Validation",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     )
     * )
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'product_id' => [
                'required',
                'exists:products,id',
                Rule::unique('wishlists', 'product_id')->where('client_id', auth()->id())
            ],
        ]);

        $wishlist = new Wishlist();
        $wishlist->client_id = auth()->id();
        $wishlist->product_id = $request->product_id;
        $product = Product::find($request->product_id);
        $product->wishlist_count = $product->wishlist_count + 1;
        $product->save();
        $wishlist->save();

        return $this->respond([],'Добавлено успешно.')->setStatusCode(200);
    }

    /**
     * @OA\Delete (
     *     path="/products/wishlists",
     *     tags={"Wishlists"},
     *     operationId="wishlistDelete",
     *     security={{"bearerAuth":{}}},
     *     summary="Delete Wishlist by id",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Pass user credentials",
     *         @OA\JsonContent(
     *             required={"product_id"},
     *             @OA\Property(property="product_id", type="integer", example="1"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Everything is fine",
     *         @OA\MediaType(
     *             mediaType="application/json"
     *         ),
     *     ),
     * )
     *
     * @param WishlistDeleteRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(WishlistDeleteRequest $request)
    {
        $wishlist = Wishlist::where(['product_id' => $request->product_id, 'client_id' => auth()->id()])->first();
        $wishlist->delete();

        return $this->respond([],'Удалено успешно.')->setStatusCode(200);
    }

    /**
     * @OA\Get(
     *     path="/products/wishlists",
     *     tags={"Wishlists"},
     *     operationId="wishlistShow",
     *     security={{"bearerAuth":{}}},
     *     summary="GET wishlists",
     *     @OA\Response(
     *         response="200",
     *         description="Everything is fine",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     * )
     *
     * @return AnonymousResourceCollection
     */
    public function getBySubscriberId(): AnonymousResourceCollection
    {
        $query = Wishlist::with(['product', 'product.productMedia'])->where("client_id", "=", auth()->id());

        $query->when(request('search', false), function ($q, $search) {
            return $q->whereHas('product', function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')->where("client_id", "=", auth()->id());
            });
        });

        return WishlistResource::collection($query->orderby('id', 'desc')->simplePaginate());
    }

}
