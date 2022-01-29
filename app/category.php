<?php

namespace App;

use App\Services\Traits\couponable;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    use couponable;
}
