<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Violation extends AppModel {
    use SoftDeletes;

    protected $fillable = ['name', 'penalty', 'ordinance', 'fine'];
    /**
    * Get the attributes that should be cast.
    *
    * @return array<string, string>
    */
    protected function casts(): array {
        return [ ];
    }

    /**
    * Prepare a date for array / JSON serialization.
    */
    // protected function serializeDate(DateTimeInterface $date): string {
    //     return $date->format('Y-m-d');
    // }

}
