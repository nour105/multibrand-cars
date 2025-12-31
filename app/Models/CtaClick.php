<?php
// app/Models/CtaClick.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CtaClick extends Model
{
    protected $fillable = ['cta', 'car_id', 'car_name'];
}
