<?php

namespace Islomzoda\YandexMarketUpdateStock\Facades;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Log;
use Islomzoda\YandexMarketUpdateStock\Model\YandexMarketMatchModel;

class YandexMarketUpdateStock extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'yandexmarketupdatestock';
    }
    static public function updateMarketStocks($items)
    {
        try {
            $body = self::update($items);
            if ($body != null)
            {
                $client = new Client();
                $headers = [
                    'Authorization' => 'OAuth oauth_token=' . config('yandexmarketupdatestock.token') . ', oauth_client_id=' . config('yandexmarketupdatestock.client_id'),
                    'Content-Type' => 'application/json',
                ];
                $request = new Request('PUT', 'https://api.partner.market.yandex.ru/v2/campaigns/'.config('yandexmarketupdatestock.campaign_id').'/offers/stocks.json', $headers, $body);
                $client->sendAsync($request)->wait();
            }
        }catch (Exception $e){
            Log::error($e->getMessage());
        }
    }

    static public function update($products)
    {
        $stocks = [];
        if (!empty($products)){
            foreach ($products as $product)
            {
                $images = YandexMarketMatchModel::where('one_c_uid', $product['one_c_uid'] )->first();
                if (isset($images))
                {
                    $stocks[] = [
                        "sku" => $images['offer_id'],
                        "warehouseId" => config('yandexmarketupdatestock.wh_id'),
                        "items" =>
                            [
                                [
                                    "type" => "FIT",
                                    "count" =>  $product['quantity'],
                                    "updatedAt" => now()
                                ]
                            ]
                    ];
                }
            }

            $body = '{
                      "skus": '.json_encode($stocks).'
                    }';
            return $body;
        }
    }
}
