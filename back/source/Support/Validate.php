<?php

namespace Source\Support;

use Exception;
use Source\Support\Message;

class Validate
{
    private Message $message;

    private array $data_to_validate;
    private array $errors = [];

    public function __construct(array $data_to_validate)
    {
        $this->data_to_validate = $data_to_validate;

        $this->message = new Message(PATH['language'] . '/' . LANGUAGE, 'validation', 'php');
    }

    public function validate(array $rules)
    {
        foreach ($this->data_to_validate as $key => $value) {

            if (array_key_exists($key, $rules)) {

                $this->execute($key, $value, $rules[$key]);
            }
        }
    }

    protected function execute(string $key, string $value, array $rules)
    {
        $standardized_rules = $this->standardizeRules($rules);

        foreach ($standardized_rules as $method => $parameter) {

            $result = $this->$method($key, $value, $parameter);

            if ($result === true) continue;

            $this->errors[$key] = $result;

        }
    }

    protected function standardizeRules(array $rules): array
    {
        $standardized_rules = [];

        foreach ($rules as $rule) {

            [$method, $parameter] = $this->rule($rule);

            $standardized_rules[$method] = $parameter;
        }

        return $standardized_rules;
    }

    protected function rule(string $rule): array
    {
        $rule = explode(':', $rule);

        $method = $rule[0];
        $parameter = $rule[1] ?? null; 

        return [$method, $parameter];
    }

    protected function max($key, $value, int $max): bool|string
    {
        if (strlen($value) > $max)
            return $this->message->get(['max' => 'string'], attribute: $key, parameter: $max);

        return true;
    }

    protected function min($key, $value, int $min): bool|string
    {
        if (strlen($value) < $min)
            return $this->message->get(['min' => 'string'], attribute: $key, parameter: $min);

        return true;
    }


    protected function required($key, $value): bool|string
    {
        if (empty($value)) return $this->message->get('required', attribute: $key);

        return true;
    }

    protected function email($key, $value): bool|string
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL))
            return $this->message->get('email', attribute: $key);

        return true;
    }

    protected function unique($key, $value, $model, $model_namespace = 'Source\Model\\'): bool|string
    {
        $model = $model_namespace . ucfirst($model);
        
        if (class_exists($model)) {
            
            $result = $model::find([$key => $value])->first();

            if ($result) return $this->message->get('unique', attribute: $key);
            
        }

        return true;
    }

    protected function exists($key, $value, $model, $model_namespace = 'Source\Model\\'): bool|string
    {
        $model = $model_namespace . ucfirst($model);
        
        if (class_exists($model)) {
            
            $result = $model::find([$key => $value])->first();

            if (!$result) return $this->message->get('exists', attribute: $key);
            
        }

        return true;
    }

    public function errors(string $key = ''): string|array
    {
        return $key ? $this->errors[$key] : $this->errors;
    }

    public function __call($name, $arguments): void
    {
        throw new Exception("Método de válidação informado '{$name}' não existe");
    }
}
