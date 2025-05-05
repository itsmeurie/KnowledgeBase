<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Spatie\Permission\Traits\HasRoles;
use Veelasky\LaravelHashId\Eloquent\HashableId;

use App\Notifications\PasswordResetNotif;
use App\Notifications\SendEmailVerification;

use App\Traits\PaginatesTrait;
use App\Traits\HasTeam;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable, HasRoles, HashableId, PaginatesTrait, HasTeam;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = ["username", "email", "password", "fails", "email_verified_at", "disabled_at"];

    /**
     * The attributes that should be guarded. The attributes are not mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ["id", "remember_token", "created_at", "updated_at"];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ["password", "remember_token"];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array {
        return [
            "email_verified_at" => "datetime",
            "disabled_at" => "datetime",
            "password" => "hashed",
        ];
    }

    public function isSuperman(): bool {
        return $this->hasRole(config("mitd.superman"));
    }

    public function profile() {
        return $this->hasOne(Profile::class);
    }

    public function team(): BelongsTo {
        if (config("permission.teams")) {
            return $this->belongsTo(config("mitd.permission.teams_provider"), config("permission.column_names.team_foreign_key"), "id");
        }
        return $this->morphTo();
    }

    /**
     * Gets all roles for the user regardless of team
     * - Same as roles() relationship if teams is disabled
     * - Different from roles() relationship if teams is enabled
     *   - Will return all roles of the user for a given team
     */
    public function roles_all(): BelongsToMany {
        return $this->morphToMany(
            config("permission.models.role"),
            "model",
            config("permission.table_names.model_has_roles"),
            config("permission.column_names.model_morph_key"),
            config("permission.column_names.role_pivot_key") ?: "role_id"
        );
    }

    public function resetFailedLoginAttempts() {
        $this->fails = 0;
        $this->save();
    }

    public function sendPasswordResetNotification(#[\SensitiveParameter] $token) {
        $this->notify(new PasswordResetNotif($token));
    }

    public function sendEmailVerificationNotification(): void {
        $this->notify(new SendEmailVerification());
    }

    /**
     * Temporary fix to get the team from the session. This is a hack for now to get teams for users authenticated by API Tokens.
     * @return Team | null
     */
    public function getSessionTeam() {
        if (config("permission.teams")) {
            return app(config("mitd.permission.teams_provider"))::find(getPermissionsTeamId() ?? $this[config("permission.column_names.team_foreign_key")]);
        }
        return null;
    }

    public function office() {
        return $this->team();
    }

    public function getSessionOffice() {
        return $this->getSessionTeam();
    }
}
