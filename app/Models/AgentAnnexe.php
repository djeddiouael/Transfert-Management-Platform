<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentAnnexe extends Model
{
  use HasFactory;
  protected $fillable = ['username', 'email', 'password'];
}
