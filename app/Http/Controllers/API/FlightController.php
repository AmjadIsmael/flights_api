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

    public function show(Flight $flight)
    {
        return response($flight->load('passengers'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'flight_number' => 'required|string|unique:flights',
            'departure_airport' => 'required|string',
            'arrival_airport' => 'required|string',
            'departure_time' => 'required|date_format:Y-m-d H:i:s',
            'arrival_time' => 'required|date_format:Y-m-d H:i:s',
        ]);

        $flight = Flight::create($validatedData);

        return response()->json($flight, 201);
    }
    public function update(Request $request, Flight $flight)
    {
        $validatedData = $request->validate([
            'flight_number' => 'required|string|unique:flights,flight_number,' . $flight->id,
            'departure_airport' => 'required|string',
            'arrival_airport' => 'required|string',
            'departure_time' => 'required|date_format:Y-m-d H:i:s',
            'arrival_time' => 'required|date_format:Y-m-d H:i:s',
        ]);

        $flight->update($validatedData);

        return response()->json($flight);
    }
    public function destroy(Flight $flight)
    {
        $flight->delete();
        return response()->json(null, 204);
    }
}
