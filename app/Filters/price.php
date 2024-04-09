<?php


namespace App\Filters;

use App\Models\House;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class price{
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








// ->when(request()->has('min_price'),
//         fn($q)=>$q->where('price','>=',request()->input('min_price')))
//         ->when(request()->has('max_price'),
//         fn($q)=>$q->where('price','<=',request()->input('max_price')));