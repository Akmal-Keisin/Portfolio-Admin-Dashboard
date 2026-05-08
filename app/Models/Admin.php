<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Foundation\Auth\User as Authenticatable;

#[Fillable(['name', 'username', 'password'])]
class Admin extends Authenticatable {}
