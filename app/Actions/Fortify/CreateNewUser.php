<?php

namespace App\Actions\Fortify;

use App\Models\Roles;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;
    use HasRoles;
    
    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'rol'=>['required'],
            'taller'=>['numeric'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();
        
        $user=User::create([
            'name' => $input['name'],
            'email' => $input['email'],            
            'password' => Hash::make($input['password'])           
        ]);
        if($input['rol']=="Administrador taller"){
            $user->update(["taller"=>$input["taller"]]);
        }      
        //$rol=Role::find($input['rol']); 
        $user->assignRole($input['rol']);
        //$user->assignRole($rol->name);
        return $user;
    }
}
