<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceItem extends Model
{
    use HasFactory;
    protected $table = "maintenance_items";
    protected $fillable = ['maintenance_id', 'tool_id', 'tool_name', 'price'];

    public function maintenance()
    {
        return $this->belongsTo(Maintenance::class);
    }

    public function tool()
    {
        return $this->belongsTo(Tool::class)->orderBy('name', 'asc');
    }
}
