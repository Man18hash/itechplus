<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Project;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'project_id',
        'status',
    ];

    /**
     * The user (purchaser) who added this item.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The project that was added.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
