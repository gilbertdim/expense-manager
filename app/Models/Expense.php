<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $fillable = [ 'category_id', 'amount', 'entry_date' ];
    public $appends = [ 'created_date', 'category_name' ];

    public function getCreatedDateAttribute()
    {
        return date_create($this->created_at)->format('Y-m-d');
    }

    public function getCategoryNameAttribute()
    {
        return $this->category->name;
    }

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'category_id', 'id');
    }
}
