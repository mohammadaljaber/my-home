<?php
namespace App\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class Space{
    public function handle(Builder $query,Closure $next)
    {
        if(request()->has('min_space')){
            $query->where('space','>=',request()->input('min_space'));
        }
        if(request()->has('max_space')){
            $query->where('space','<=',request()->input('max_space'));
        }
        return $next($query);
    }
}