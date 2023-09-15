<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomRequest;
use App\Models\Room;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RoomController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth'); // Ensure the user is authenticated for all methods.

        // Apply the 'role:staff' middleware to specific methods.
        $this->middleware('role:staff')->only(['store', 'update', 'destroy']);
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        // Check if the data is already cached
        if (Cache::has('cached_rooms')) {
            $rooms = Cache::get('cached_rooms');
        } else {
            // If not cached, retrieve data from the database
            $rooms = Room::paginate(20);
            // Cache the data for 1 hour
            Cache::put('cached_rooms', $rooms, 60 * 60);
        }
        if (count($rooms) == 0) {
            return response()->json(status: 204);
        }

        return response()->json(['rooms' => $rooms]);
    }

    /**
     * @param Room $room
     * @return JsonResponse
     */
    public function show(Room $room): JsonResponse
    {
        return response()->json(['room' => $room]);
    }

    /**
     *
     * @param RoomRequest $request
     * @return JsonResponse
     */
    public function store(RoomRequest $request): JsonResponse
    {
        $room = Room::create($request->all());
        return response()->json(['room' => $room], 201);
    }

    /**
     *
     * @param RoomRequest $request
     * @param Room $room
     * @return JsonResponse
     */
    public function update(RoomRequest $request, Room $room): JsonResponse
    {
        $room->update($request->all());
        return response()->json(['room' => $room], 200);
    }

    /**
     *
     * @param Room $room
     * @return JsonResponse
     */
    public function destroy(Room $room): JsonResponse
    {
        $room->delete();
        return response()->json(['message' => 'Room deleted'], 204);
    }
}
