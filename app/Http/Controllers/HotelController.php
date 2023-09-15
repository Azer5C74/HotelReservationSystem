<?php

namespace App\Http\Controllers;

use App\Http\Requests\HotelRequest;
use App\Models\Hotel;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class HotelController extends Controller
{


    public function __construct()
    {

        // Apply the 'role:staff' middleware to specific methods.
        $this->middleware('role:staff')->only(['store', 'update', 'destroy']);
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        // Check if the data is already cached
        if (Cache::has('cached_hotels')) {
            $hotels = Cache::get('cached_hotels');
        } else {
            // If not cached, retrieve data from the database
            $hotels = Hotel::paginate(10);
            // Cache the data for 1 hour
            Cache::put('cached_hotels', $hotels, 60 * 60);
        }
        if (count($hotels) == 0) {
            return response()->json(status: 204);
        }

        return response()->json(['hotels' => $hotels]);
    }


    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $hotel = Hotel::with('rooms')->find($id);

        if (!$hotel) {
            return response()->json(['message' => 'Hotel not found'], 404);
        }

        return response()->json(['hotel' => $hotel]);
    }

    /**
     * @param HotelRequest $request
     * @return JsonResponse
     */
    public function store(HotelRequest $request): JsonResponse
    {
        $hotel = Hotel::create([
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'location' => $request->input('location'),
        ]);

        return response()->json(['hotel' => $hotel], 201);
    }

    /**
     * @param HotelRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(HotelRequest $request, int $id): JsonResponse
    {
        $hotel = Hotel::find($id);

        if (!$hotel) {
            return response()->json(['message' => 'Hotel not found'], 404);
        }

        // Validation has already been performed by the HotelRequest class.
        $hotel->update([
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'location' => $request->input('location'),
        ]);

        return response()->json(['hotel' => $hotel], 200);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $hotel = Hotel::find($id);

        if (!$hotel) {
            return response()->json(['message' => 'Hotel not found'], 404);
        }

        $hotel->delete();

        return response()->json(['message' => 'Hotel deleted'], 204);
    }

}
