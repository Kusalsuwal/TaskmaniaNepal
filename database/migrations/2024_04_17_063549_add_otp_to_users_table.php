<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOtpToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('otp')->nullable();  // Store OTP
            $table->boolean('otp_verified')->default(false);
            $table->timestamp('otp_expires_at')->nullable();  // Expiration time for OTP
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['otp', 'otp_expires_at']);
            $table->dropColumn('otp_verified');
        });
    }
}
