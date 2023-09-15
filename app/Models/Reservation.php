<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable = [
        'start_date',
        'end_date',
        'status',
        'room_id',
        'guest_id'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // Define the status values as an enumeration
    public const STATUS_CANCELLED = 'cancelled';
    public const STATUS_PAID = 'paid';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_ONGOING = 'ongoing';
    public const STATUS_PENDING_PAYMENT = 'pending payment';
    public const STATUS_DRAFTED = 'drafted';

    // Define the relationship with the Room model (one-to-one)
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    // Define the relationship with the Guest model (many-to-many)
    public function guests(): BelongsToMany
    {
        return $this->belongsToMany(Guest::class);
    }
}
