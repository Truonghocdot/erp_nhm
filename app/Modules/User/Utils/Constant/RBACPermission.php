<?php

namespace App\Modules\User\Utils\Constant;

enum RBACPermission:string
{
    case USER_READ = 'user.read';
    case USER_DELETE = 'user.delete';
    case USER_CREATE = 'user.create';
    case USER_LIST = 'user.list';
    case USER_UPDATE = 'user.update';
    case FILE_READ   = 'file.read';
    case FILE_DELETE = 'file.delete';
    case FILE_CREATE = 'file.upload';
    case FILE_LIST   = 'file.list';
    case FILE_UPDATE = 'file.update';

    public function label(): string
    {
        return match ($this) {
            self::USER_READ => 'Xem thông tin nhân sự',
            self::USER_DELETE => 'Xóa nhân sự',
            self::USER_CREATE => 'Tạo nhân sự',
            self::USER_LIST => 'Danh sách nhân sự',
            self::USER_UPDATE => 'Cập nhật thông tin nhân sự',
            self::FILE_READ   => 'Xem file',
            self::FILE_DELETE => 'Xóa file',
            self::FILE_CREATE => 'Upload file',
            self::FILE_LIST   => 'Danh sách file',
            self::FILE_UPDATE => 'Cập nhật thông tin file',
        };
    }

    public static function getOptions(): array
    {
        return collect(self::cases())->mapWithKeys(fn(self $case) => [$case->value => $case->label()])->toArray();
    }
}
