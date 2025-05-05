<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Veelasky\LaravelHashId\Eloquent\HashableId;

use App\Traits\PaginatesTrait;

class AppModel extends Model {
    use HasFactory, HashableId, PaginatesTrait;

    public static function getTableName() {
        return with(new static())->getTable();
    }

    public function resolveRouteBinding($value, $field = null) {
        if (is_numeric($value)) {
            throw new \Exception("Invalid ID");
        }

        if ($field || is_numeric($value)) {
            return parent::resolveRouteBinding($value, $field);
        }

        return $this->byHash($value);
    }
}
