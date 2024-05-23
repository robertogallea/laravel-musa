<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::before(function(User $user, string $ability) {
            if ($user->isAdmin() && in_array($ability, ['update-post', 'delete-post', 'create-post'])) {
                return true;
            }

            return null;
        });

        Gate::after(function (User $user, string $ability) {
            // logica di autorizzazione da valutare dopo lo specifico gate
        });

        Gate::define('delete-post', function (User $user, Post $post) {
//            return $post->user_id === $user->id;
            if ($post->user_id === $user->id) {
                return Response::allow('Cancellazione consentita');
            }

            return Response::deny('Non puoi cancellare un post scritto da un altro utente');
//            denyAsNotFound è utile nel caso non si voglia implicitamente fornire informazioni circa l'esistenza della risorsa
//            return Response::denyAsNotFound('Non puoi cancellare un post scritto da un altro utente');
        });

        Gate::define('update-post', function (User $user, Post $post) {
            if ($post->user_id === $user->id) {
                return Response::allow();
            }

            return Response::deny('Non puoi modificare un post scritto da un altro utente');
        });
    }
}
