<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueAcrossTables0 implements Rule
{
    protected $tables;
    protected $column;

    /**
     * Create a new rule instance.
     *
     * @param array $tables
     * @param string $column
     */
    public function __construct(array $tables, string $column)
    {
        $this->tables = $tables;
        $this->column = $column;
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
        foreach ($this->tables as $table) {
            if (DB::table($table)->where($this->column, $value)->exists()) {
                return false;
            }
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
        return 'The :attribute must be unique across all accounts.';
    }
}
