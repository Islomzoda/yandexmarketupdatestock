<?php

return [
    'campaign_id' => env('YA_MARKET_API_CAMPAIGN_ID'),
    'token' => env('YA_MARKET_API_TOKEN'),
    'client_id' => env('YA_MARKET_API_CLIENT_ID'),
    'wh_id' => env('YA_MARKET_API_WAREHOUSES'),
    'match_url' => 'https://api.partner.market.yandex.ru/v2/campaigns/' . env('YA_MARKET_API_CAMPAIGN_ID') . '/offer-mapping-entries.json?limit=200&page_token='
];
