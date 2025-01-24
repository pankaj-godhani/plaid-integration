<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\State;

class ValidStateRule implements Rule
{
    private $state;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($name)
    {
        if ($name) {
            $this->state = State::where('name', $name)->first();
        }
    }

    /**
     * Returns true if the state is available.
     */
    public function passes($attribute, $value)
    {
        return $this->state->is_available == true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Unfortunately, due to the current laws in the state of ' .
            $this->state->name .
            ' we are unable to lease to this customer at this time, and must cancel this application.';
    }
}
