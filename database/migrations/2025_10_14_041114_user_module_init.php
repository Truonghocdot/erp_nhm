<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->applicationInitial();
        $this->permissionInitial();
        $this->userInitial();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->userInitial(false);
        $this->permissionInitial(false);
        $this->applicationInitial(false);
    }



    private function applicationInitial(bool $migrate = true): void
    {
        if ($migrate) {
            Schema::create('jobs', function (Blueprint $table) {
                $table->id();
                $table->string('queue')->index();
                $table->longText('payload');
                $table->unsignedTinyInteger('attempts');
                $table->unsignedInteger('reserved_at')->nullable();
                $table->unsignedInteger('available_at');
                $table->unsignedInteger('created_at');
            });
            Schema::create('job_batches', function (Blueprint $table) {
                $table->string('id')->primary();
                $table->string('name');
                $table->integer('total_jobs');
                $table->integer('pending_jobs');
                $table->integer('failed_jobs');
                $table->longText('failed_job_ids');
                $table->mediumText('options')->nullable();
                $table->integer('cancelled_at')->nullable();
                $table->integer('created_at');
                $table->integer('finished_at')->nullable();
            });
            Schema::create('failed_jobs', function (Blueprint $table) {
                $table->id();
                $table->string('uuid')->unique();
                $table->text('connection');
                $table->text('queue');
                $table->longText('payload');
                $table->longText('exception');
                $table->timestamp('failed_at')->useCurrent();
            });
            Schema::create('cache', function (Blueprint $table) {
                $table->string('key')->primary();
                $table->mediumText('value');
                $table->integer('expiration');
            });
            Schema::create('cache_locks', function (Blueprint $table) {
                $table->string('key')->primary();
                $table->string('owner');
                $table->integer('expiration');
            });
        } else {
            Schema::dropIfExists('jobs');
            Schema::dropIfExists('job_batches');
            Schema::dropIfExists('failed_jobs');
            Schema::dropIfExists('cache');
            Schema::dropIfExists('cache_locks');
        }
    }

    private function permissionInitial(bool $migrate = true): void
    {
        if ($migrate) {
            Schema::create('roles', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->softDeletes();
                $table->timestamps();
            });

            Schema::create('permissions', function (Blueprint $table) {
                $table->id();
                $table->string('code')->unique();
                $table->string('name');
            });

            Schema::create('role_permission', function (Blueprint $table) {
                $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
                $table->foreignId('permission_id')->constrained('permissions')->onDelete('cascade');
                $table->primary(['role_id', 'permission_id']);
            });
        } else {
            Schema::dropIfExists('role_permission');
            Schema::dropIfExists('permissions');
            Schema::dropIfExists('roles');
        }
    }

    private function userInitial(bool $migrate = true): void
    {
        if ($migrate) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->string('password');
                $table->rememberToken();
                $table->timestamps();
                $table->softDeletes();
            });

            Schema::create('user_profiles', function (Blueprint $table) {
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
                $table->string('phone')->nullable()->unique();
                $table->string('address')->nullable();
                $table->string('avatar')->nullable();
                $table->smallInteger('gender')->default(1)->comment('1 - male, 2 - female');
                $table->timestamp('date_of_birth');
                $table->text('note')->nullable();
            });

            Schema::create('sessions', function (Blueprint $table) {
                $table->string('id')->primary();
                $table->foreignId('user_id')->nullable()->index();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->longText('payload');
                $table->integer('last_activity')->index();
            });

            Schema::create('user_role', function (Blueprint $table) {
                $table->foreignId('user_id')->constrained('users');
                $table->foreignId('role_id')->constrained('roles');
                $table->primary(['user_id', 'role_id']);
            });

        } else {
            Schema::dropIfExists('user_role');
            Schema::dropIfExists('sessions');
            Schema::dropIfExists('user_profiles');
            Schema::dropIfExists('users');
        }
    }
};
