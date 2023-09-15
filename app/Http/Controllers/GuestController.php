<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuestRequest;
use App\Models\Guest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class GuestController extends Controller
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
        if (Cache::has('cached_guests')) {
            $guests = Cache::get('cached_guests');
        } else {
            // If not cached, retrieve data from the database
            $guests = Guest::paginate(10);
            // Cache the data for 1 hour
            Cache::put('cached_guests', $guests, 60 * 60);
        }
        if (count($guests) == 0) {
            return response()->json(status: 204);
        }

        return response()->json(['guests' => $guests]);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $guest = Guest::find($id);

        if (!$guest) {
            return response()->json(['message' => 'Guest not found'], 404);
        }

        return response()->json(['guest' => $guest]);
    }

    /**
     * @param GuestRequest $request
     * @return JsonResponse
     */
    public function store(GuestRequest $request): JsonResponse
    {
        $guest = Guest::create($request->all());

        return response()->json(['guest' => $guest], 201);
    }

    /**
     * @param GuestRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(GuestRequest $request, int $id): JsonResponse
    {
        $guest = Guest::find($id);

        if (!$guest) {
            return response()->json(['message' => 'Guest not found'], 404);
        }

        $guest->update($request->all());

        return response()->json(['guest' => $guest], 200);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $guest = Guest::find($id);

        if (!$guest) {
            return response()->json(['message' => 'Guest not found'], 404);
        }

        $guest->delete();

        return response()->json(['message' => 'Guest deleted'], 204);
    }
}
