<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    //when use create and update method from reuest class (we used it inside web.php) its call mass assignment
    // which means you set or change multible attribute of a model at once 
    // by defaul thats disabled 
    // to enable that you have to inistial ($fillabel) protected prperty have the column name that you want to set or update
    // remind dont put sensiteve information like password to this fillable property
    protected  $fillable  = ['title', 'description', 'long_description'];

    // or you can secure the columns that you dont want to change it put this way its not secure so use $fillabel is better
    // protected $guarded=['password'];

    public function toggleCompleted()
    {
        $this->completed = !$this->completed;
        $this->save();
    }
}
