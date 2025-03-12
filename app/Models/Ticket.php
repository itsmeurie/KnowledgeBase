<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends AppModel
{
    use SoftDeletes;

    protected $fillable = ['violator_id', 'citation_number', 'status'];

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
    protected $hidden = [
        'violator_id',
     ];
     
    public function violator()
    {
        return $this->belongsTo(Violator::class);
    }
}
