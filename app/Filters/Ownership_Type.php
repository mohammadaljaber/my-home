<?php
namespace App\Filters;
use Closure;
use Illuminate\Database\Eloquent\Builder;

class Ownership_Type{
    public function handle(Builder $query,Closure $next)
    {
        if(request()->has('ownership_type')){
            $query->where('ownership_type',request()->input('ownership_type'));
        }
        return $next($query);
    }
}

?>