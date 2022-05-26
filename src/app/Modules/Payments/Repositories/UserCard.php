<?php


namespace App\Modules\Payments\Repositories;


use App\Modules\Integrations\Tezsum\Services\UserTezsum;
use App\Modules\Payments\Models\CreditCard;
use Illuminate\Support\Collection;

class UserCard
{
    private $userTezsum;

    public function __construct(UserTezsum $userTezsum)
    {
        $this->userTezsum = $userTezsum;
    }

    public function getByPhoneNumberCards(): Collection
    {
        $myCards = $this->userTezsum->myCards();

        if(isset($myCards['json']['list'])){
            return $this->map($myCards['json']['list']);
        }
        return collect();
    }

    public function addCard(array $cardData): Collection
    {
        $session = $this->userTezsum->startApp();

        if(isset($session['json']['session'])){
            $addCard = $this->userTezsum->addCard($session['json']['session'], $cardData);
            if(isset($addCard['json']['success'])){
                CreditCard::create([
                    'card_id' => $addCard['json']['card_id'],
                    'card_pan' => $cardData['card_pan'],
                    'card_name' => $cardData['card_name'],
                    'card_exp' => $cardData['card_exp'],
                    'client_id' => auth()->id(),
                    'card_type' => 'korti_milli',
                    'add_card_response' => json_encode($addCard)
                ]);
                return collect(['success' => 'Успешно добавлено']);
            }
            return collect(['error' => $addCard['json']['desc']]);
        }

       return collect(['error' => $session['json']['desc']]);
    }

    public function deleteCard(string $cardId): Collection
    {
        $session = $this->userTezsum->startApp();

        if(isset($session['json']['session'])) {
            $delCard = $this->userTezsum->removeCard($session['json']['session'], $cardId);

            if(isset($delCard['json']['success'])){
                CreditCard::where('card_id', $cardId)->delete();
                return collect(['success' => 'Успешно удалено']);
            }
            return collect(['error' => $delCard['json']['desc']]);
        }

        return collect(['error' => $session['json']['desc']]);
    }

    private function map(array $data): Collection
    {
        return collect($data)->map(function ($data) {
            return [
                'card_id' => $data['card_id'],
                'card_pan' => $data['card_pan'],
                'card_name' => $data['card_name'],
                'card_type' => $data['card_type'],
                'main' => (boolean) $data['main'],
                'active' => (boolean) $data['active']
            ];
        });
    }

}
