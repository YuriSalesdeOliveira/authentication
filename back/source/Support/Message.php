<?php

namespace Source\Support;

use Exception;

class Message {

    private array $messages;
    private array $types = [
        'numeric',
        'file',
        'string',
        'array'
    ];

    public function __construct(string $folder, string $file, string $type = 'php')
    {
        $file_path = $this->getFilePath($folder, $file, $type);

        $this->messages = $this->getFileMessages($file_path);
    }

    public function get(string|array $message, string $attribute, string $parameter = null): string
    {
        if (is_array($message)) {
            
            foreach ($message as $message => $data_type)

            $this->filterType($data_type);

            $returned_message = $this->messages[$message][$data_type];
            
            return $this->formatMessage($returned_message, $attribute, [$message => $parameter]);
        }

        $returned_message = $this->messages[$message];

        return $this->formatMessage($returned_message, $attribute);

    }

    protected function formatMessage(string $message, string $attribute, array $parameter = []): string
    {
        $attribute = $this->changeAttribute($attribute);

        if ($parameter) {

            foreach ($parameter as $key => $value)

            $returned_message = str_replace(':attribute', $attribute, $message);

            return str_replace(":{$key}", $value, $returned_message);

        }

        return str_replace(':attribute', $attribute, $message);
    }

    protected function filterType(string $type): bool
    {
        if (!in_array($type, $this->types))
            throw new Exception('Tipos permitidos ' . implode(',', $this->types));
        
        return true;
    }

    protected function changeAttribute(string $attribute): string
    {
        foreach ($this->messages['attributes'] as $current => $new) {

            if ($current === $attribute) $attribute = $new;

        }

        return $attribute;
    }

    protected function getFileMessages(string $file_path): array
    {
        if (file_exists($file_path)) {

            if (is_array($return_file = require_once($file_path))) {
                
                return $return_file;
            }

            throw new Exception('O arquivo informado deve retornar um array');
        }

        throw new Exception('Arquivo informado não existe');
    }

    protected function getFilePath(string $folder, string $file, string $type): string
    {
        return  "{$folder}/{$file}.{$type}";
    }

}