<?php namespace App\Modules\Auth\UseCases;


use App\Modules\Auth\Models\Client;

class ClientCrud
{
    public function insertOrUpdateClientToken(array $columnData)
    {
        $client = new Client();
        $findClient = $client->find($columnData['subscriber_id']);

        if ($findClient){
            Client::where('subscriber_id', $columnData['subscriber_id'])->update($columnData);
            return $client->find($columnData['subscriber_id']);
        }

        $client->create($columnData);

        return $client->find($columnData['subscriber_id']);
    }
}
