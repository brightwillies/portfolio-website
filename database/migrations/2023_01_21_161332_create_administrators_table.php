<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('administrators', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('telephone_number')->nullable();
            $table->string('device_token')->nullable();
              $table->integer('status')->nullable()->defualt(1);
            $table->integer('role_id')->nullable()->defualt(1);
            $table->string('password');
            $table->dateTime('last_login')->nullable();
            $table->string('mask');
            $table->string('image')->nullable();
            $table->string('image_filename')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

         DB::table('administrators')->insert([
            'first_name' => 'Bright',
            'last_name' => 'Boakye',
            'email' => 'bb@meetbright.ca',
            'telephone_number' => '+6477645475',
            'status' => 1,
            'mask' => \generate_mask(),
            'password' => Hash::make('Season@2024!!..'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),

        ]);
        //  DB::table('administrators')->insert([
        //     'first_name' => 'Joy',
        //     'last_name' => 'Musa',
        //     'email' => 'joy@meetjoy.ca',
        //     'telephone_number' => '+16475403470',
        //     'status' => 1,
        //     'mask' => \generate_mask(),
        //     'password' => Hash::make('Joy@2025!!..'),
        //     'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        //     'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),

        // ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('administrators');
    }
};
