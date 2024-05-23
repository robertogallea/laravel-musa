<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{

    public function before(User $user, string $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        // da valutare sull'elenco delle risorse GET /posts
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Post $post): bool
    {
        // da valutare su una singola risora GET /posts/{post}
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // da valutare sul form di creazione risorsa GET /posts/create
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post): Response
    {
        // da valutare sulla modifica di una risorsa PUT /posts/{post}
        if ($post->user_id === $user->id) {
            return Response::allow();
        }

        return Response::deny('Non puoi modificare un post scritto da un altro utente');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): Response
    {
        // da valutare sulla cancellazione di una risorsa DELETE /posts/{post}
        if ($post->user_id === $user->id) {
            return Response::allow('Cancellazione consentita');
        }

        return Response::deny('Non puoi cancellare un post scritto da un altro utente');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Post $post): Response
    {
        if ($post->user_id === $user->id) {
            return Response::allow('Recupero consentito');
        }

        return Response::deny('Non puoi recuperare un post scritto da un altro utente');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Post $post): bool
    {
        return false;
    }
}
