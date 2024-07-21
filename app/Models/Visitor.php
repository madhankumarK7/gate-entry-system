<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Visitor extends Model
{
    use HasFactory;

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function($squery) use($search) {
                $squery->where('name', 'like', '%'.$search.'%')
                       ->orWhere('mobile', 'like', '%'.$search.'%')
                       ->orWhere('address', 'like', '%'.$search.'%')
                       ->orWhere('gender', 'like', '%'.$search.'%')
                       ->orWhere('age', 'like', '%'.$search.'%');
            });
        });
    }


}
