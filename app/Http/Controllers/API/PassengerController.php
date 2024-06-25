<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Passenger;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class PassengerController extends Controller
{
    public function index(Request $request)
    {
        $passengers = QueryBuilder::for(Passenger::class)->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::exact('first_name'),
                AllowedFilter::exact('last_name'),
                AllowedFilter::exact('email'),

            ])
            ->allowedSorts(['id', 'first_name', 'last_name', 'email', 'created_at', 'updated_at'])
            ->paginate();
    }
}
