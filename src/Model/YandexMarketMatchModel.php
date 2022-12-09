<?php
namespace Islomzoda\YandexMarketUpdateStock\Model;
use Illuminate\Database\Eloquent\Model;

class YandexMarketMatchModel extends Model
{
    protected $fillable = [
        'article',
        'one_c_uid'
    ];
}
