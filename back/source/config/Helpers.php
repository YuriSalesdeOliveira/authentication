<?php

function dataBaseConfig(string $environment = null): array
{
    $environment = $environment ?? DATA_BASE_CONFIG['default_environment'];

    return DATA_BASE_CONFIG[$environment];
}