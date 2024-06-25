<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Flight;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class FlightPassengerController extends Controller
{
    public function index(Request $request, $flightId)
    {
        $flight = Flight::findOrFail($flightId);
        $passengers = QueryBuilder::for($flight->passengers())
            ->with('flights')
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::partial('first_name'),
                AllowedFilter::partial('last_name'),
                AllowedFilter::partial('email'),
                AllowedFilter::exact('date_of_birth'),
                AllowedFilter::exact('passport_expiry'),
            ])
            ->allowedSorts(['id', 'first_name', 'last_name', 'email', 'date_of_birth', 'passport_expiry', 'created_at', 'updated_at'])
            ->paginate($request->input('per_page', 100));

        return response()->json($passengers);
    }
}
