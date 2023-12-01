<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MatchInvitationRole implements Rule
{
protected $role;

public function __construct($role)
{
$this->role = $role;
}

public function passes($attribute, $value)
{
return $value === $this->role;
}

public function message()
{
return 'El campo :attribute no coincide con el código de invitación.';
}
}