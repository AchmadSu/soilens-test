<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'status',
        'last_repair'
    ];

    public function maintenanceItems()
    {
        return $this->hasMany(MaintenanceItem::class);
    }
}
