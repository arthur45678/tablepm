<?php

namespace App\Models;

use App\Models\Trans\TasksForAdvertCompaniesTrans;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class TasksForAdvertCompanies extends Model
{
    protected $table = 'tasksAdvertisersCompanies';
    protected $fillable = ['status', 'img', 'title', 'text', 'advertcompanies_id', 'user_id'];


}
