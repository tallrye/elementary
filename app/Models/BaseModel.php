<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\User;
use Auth;

class BaseModel extends Model{
    
    /**
    *
    * A boot method applies to all the models that extends this model.
    * Defines basic model functions for create and update operations
    *
    * @param Auth
    *
    **/
    public static function boot(){
        parent::boot();
        static::creating(function($model)
        {
            $user = Auth::user();          
            $model->created_by = $user->id;
            $model->updated_by = $user->id;
        });
        static::updating(function($model)
        {
            $user = Auth::user();
            $model->updated_by = $user->id;
        });      
    }

    /**
     * Relationship between any model and the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdby()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relationship between any model and the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updatedby()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    
  
}
