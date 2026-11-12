<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'ticket_number',
        'user_id',
        'technician_id',
        'category_id',
        'department_id',
        'title',
        'description',
        'location',
        'priority',
        'status',
        'resolved_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function history()
    {
        return $this->hasMany(TicketHistory::class)
            ->orderBy('created_at', 'asc');
    }

    public function comments()
    {
        return $this->hasMany(TicketComment::class)
            ->latest();
    }

    public function attachments()
    {
        return $this->hasMany(TicketAttachment::class)
            ->latest();
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'resolved_at' => 'datetime',
        ];
    }
}
