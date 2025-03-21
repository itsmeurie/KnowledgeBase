<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Documents extends AppModel {
    use SoftDeletes;


    protected $fillable = [
        'section_id',
        'contents'
    ];

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
