<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TopBanner;
use Illuminate\Auth\Access\HandlesAuthorization;

class TopBannerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_top::banner');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TopBanner $topBanner): bool
    {
        return $user->can('view_top::banner');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_top::banner');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TopBanner $topBanner): bool
    {
        return $user->can('update_top::banner');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TopBanner $topBanner): bool
    {
        return $user->can('delete_top::banner');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_top::banner');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, TopBanner $topBanner): bool
    {
        return $user->can('force_delete_top::banner');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_top::banner');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, TopBanner $topBanner): bool
    {
        return $user->can('restore_top::banner');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_top::banner');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, TopBanner $topBanner): bool
    {
        return $user->can('replicate_top::banner');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_top::banner');
    }
}
