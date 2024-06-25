<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Flight;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class FlightController extends Controller
{
    public function index(Request $request)
    {
        $flights = QueryBuilder::for(Flight::class)
            ->with('passengers')
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::exact('number'),
                AllowedFilter::exact('departure_city'),
                AllowedFilter::exact('arrival_city'),
                AllowedFilter::exact('departure_time'),
                AllowedFilter::exact('arrival_time'),

            ])
            ->allowedSorts(['id', 'number', 'departure_city', 'arrival_city', 'departure_time', 'arrival_time', 'created_at', 'updated_at'])
            ->paginate($request->input('per_page', 100));
        return response()->json($flights);
    }

    public function passengers(Request $request, $id)
    {
        $flight = Flight::with('passengers')->findOrFail($id);
        return response()->json($flight->passengers);
    }
}
