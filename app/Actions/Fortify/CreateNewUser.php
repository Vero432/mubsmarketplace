<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        // make the registration number tidy: capitals, no extra spaces
$input['reg_no'] = strtoupper(trim($input['reg_no'] ?? ''));
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'reg_no' => ['required', 'string', 'regex:/^\d{2}\/[A-Z]\/\d{3,6}\/[A-Z]{1,4}$/', 'unique:users,reg_no'],
            'phone'  => ['required', 'string', 'max:20'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $user = User::create([
    'name'     => $input['name'],
    'email'    => $input['email'],
    'password' => Hash::make($input['password']),
    'reg_no'   => $input['reg_no'],
    'phone'    => $input['phone'],
]);

// new accounts wait for an administrator to approve them
$user->status = 'pending';
$user->save();

return $user;
    }
}
