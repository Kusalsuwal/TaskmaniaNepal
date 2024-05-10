<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToTaskHistoriesTable extends Migration
{
    public function up()
    {
        Schema::table('task_histories', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('task_histories', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
}
