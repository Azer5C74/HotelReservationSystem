<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Models\Reservation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Ensure the user is authenticated for all methods.

        // Apply the 'role:staff' middleware to specific methods.
        $this->middleware('role:staff')->only(['index', 'destroy']);
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        // Check if the data is already cached
        if (Cache::has('cached_reservations')) {
            $reservations = Cache::get('cached_reservations');
        } else {
            // If not cached, retrieve data from the database
            $reservations = Reservation::paginate(10);
            // Cache the data for 1 hour
            Cache::put('cached_reservations', $reservations, 60 * 60);
        }
        if (count($reservations) == 0) {
            return response()->json(status: 204);
        }

        return response()->json(['hotels' => $reservations]);
    }

    /**
     * @param Reservation $reservation
     * @return JsonResponse
     */
    public function show(Reservation $reservation): JsonResponse
    {
        return response()->json(['reservation' => $reservation]);
    }

    /**
     * @param ReservationRequest $request
     * @return JsonResponse
     */
    public function store(ReservationRequest $request): JsonResponse
    {
        $data = $request->validated();

        $reservation = Reservation::create($data);

        return response()->json(['reservation' => $reservation], 201);
    }

    /**
     * @param ReservationRequest $request
     * @param Reservation $reservation
     * @return JsonResponse
     */
    public function update(ReservationRequest $request, Reservation $reservation): JsonResponse
    {
        $data = $request->validated();

        $reservation->update($data);

        return response()->json(['reservation' => $reservation], 200);
    }

    /**
     * @param Reservation $reservation
     * @return JsonResponse
     */
    public function destroy(Reservation $reservation): JsonResponse
    {
        $reservation->delete();
        return response()->json(['message' => 'Reservation deleted'], 204);
    }
}
