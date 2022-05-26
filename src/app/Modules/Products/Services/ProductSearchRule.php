<?php namespace App\Modules\Products\Services;


use ScoutElastic\SearchRule;

class ProductSearchRule extends SearchRule
{
    public function buildQueryPayload()
    {
        return [
            'must' => [
                'multi_match' => [
                    'query' => $this->builder->query,
                    'fuzziness' => 'AUTO',
                    'analyzer' => 'rebuilt_russian',
                    'type' => 'bool_prefix',
                    'fields' => ['title', 'description'],
                ]
            ]
        ];
    }
}
