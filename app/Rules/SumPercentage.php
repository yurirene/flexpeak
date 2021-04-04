<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class SumPercentage implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $total=0;
        
        foreach($value as $percent){
            $total += floatval($percent);
        }
        if($total!=100){
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Os percentuais não totalizam 100%';
    }
}
