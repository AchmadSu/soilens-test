<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    protected $table = "maintenances";
    protected $fillable = ['code', 'user_id', 'status', 'total_item', 'start_date', 'end_date', 'expired_at'];
    protected $dates = ['start_date', 'end_date', 'expired_at'];

    public function items()
    {
        return $this->hasMany(MaintenanceItem::class);
    }

    public function requester()
    {
        return $this->belongsTo(User::class);
    }

    public function acceptance()
    {
        return $this->belongsTo(User::class);
    }
}
