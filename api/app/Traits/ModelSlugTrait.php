<?php

namespace App\Traits;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\Schema;

trait ModelSlugTrait
{
    /**
     * Boot the trait to automatically generate a slug on model creation.
     */
    protected static function bootModelSlugTrait()
    {
        $hasSlugField = Schema::hasColumn(self::class, self::$slug_field ?? 'slug');
        $slugTarget = self::$slug_target ?? "name";
        $slugField = self::$slug_field ?? "slug";

        static::creating(function ($model) use ($hasSlugField, $slugTarget, $slugField) {
            if ($hasSlugField && empty($model->slug)) {
                $model[$slugField] = self::slugify($model[$slugTarget]);
            }
        });

        static::updating(function ($model) use ($hasSlugField, $slugTarget, $slugField) {
            if ($hasSlugField && empty($model->slug)) {
                $model[$slugField] = self::slugify($model[$slugTarget], $model->id);
            }
        });
    }

    /**
     * Generate a unique slug.
     */
    public static function slugify(string $title, int $id = 0): string
    {
        $slug = Str::slug($title);
        $allSlugs = self::getRelatedSlugs($slug, self::class, $id);

        if (!$allSlugs->contains("slug", $slug)) {
            return $slug;
        }

        $i = 1;
        do {
            $newSlug = $slug . "-" . $i;
            if (!$allSlugs->contains("slug", $newSlug)) {
                return $newSlug;
            }
            $i++;
        } while (true);
    }

    /**
     * Get existing slugs that match the base slug.
     */
    private static function getRelatedSlugs(string $slug, string $modelName, int $id = 0)
    {
        $model = app($modelName);
        return $model
            ->select("slug")
            ->where("slug", "like", $slug . "%")
            ->where("id", "<>", $id)
            ->get();
    }
}
