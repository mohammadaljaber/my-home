<?php
namespace App\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class Price{
    public function handle(Builder $query,Closure $next)
    {
        if(request()->has('min_price')){
            $query->where('price','>=',request()->input('min_price'));
        }
        if(request()->has('max_price')){
            $query->where('price','<=',request()->input('max_price'));
        }
        return $next($query);
    }
}







