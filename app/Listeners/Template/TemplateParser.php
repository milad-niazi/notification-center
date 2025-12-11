<?php

namespace App\Services\Notification\Template;

class TemplateParser
{
    /**
     * جایگذاری placeholders در متن template
     */
    public static function parse(string $templateBody, array $data): string
    {
        foreach ($data as $key => $value) {
            $templateBody = str_replace("{{{$key}}}", $value, $templateBody);
        }

        return $templateBody;
    }
}
