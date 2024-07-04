<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Passenger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class PassengerController extends Controller
{
    protected $allowedSorts = ['id', 'first_name', 'last_name', 'email', 'date_of_birth', 'passport_expiry', 'created_at', 'updated_at'];

    public function index(Request $request)
    {
        $cacheKey = 'passengers';
        $passengers = Cache::remember($cacheKey, 60, function () use ($request) {
            $query = Passenger::with('flights');

            if ($request->has('first_name')) {
                $query->where('first_name', $request->input('first_name'));
            }

            if ($request->has('last_name')) {
                $query->where('last_name', $request->input('last_name'));
            }

            if ($request->has('email')) {
                $query->where('email', $request->input('email'));
            }

            if ($request->has('date_of_birth')) {
                $query->where('date_of_birth', $request->input('date_of_birth'));
            }

            if ($request->has('passport_expiry')) {
                $query->where('passport_expiry', $request->input('passport_expiry'));
            }

            $sortField = $request->input('sort', 'id');
            $sortDirection = $request->input('direction', 'asc');

            if (in_array($sortField, $this->allowedSorts)) {
                $query->orderBy($sortField, $sortDirection);
            }

            return $query->paginate($request->input('per_page', 100));
        });

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
        cache::forget('passengers');
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
        cache::forget('passengers');

        return response()->json($passenger);
    }

    public function destroy(Passenger $passenger)
    {
        $passenger->delete();
        cache::forget('passengers');

        return response()->json(null, 204);
    }
}
