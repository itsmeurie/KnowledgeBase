<?php

namespace App\Models;
use Illuminate\DAtabase\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ModelSlugTrait;

use Laravel\Scout\Searchable;

class Section extends AppModel {
    use SoftDeletes, ModelSlugTrait, Searchable;

    protected $fillable = ["title", "office_id", "parent_id", "description", "contents", "slug"];

    protected static $slug_target = "title";

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array {
        return [];
    }

    public function office(): BelongsTo {
        return $this->belongsTo(Office::class);
    }

    public function subSections(): HasMany {
        return $this->hasMany(Section::class, "parent_id");
    }

    public function files(): MorphMany {
        return $this->morphMany(File::class, "filable");
    }

    public function scopeSlug(Builder $query, string $slug): void {
        $query->where("slug", $slug);
    }

    public function toSearchableArray() {
        return [
            "parent_id" => $this->id,
            "title" => $this->title,
            "description" => $this->description,
            "contents" => $this->contents,
        ];
    }

    /**
     * Prepare a date for array / JSON serialization.
     */
    // protected function serializeDate(DateTimeInterface $date): string {
    //     return $date->format('Y-m-d');
    // }
}
