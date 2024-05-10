<?php

namespace App\Models;

use App\Models\Scopes\OrderByTitle;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

#[ScopedBy([OrderByTitle::class])]
class Post extends Model
{
    use HasFactory;
    use HasComments;
    use SoftDeletes;


    protected $guarded = null; // nessun attributo protetto
//    protected $guarded = []; // nessun attributo protetto
//    protected $guarded = ['title', 'body']; // solo title e body sono compilabili
//
//    protected $fillable = ['*']; // nessun attributo protetto (tutti compilabili)
//
//    protected $fillable = ['slug', 'status']; // tutti attributi protetti tranne slug e status



    protected static function booted(): void
    {
//        static::addGlobalScope(new OrderByTitle());

        // Scope globale anonimo
//        static::addGlobalScope('orderByBody', function (Builder $builder) {
//            $builder->orderBy('body');
//        });
    }

    public function scopePublished(Builder $builder)
    {
        $builder->where('status', 1);
    }

    public function scopeUnpublished(Builder $builder)
    {
        $builder->where('status', 0);
    }

    public function scopeStatus(Builder $builder, bool $status)
    {
        $builder->where('status', $status);
    }

    public function scopeSortNormal(Builder $builder)
    {
        $builder->withoutGlobalScope(OrderByTitle::class);
    }


    public function getRouteKeyName()
    {
        return 'slug';
    }


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

    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes');
    }



}

//DB::table('likes')
//    ->insert([
//        ['user_id' => 1, 'post_id' => 1],
//        ['user_id' => 2, 'post_id' => 1],
//        ['user_id' => 2, 'post_id' => 2],
//        ['user_id' => 3, 'post_id' => 2],
//    ]);
