<?php

namespace Source\Support\Upload;

class Image extends AbstractUpload
{
    protected static array $allowed_types = [
        'image/jpg',
        'image/jpeg',
        'image/png'
    ];

    public function upload(array $image, ?string $image_name = null): string|bool
    {
        if (!$this->isAllowed($image['type'])) return false;

        $image_name = $this->normalizeFileName($image['type'], $image_name);

        if (file_exists($this->upload_dir . "/{$image_name}")) {
            
            $this->errors['image_exists'] = "Já existe uma imagem com esse nome no diretório informado";

            return false;
        }

        if (move_uploaded_file($image['tmp_name'], $this->upload_dir . "/{$image_name}")) {
            return $this->upload_dir . "/{$image_name}";
        }
        
        $this->errors['upload'] = "A tentativa de upload falhou";

        return false;
    }

    
}
