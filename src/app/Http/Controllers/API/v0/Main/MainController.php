<?php namespace App\Http\Controllers\API\v0\Main;

use App\Modules\AdvertisingBammers\Repositories\AdvertisingBannerRepository;
use App\Modules\Auth\Models\Client;
use App\Modules\Integrations\Tezsum\Services\BalanceConverter;
use App\Modules\Integrations\Tezsum\Services\UserTezsum;
use App\Modules\Products\Repositories\CategoryRepository;
use App\Modules\Products\Repositories\ProductRepository;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Http\Controllers\API\Controller;

class MainController extends Controller
{
    /**
     * @var ProductRepository.
     */

    private $products;

    /**
     * @var CategoryRepository.
     */
    private $categories;

    /**
     * @var AdvertisingBannerRepository.
     */
    private $banners;

    public function __construct(ProductRepository $products, CategoryRepository $categories, AdvertisingBannerRepository $banners)
    {
        $this->products = $products;
        $this->categories = $categories;
        $this->banners = $banners;
    }

    /**
     * @OA\Get(
     *     path="/main/",
     *     tags={"Main"},
     *     operationId="mainShow",
     *     security={{"bearerAuth":{}}},
     *     summary="GET Main page",
     *     @OA\Response(
     *         response="200",
     *         description="Everything is fine",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $products = $this->products->getAll($request);
        $categories = $this->categories->getAllCategories();
        $banners = $this->banners->getAll();
        $getPopularProducts = $this->getPopularProducts();

        return response()->json([
            'balance' => BalanceConverter::convertToSomoni((new UserTezsum())->myBalance()['json']),
            'products' => $products,
            'categories' => $categories,
            'banners' => $banners,
            'getPopularProducts' => $getPopularProducts,
            'client' => auth()->user()
        ]);
    }

    public function agreeRegulation()
    {
        $client = Client::findOrFail(auth()->id());
        $client->is_agree_regulation = true;
        $client->save();

        \Cache::forget('clientToken:' . $client->token);

        return $this->respond(null,'Добро пожаловать. Тезмаркет!!!');
    }
}
