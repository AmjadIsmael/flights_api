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

    public function show(Passenger $passenger)
    {
        return response()->json($passenger);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:passengers,email',
            'password' => 'required|unique:passengers,password',
            'date_of_birth' => 'required|date',
            'passport_expiry' => 'required|date',
            'flight_id' => 'required|exists:flights,id',
        ]);

        $passenger = Passenger::create($validatedData);

        return response()->json($passenger, 201);
    }

    public function update(Request $request, Passenger $passenger)
    {
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:passengers,email,' . $passenger->id,
            'password' => 'required|unique:passengers,password,' . $passenger->id,
            'date_of_birth' => 'required|date',
            'passport_expiry' => 'required|date',
            'flight_id' => 'required|exists:flights,id',
        ]);

        $passenger->update($validatedData);

        return response()->json($passenger);
    }

    public function destroy(Passenger $passenger)
    {
        $passenger->delete();
        return response()->json(null, 204);
    }
}
