<?php

namespace App\Core\Utils;

use App\Core\Utils\Constant\Error\ModuleLog;
use App\Core\Utils\Constant\Error\TypeLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Psr\Log\LoggerInterface;

class Logging
{
    /**
     * Ghi nhận action của user hoặc IP khi có request
     * @param string $message
     * @param array $context
     * @return void
     */
    public static function logAction(string $message, array $context = []): void
    {
        $ip = request()->ip();
        $context['ip'] = $ip;
        if (Auth::check()) {
            $context['user_id'] = Auth::id();
            $message = "User " . $context['user_id'] . ": " . $message;
        } else {
            $message = "IP " . $ip . ": " . $message;
        }
        Log::channel('action')->info($message, $context);
    }

    /**
     * Ghi nhận error khi có exception hoặc lỗi khác
     * @param ModuleLog $module
     * @param TypeLog $type
     * @param string $code
     * @param array $context
     * @return void
     */
    public static function logError(ModuleLog $module, TypeLog $type, string $code, array $context = []): void
    {
        $message = $module->value . ' - ' . $type->value . ' - ' . $code;
        Log::channel('error')->error($message, $context);
    }

    /**
     * Ghi nhận log khi chạy command
     * @param string $command - mỗi command sẽ có 1 file log riêng
     * @return LoggerInterface
     */
    public static function console(string $command): LoggerInterface
    {
        return Log::build([
            'driver' => 'daily',
            'path' => storage_path('logs' . DIRECTORY_SEPARATOR . 'commands' . DIRECTORY_SEPARATOR . $command . DIRECTORY_SEPARATOR . 'command.log'),
            'level' => 'debug',
            'replace_placeholders' => true,
            'days' => 1
        ]);
    }

}
