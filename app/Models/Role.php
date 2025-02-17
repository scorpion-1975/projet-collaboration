<?php

namespace App\Models;


use App\Models\Permission;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function assignPermission($permissionName)
    {
        $permission = Permission::where('name', $permissionName)->first();
        $this->permissions()->attach($permission);
    }
}
