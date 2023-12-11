<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyOwner extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'property_owners';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'property_owner_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'property_owner_name',
        'address',
        'email',
        'user_id',
    ];
}