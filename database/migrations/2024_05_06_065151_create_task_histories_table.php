<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create('task_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->onDelete('cascade');
            $table->foreignId('old_status_id')->constrained('statuses');
            $table->foreignId('new_status_id')->constrained('statuses');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('task_histories');
    }
}
