<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class todolist extends Model
{
    protected $table = "todolists";
    protected $fillable = ['title','status'];
}
