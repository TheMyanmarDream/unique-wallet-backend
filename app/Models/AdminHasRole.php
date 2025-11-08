<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminHasRole extends Model
{
    use HasFactory;

    protected $table = 'admin_has_roles';

    protected $fillable = [
        'admin_id',
        'role_id'
    ];

    public function role(){
        return $this->belongsTo(Role::class ,'role_id');
    }

    public function admin(){
        return $this->belongsTo(Admin::class ,'admin_id');
    }
}
