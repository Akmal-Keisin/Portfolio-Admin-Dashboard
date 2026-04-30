<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'username', 'password'])]
class Admin extends Authenticatable {}
