<?php

namespace App\Models;
use Illuminate\DAtabase\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends AppModel {

    use SoftDeletes;

    protected $fillable = [
        'title',
        'office_id',
        'description',
        'slug',
    ];

    /**
    * Get the attributes that should be cast.
    *
    * @return array<string, string>
    */
    protected function casts(): array {
        return [ ];
    }

    public function office() : BelongsTo
    {
        return $this->belongsTo(Office::class);
    }

    public function subSections() : HasMany
    {
        return $this->hasMany(Section::class, 'parent_id');
    }

    public function document() : HasOne
    {
        return $this->hasOne(Documents::class);
    }

    public function scopeSlug(Builder $query, string $slug) : void
    {
        $query->where('slug', $slug);
    }
    
    
    /**
    * Prepare a date for array / JSON serialization.
    */
    // protected function serializeDate(DateTimeInterface $date): string {
    //     return $date->format('Y-m-d');
    // }
    
}
