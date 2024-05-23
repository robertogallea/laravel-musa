<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        static::deleting(function (User $model) {
            $model->posts()->forceDelete();
            $model->photos()->delete();
            $model->likes()->delete();
        });

        // di base il framework usa creating e updating per gestire data/ora di creazione/modifica
//        static::creating(function (User $model) {
//            $model->created_at = now();
//            $model->updated_at = now();
//        } );
//
//        static::updating(function (User $model) {
//            $model->updated_at = now();
//        } );
    }


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        //return $this->hasMany(Post::class);
        return $this->hasMany(Post::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function likes()
    {
        return $this->belongsToMany(Post::class, 'likes');
//        return $this->belongsToMany(Post::class, 'likes', 'user_id', 'post_id', 'id', 'id');
    }

    public function isAdmin()
    {
        return $this->id === 1;
    }

//    public function toArray()
//    {
//        return [
//            'name' => $this->name,
//            'email' => $this->email,
//            'posts' => $this->posts,
//        ];
//    }


}
