<?php

namespace App\Permission\Traits;

trait UserTrait {
    //en: from here
    public function roles(){
        return $this->belongsToMany('App\Permission\Models\Role')->withTimesTamps();
    }

    public function havePermission($permission){
        foreach ($this->roles as $role) {
            //comprobamos que lo que tengamos en el campo full-access es igual a yes retornamos true
            if ($role['full-access']== 'yes') {
                return true;
            }

            foreach ($role->permissions as $perm) {
                if ($perm->slug == $permission) {
                    return true;
                }
            }
            return false;
        }
    }
}
