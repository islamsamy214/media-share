<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkSkill extends Model
{
    use HasFactory;

    protected $fillabel = [
        'skill', 'work_id'
    ];

    public function work()
    {
        return $this->belongsTo(Work::class);
    } //end of work relation
}
