<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Passenger;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Flight extends Model implements Auditable
{
    use HasFactory, AuditableTrait;
    protected $guarded = ['id', 'created_at', 'updated_at'];


    public function passengers(): BelongsToMany
    {
        return $this->belongsToMany(Passenger::class, 'flight_passenger');
    }
}
