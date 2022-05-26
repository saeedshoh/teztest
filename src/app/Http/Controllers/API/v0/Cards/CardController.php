<?php


namespace App\Http\Controllers\API\v0\Cards;


use App\Http\Controllers\API\Controller;
use App\Modules\Integrations\Tezsum\Services\UserTezsum;
use App\Modules\Payments\Repositories\UserCard;
use App\Modules\Payments\Requests\AddCardRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class CardController extends Controller
{
    private $userCard;

    public function __construct(UserCard $userCard)
    {
        $this->userCard = $userCard;
    }

    /**
     * @return JsonResponse
     */
    public function getCardsByPhoneNumber(): JsonResponse
    {
        return $this->respond(['cards' => $this->userCard->getByPhoneNumberCards()]);
    }

    public function addCard(AddCardRequest $request): JsonResponse
    {
        $addCard = $this->userCard->addCard($request->all());
        if(isset($addCard['error'])){
            return $this->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY)
                ->respondWithError([], $addCard['error']);
        }
        return $this->respond([], $addCard['success']);
    }

    public function removeCard(Request $request): JsonResponse
    {
        $this->validate($request, [
           'cardId' => 'required'
        ]);

        $deleteCard = $this->userCard->deleteCard($request->cardId);
        if(isset($deleteCard['error'])){
            return $this->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY)
                ->respondWithError([], $deleteCard['error']);
        }
        return $this->respond([], $deleteCard['success']);
    }
}
