<?php
namespace Islomzoda\YandexMarketUpdateStock\Api;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Log;
use Islomzoda\YandexMarketUpdateStock\Model\YandexMarketMatchModel;

class GetMatchFromYandexMarket
{
    static public function match(): void
    {
        try {
            $pageToken  = '';
            $data = [];
            do{
                $client = new Client();
                $headers = [
                    'Authorization' => 'OAuth oauth_token='.config('yandexmarketupdatestock.token').', oauth_client_id='. config('yandexmarketupdatestock.client_id'),
                ];
                $request = new Request('GET',  config('yandexmarketupdatestock.match_url') . $pageToken, $headers);
                $res = $client->sendAsync($request)->wait();
                $items = json_decode($res->getBody(), true);
                if (isset($items['result']['offerMappingEntries'])){
                    foreach ($items['result']['offerMappingEntries'] as $item){
                        if (isset($item['offer']['name'])){
                            $data[] = [
                                'market_sku' => $item['mapping']['marketSku'],
                                'offer_id' => $item['offer']['shopSku'],
                            ];
                        }
                    }
                }
                isset($items['result']['paging']['nextPageToken']) ? $pageToken = $items['result']['paging']['nextPageToken'] : $pageToken = false;
            }while($pageToken != false);
            YandexMarketMatchModel::upsert($data, ['offer_id']);
        }catch (Exception $e){
            Log::error($e->getMessage());
        }
    }
}
