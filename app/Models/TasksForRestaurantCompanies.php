<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TasksForRestaurantCompanies extends Model
{
    protected $table = 'tasksRestaurantCompanies';
    protected $fillable = ['status', 'img', 'title', 'text', 'restCompanies_id', 'user_id'];
}
