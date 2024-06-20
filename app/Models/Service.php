<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';
    protected $fillable = [
        'name',
        'description',
        'duration',
        'price',
        'is_active',
    ];

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class, 'company_service');
    }

    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'employee_service');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
