<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Office extends AppModel {
    use SoftDeletes;

    protected $fillable = ["name", "code", "description"];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array {
        return [];
    }

    public function scopeName(Builder $query, string $name) {
        $query->where("name", "ilike", "%{$name}%");
    }

    public function scopeCode(Builder $query, string $code) {
        $query->where("code", "ilike", $code);
    }

    public function images(): BelongsToMany {
        return $this->belongsToMany(Office::class, "profile_images", "office_id", "image_id")->withPivot("primary");
    }

    public function sections(): HasMany {
        return $this->hasMany(Section::class);
    }

    protected $dates = ["deleted_at"];
}
