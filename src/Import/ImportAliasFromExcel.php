<?php
namespace Islomzoda\YandexMarketUpdateStock\Import;
use Islomzoda\YandexMarketUpdateStock\Model\YandexMarketMatchModel;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportAliasFromExcel implements toArray, withHeadingRow
{

    public function array(array $array) : void
    {
        $items = [];
        foreach ($array as $arr) {
            $items[] = array_filter($arr);
        }
        YandexMarketMatchModel::upsert(array_filter($items), ['one_c_uid']);
    }
    public function headingRow(): int
    {
        return 1;
    }
}
