<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Flight;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Passenger extends Model implements Auditable
{
    use HasFactory, AuditableTrait;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function flights(): BelongsToMany
    {
        return $this->belongsToMany(Flight::class, 'flight_passenger');
    }
}
