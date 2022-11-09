<?php
/* 
Author: Mattias Dahlgren, Mittuniversitetet Sundsvall
Email: Mattias.dahlgren@miun.se
*/
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table ="posts";
    protected $fillable = ['title', 'content'];

    //asign to comments table
   public function comments() {
    return $this->hasMany(Comment::class);
   }
}
