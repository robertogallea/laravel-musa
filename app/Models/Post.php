<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use HasComments;
    use SoftDeletes;

    protected $guarded = null;

    protected $casts = [
        'status' => 'boolean',
    ];

    // protected $table = 'my_posts'; // nome della tabella fuori convenzione

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
        //return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function casts()
    {
        return [
            'status' => 'boolean',
        ];
    }

    // accessor, in lettura => get
    // mutator, in scrittura => set
    public function summary(): Attribute
    {
        return Attribute::make(
          get: fn() => substr($this->body, 0, 400) . '...'
        );
    }

    // "My first post"
    // sul db: "my first post"
    // sull'applicazione: "My First Post"
    public function title(): Attribute
    {
        return Attribute::make(
            get: fn($value) => ucwords($value),
            set: fn($value) => strtolower($value)
        );
    }


}
