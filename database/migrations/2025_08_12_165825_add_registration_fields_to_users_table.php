<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up()
{
    Schema::table('users', function (Blueprint $table) {
        // Personal Information
        $table->string('whatsapp_no')->nullable();

        // Business Information
        $table->string('alternate_no')->nullable();
        $table->string('business_name')->nullable();
        $table->text('business_address')->nullable();
        $table->string('business_pin_code')->nullable();
        $table->string('business_email')->nullable();
        $table->string('business_phone')->nullable();

        // Upload fields (store file paths)
        $table->string('personal_upload')->nullable();
        $table->string('business_upload')->nullable();

        // Active status
        $table->boolean('is_active')->default(0); // 0 = inactive, 1 = active
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn([
            'phone_no',
            'whatsapp_no',
            'alternate_no',
            'business_name',
            'business_address',
            'business_pin_code',
            'business_email',
            'business_phone',
            'personal_upload',
            'business_upload',
            'is_active',
        ]);
    });
}

};
