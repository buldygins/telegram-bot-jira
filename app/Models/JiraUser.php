<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class JiraUser extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function getAccountKey(){
        return $this->key ?? $this->accountId;
    }
}
