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
        $passengers = QueryBuilder::for(Passenger::class)
            ->with('flights')
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::exact('first_name'),
                AllowedFilter::exact('last_name'),
                AllowedFilter::exact('email'),
                AllowedFilter::exact('date_of_birth'),
                AllowedFilter::exact('passport_expiry'),

            ])
            ->allowedSorts(['id', 'first_name', 'last_name', 'email', 'date_of_birth', 'passport_expiry', 'created_at', 'updated_at'])
            ->paginate($request->input('per_page', 100));
        return response()->json($passengers);
    }
}
