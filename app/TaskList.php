<?php

namespace App;

use App\Task;
use App\User;
use Illuminate\Database\Eloquent\Model;

class TaskList extends Model
{
    protected $fillable = ['name'];
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
