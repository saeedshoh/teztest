<?php namespace App\Http\Controllers\API\v0\AdvertisingBanners;

use Illuminate\Http\Request;

use App\Http\Controllers\API\Controller;
use App\Modules\AdvertisingBammers\Repositories\AdvertisingBannerRepository;

class AdvertisingBannerController extends Controller
{
    /**
    * @var AdvertisingBannerRepository
    */

    private $advertisingBannerRepository;

    public function __construct(AdvertisingBannerRepository $advertisingBannerRepository)
    {
        $this->advertisingBannerRepository = $advertisingBannerRepository;
    }

    /**
     * @OA\Get(
     *     path="/advertising_banners/",
     *     tags={"AdvertisingBanners"},
     *     operationId="advertisingBannerShow",
     *     security={{"bearerAuth":{}}},
     *     summary="GET Advertising Banners",
     *     @OA\Response(
     *         response="200",
     *         description="Everything is fine",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $getBanners = $this->advertisingBannerRepository->getAll();
        return $this->respond(['banners' => $getBanners]);
    }
}
