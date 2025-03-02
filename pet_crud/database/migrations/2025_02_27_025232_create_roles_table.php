<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        DB::table('roles')->insert([
            ['name' => 'Admin', 'display_name' => 'Admin', 'description' => 'Has full access to manage users, settings, and permissions.'],
            ['name' => 'User', 'display_name' => 'User', 'description' => 'A standard user with limited access to features.'],
            ['name' => 'Reader', 'display_name' => 'Reader', 'description' => 'Can only view content without making modifications.'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};

