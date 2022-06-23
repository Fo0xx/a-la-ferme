<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('farm_details', function (Blueprint $table) {
            $table->id();
            $table->string('about', 1500);
            $table->string('farm_banner');
            $table->string('business_mail');
            $table->string('phone');
            $table->string('instagram_id');
            $table->string('facebook_id');
            $table->foreignId('lang_id')->default(1)->constrained('langs', 'id')->cascadeOnUpdate(); //Foreign key farm_id on the id column in farms tables
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('farm_details');
    }
};
