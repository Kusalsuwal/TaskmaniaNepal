<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskHistory extends Model
{
    protected $fillable = ['task_id', 'old_status_id', 'new_status_id'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function oldStatus()
    {
        return $this->belongsTo(Status::class, 'old_status_id');
    }

    public function newStatus()
    {
        return $this->belongsTo(Status::class, 'new_status_id');
    }
    
}
