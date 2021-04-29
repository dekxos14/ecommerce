<?php

namespace App\Validation;

use Respect\Validation\Exceptions\NestedValidationException;

class Validator
{
    private $errors;

    public function validate($request, array $rules)
    {
        foreach ($rules as $field => $rule) {
            try {
                $rule->setName(ucfirst($field))->assert($request->getParam($field));
            } catch (NestedValidationException $e) {
                $errors = $e->findMessages([
                    'notEmpty' => 'Esse campo não pode está vazio',
                    'email' => 'Insira um email válido',
                    'length' => 'O nome tem que ter mais de 10 caracteres'
                ]);
                $filteredErrors = array_filter($errors); // Ensure the array is not containing empty values.
                $this->errors[$field] = $filteredErrors;
           }
        }

        $_SESSION['errors'] = $this->errors;

        return $this;
    }

    public function failed()
    {
        return !empty($this->errors);
    }
}