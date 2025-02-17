<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /** @use HasFactory<\Database\Factories\ProjectFactory> */
    use HasFactory;


    protected $fillable = ['title', 'description', 'start_date', 'end_date', 'status', 'user_id'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

     // Relation : Un projet peut avoir plusieurs utilisateurs
     public function users()
     {
         return $this->belongsToMany(User::class)->withPivot('role')->withTimestamps();
     }
}
