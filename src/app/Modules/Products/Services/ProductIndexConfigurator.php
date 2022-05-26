<?php namespace App\Modules\Products\Services;

use ScoutElastic\IndexConfigurator;
use ScoutElastic\Migratable;

class ProductIndexConfigurator extends IndexConfigurator
{
    use Migratable;
    protected $name = 'products';
    /**
     * @var array
     */
    protected $settings = [
        'analysis' => [
            'filter' => [
                'russian_stop' => [
                    'type' => 'stop',
                    'stopwords' => '_russian_',
                ],
                'russian_stemmer' => [
                    'type' => 'stemmer',
                    'language' => 'russian',
                ],
            ],
            'analyzer' => [
                'rebuilt_russian' => [
                    'tokenizer' => 'standard',
                    'filter' => [
                        'lowercase',
                        'russian_stop',
                        'russian_stemmer',
                        //'russian_morphology'
                    ],
                ],
            ],
        ]
    ];
}
