<?php
namespace LaravelRouteLog\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RouteLog
 * @package LaravelRouteLog\Models
 */
class RouteLog extends Model {
    protected $guarded = ['id'];
    public $timestamps = false;

    public function scopeForDate(Builder $builder, $date){
        if($date instanceof \DateTimeInterface){
            $date = $date->format('Y-m-d');
        }
        return $builder->where('requested_at', $date);
    }

    public function scopeForPeriod(Builder $builder, $periodStart, $periodEnd = null){
        if(is_array($periodStart)){
            [$periodStart, $periodEnd] = $periodStart;
        }

        return $builder->whereBetween('requested_at', [$periodStart, $periodEnd]);
    }
}