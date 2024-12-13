<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'status',
    ];

    // relation one-to-many into projects and tasks
    public function tasks(){
        return $this->hasMany(Task::class);
    }

    // relation many-to-many into projects and users
    public function users(){
        return $this->hasMany(User::class);
    }
}
