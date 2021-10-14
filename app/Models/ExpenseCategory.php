<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    use HasFactory;
    protected $fillable = [ 'name', 'description' ];
    public $appends = [ 'created_date' ];

    public function getCreatedDateAttribute()
    {
        return date_create($this->created_at)->format('Y-m-d');
    }
}
