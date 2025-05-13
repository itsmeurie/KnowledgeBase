<?php

namespace App\Policies;

use App\Models\Section;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SectionPolicy {
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Section $section): bool {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool {
        return $user->can("create_section", Section::class);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Section $section): bool {
        return $user->can("update_section", $section);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Section $section): bool {
        return $user->can("delete_article", $section);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Section $section): bool {
        return $user->can("restore_article", $section);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Section $section): bool {
        return false;
    }

    public function upload(User $user, Section $section): bool {
        return $user->can("upload_files", $section);
    }
}
