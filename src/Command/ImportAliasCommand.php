<?php

namespace Islomzoda\YandexMarketUpdateStock\Command;

use Illuminate\Console\Command;
use Islomzoda\YandexMarketUpdateStock\Import\ImportAliasFromExcel;
use Maatwebsite\Excel\Facades\Excel;

class ImportAliasCommand extends Command
{
    protected $signature = 'yandex:alias';
    protected $description = 'Данная команда будеть брать загружать сопоставление с хранилеша';
    public function handle(): void
    {
        $path = storage_path('app/asset/alias.xlsx');
        Excel::import(new ImportAliasFromExcel, $path);
    }
}
