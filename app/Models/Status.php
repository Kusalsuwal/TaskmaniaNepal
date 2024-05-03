<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = ['name','board_id','status'];
   
   
    /**
     * Get the statuses for the board.
     */
    public function board()
    {
        return $this->belongsTo(Board::class);
    }
    
}
