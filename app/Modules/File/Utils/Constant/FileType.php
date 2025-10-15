<?php

namespace App\Modules\File\Utils\Constant;

enum FileType: int
{
    case IMAGE = 1;
    case DOCUMENT = 2;
    case VIDEO = 3;
    case AUDIO = 4;
    case ARCHIVE = 5;
    case OTHER = 99;

    public function label(): string
    {
        return match ($this) {
            self::IMAGE => 'Image',
            self::DOCUMENT => 'Document',
            self::VIDEO => 'Video',
            self::AUDIO => 'Audio',
            self::ARCHIVE => 'Archive',
            self::OTHER => 'Other',
        };
    }

    public function mimeTypes(): array
    {
        return match ($this) {
            self::IMAGE => ['image/jpeg', 'image/png', 'image/gif', 'image/webp'],
            self::DOCUMENT => ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
            self::VIDEO => ['video/mp4', 'video/mpeg', 'video/quicktime'],
            self::AUDIO => ['audio/mpeg', 'audio/wav', 'audio/ogg'],
            self::ARCHIVE => ['application/zip', 'application/x-rar-compressed'],
            self::OTHER => [],
        };
    }

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}
