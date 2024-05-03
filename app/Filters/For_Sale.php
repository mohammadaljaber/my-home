<?php
namespace App\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class For_Sale{
    public function handle(Builder $query,Closure $next)
    {
        if(request()->has('is_for_sale')){
            $query->where('is_for_sale',request()->input('is_for_sale'));
        }
        return $next($query);
    }
}