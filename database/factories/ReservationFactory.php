<?php

namespace Database\Factories;

use App\Models\Guest;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Reservation>
 */
class ReservationFactory extends Factory
{
    public function definition()
    {
        $room = Room::factory()->create();

        return [
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'status' => $this->faker->randomElement(['cancelled', 'paid', 'completed', 'ongoing', 'pending payment', 'drafted']),
            'room_id' => $room->id
        ];
    }

    // Factory method to attach guests to a reservation
    public function withGuests($guestCount = 2)
    {
        return $this->afterCreating(function (Reservation $reservation) use ($guestCount) {
            // Attach random guests to the reservation
            $guests = Guest::inRandomOrder()->limit($guestCount)->get();
            $reservation->guests()->attach($guests);
        });
    }
}
