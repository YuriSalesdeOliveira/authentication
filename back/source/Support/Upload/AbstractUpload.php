<?php

namespace Source\Support\Upload;

abstract class AbstractUpload
{
    protected static array $allowed_types;
    protected static array $extensions;
    protected string $upload_dir;
    protected array $errors;

    public function __construct(string $upload_dir)
    {
        $this->upload_dir = $upload_dir;
    }

    protected function normalizeFileName(string $type, ?string $file_name): string
    {
        $extension = explode('/', $type)[1];

        if ($file_name) {
            return $file_name . ".{$extension}";
        }
        
        return md5(uniqid()) . time() . ".{$extension}";
    }

    public function isAllowed(string $type): bool
    {
        if (!in_array($type, static::$allowed_types)) {

            $this->errors['allowed_types'] = "Tipo de arquivo '{$type}' não permitido";

            return false;
        }

        return true;
    }

    public function errors(): array
    {
        return isset($this->errors) ? $this->errors : [];
    }
}