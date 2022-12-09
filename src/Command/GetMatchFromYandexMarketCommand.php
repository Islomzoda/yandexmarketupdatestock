<?php

namespace Islomzoda\YandexMarketUpdateStock\Command;

use Islomzoda\YandexMarketUpdateStock\Api\GetMatchFromYandexMarket;
use Illuminate\Console\Command;

class GetMatchFromYandexMarketCommand extends Command
{
    protected  $signature = 'yandex:match';
    protected  $description = 'Данная команда предназначено для загрузки сопоставлений с ЯндексМаркета';
    public function handle(): void
    {
        GetMatchFromYandexMarket::match();
    }

}
