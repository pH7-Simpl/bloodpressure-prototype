<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueAcrossTables implements Rule
{
    protected $tables;
    protected $column;
    protected $ignoreTable;
    protected $ignoreId;

public function __construct(array $tables, string $column, $ignoreTable = null, $ignoreId = null)
{
    $this->tables = $tables;
    $this->column = $column;
    $this->ignoreTable = $ignoreTable;
    $this->ignoreId = $ignoreId;
}

public function passes($attribute, $value)
{
    foreach ($this->tables as $table) {
        $query = DB::table($table)->where($this->column, $value);

        // Ignore the current record if table and ID are provided
        if ($this->ignoreTable === $table && $this->ignoreId) {
            $query->where('id', '!=', $this->ignoreId);
        }

        if ($query->exists()) {
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
