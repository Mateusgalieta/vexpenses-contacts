<?php

namespace App\Models;

use App\Models\User;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Phone extends Model
{
    use Notifiable, SoftDeletes;


     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'phone', 'contact_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

    /**
     * The attributes that should be dates
     *
     * @var array
     */
    protected $dates = [
        'deleted_at', 'created_at'
    ];

     /*  Table Relationships  */
     public function contact()
     {
         return $this->belongsTo(Contact::class);
     }

}
