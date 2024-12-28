<?php

namespace App\Http\Requests\Api\V1\Auth;

use Illuminate\Support\Facades\Hash;
use App\Models\User;

trait GetRegisterFieldAndValueTrait
{

    public function getFillableColumn($model): array
    {
        return $model->getFillable();
    }

    public function getFieldNameAndValue(): array
    {
        $fields = $this->getFillableColumn(new User);
        $values = array();
        foreach ($fields as $field) {

            $value = $this->input($field);

            if ($value && $field === 'password') {
                $value = Hash::make(($value));
            }
            if ($value) {
                $values[$field] = $value;
            }
        }

        return $values;
    }
}
