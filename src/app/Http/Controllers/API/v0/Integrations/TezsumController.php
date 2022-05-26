<?php namespace App\Http\Controllers\API\v0\Integrations;


use App\Http\Controllers\API\Controller;
use App\Modules\Integrations\Tezsum\Services\BalanceConverter;
use App\Modules\Integrations\Tezsum\Services\UserTezsum;
use Illuminate\Http\JsonResponse;

class TezsumController extends Controller
{
    private $tezsum;

    public function __construct(UserTezsum $tezsum)
    {
        $this->tezsum = $tezsum;
    }

    /**
     * @OA\Get(
     *     path="/integrations/tezsum/my_balance",
     *     tags={"Integrations"},
     *     operationId="get my balance (tezsum)",
     *     security={{"bearerAuth":{}}},
     *     summary="GET my balance tezsum",
     *     @OA\Response(
     *         response="200",
     *         description="Everything is fine",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     * )
     *
     * @return JsonResponse
     */
    public function myBalance(): JsonResponse
    {
        $convertToSomoni = BalanceConverter::convertToSomoni($this->tezsum->myBalance()['json']);
        return $this->respond($convertToSomoni);
    }

}
