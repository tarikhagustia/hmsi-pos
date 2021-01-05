<?php
namespace App\Traits;

use App\Role;
use Illuminate\Support\Facades\Cache;

trait HasRole {
    /**
     * Check User role by name
     * @param string $role
     * @return bool
     */
    public function hasRole(string $role) {
        // Implement cache 60 seconds to speed up
        $roleQuery = Cache::remember('ROLE_USER_'.$this->id, 60 * 5, function (){
            return $this->role;
        });

        return (strtolower($role) === strtolower($roleQuery->name)) ? true : false;
    }

    public function hasAnyRole(array $roles) {
        // Implement cache 60 seconds to speed up
        $roleQuery = Cache::remember('ROLE_USER_'.$this->id, 60 * 5, function () {
            return $this->role;
        });

        $roles = array_map(function($arr){
            return strtolower($arr);
        }, $roles);

        return in_array(strtolower($roleQuery->name), $roles);
    }

    public function assignRole(string $role) {
        // Clear cache
        Cache::forget('ROLE_USER_'.$this->id);

        $role = Role::where('name', $role)->firstOrFail();

        $this->role_id = $role->id;
        $this->save();

        return $role;
    }
}
