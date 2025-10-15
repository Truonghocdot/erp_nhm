<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $this->fileInitial();
    }

    public function down(): void
    {
        $this->fileInitial(false);
    }

    private function fileInitial(bool $migrate = true): void
    {
        if ($migrate) {
            Schema::create('files', function (Blueprint $table) {
                $table->id();
                $table->foreignId('module_id')
                    ->constrained()
                    ->cascadeOnDelete();
                $table->tinyInteger('type')
                    ->comment('Lưu trong Constant Enum FileType Module File');
                $table->string('path');
                $table->string('extension');
                $table->unsignedBigInteger('size');
                $table->softDeletes();
                $table->timestamps();
            });
        } else {
            Schema::dropIfExists('files');
        }
    }
};
