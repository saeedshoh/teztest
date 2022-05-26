<?php namespace App\Modules\Integrations\Tezsum\Services;



class BalanceConverter
{
    public static function convertToSomoni(array $balance): array
    {
        if($balance['balance'] != false) {
            $balance = [
                'cardtype' => $balance['cardtype'],
                'balance' => number_format($balance['balance'] / 100, 2),
                'currency' => $balance['currency'],
                'mobile' => $balance['mobile']
            ];
        }

        return $balance;
    }

    public static function convertMerchantBalance(string $balance): string
    {
        return number_format($balance / 100, 2);
    }

    public static function convertToDiram($balance): int
    {
        return (int) ($balance * 100);
    }
}
