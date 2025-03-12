<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;


use App\Models\Ticket;
use App\Models\Gender;

class Violator extends AppModel
{
    use SoftDeletes;

    protected $fillable = ['first_name', 'middle_name', 'last_name', 'gender_id'];

    protected $appends = [
        'fullname',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [];
    }

    /**
     * Prepare a date for array / JSON serialization.
     */
    // protected function serializeDate(DateTimeInterface $date): string {
    //     return $date->format('Y-m-d');
    // }

    protected $hidden = ['gender_id'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name}");
    }
}
