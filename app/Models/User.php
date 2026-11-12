<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([ 'name','email','password','role','department_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    public function department(): BelongsTo
{
    return $this->belongsTo(Department::class);
}

public function tickets(): HasMany
{
    return $this->hasMany(Ticket::class);
}

public function assignedTickets(): HasMany
{
    return $this->hasMany(Ticket::class, 'technician_id');
}

public function comments(): HasMany
{
    return $this->hasMany(TicketComment::class);
}

public function attachments(): HasMany
{
    return $this->hasMany(TicketAttachment::class);
}

public function ticketHistories(): HasMany
{
    return $this->hasMany(TicketHistory::class);
}
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
