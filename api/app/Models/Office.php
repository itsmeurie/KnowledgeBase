<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Office extends AppModel {


    use SoftDeletes;

    protected $fillable = [
        'name', 
        'code',
    ];

    /**
    * Get the attributes that should be cast.
    *
    * @return array<string, string>
    */
    protected function casts(): array {
        return [ ];
    }

    public function scopeName(Builder $query, string $name){
        $query->where('name', 'ilike', "%{$name}%");
    }

    public function sections() : HasMany
    {
        return $this->hasMany(Section::class);
    }
}
