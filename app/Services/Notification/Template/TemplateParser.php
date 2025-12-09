<?php

namespace App\Services\Notification\Template;

class TemplateParser
{
    public static function parse(string $body, array $data): string
    {
        foreach($data as $key => $value) {
            $body = str_replace("{{{$key}}}", $value, $body);
        }
        return $body;
    }
}
