<?php

namespace App\Actions\Fortify;

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Models\User;
use App\Models\Cliente;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Support\Facades\Hash;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules, ProfileValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
        ...$this->profileRules(),
        'password' => $this->passwordRules(),
    ])->validate();

    $user = User::create([
    'name' => $input['name'],
    'email' => $input['email'],
    'rol' => 'cliente',
    'password' => Hash::make($input['password']),
]);

if (\Spatie\Permission\Models\Role::where('name', 'cliente')->exists()) {
    $user->assignRole('cliente');
}

Cliente::firstOrCreate([
    'user_id' => $user->id,
]);

return $user;
    }
}
