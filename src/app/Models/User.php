<?php

namespace App\Models;
/* model User: representasi data pengguna dan relasi terkait */

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;

#[Fillable(['name', 'email', 'no_hp', 'role', 'rekening_bank', 'ktp', 'nama_mitra', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Roles relation (many-to-many)
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    /**
     * Mitra profile (one-to-one)
     */
    public function mitraProfile()
    {
        return $this->hasOne(MitraProfile::class, 'user_id');
    }

    /**
     * Check whether user has mitra role
     */
    public function isMitra(): bool
    {
        return $this->roles()->where('name', 'mitra')->exists();
    }

    /**
     * Check whether user has a given role name.
     */
    public function hasRole(string $roleName): bool
    {
        return $this->roles()->where('name', $roleName)->exists();
    }

    /**
     * Assign a role to the user by name (creates role if missing).
     */
    public function assignRole(string $roleName): void
    {
        $role = Role::firstOrCreate(['name' => $roleName]);
        if (! $this->roles()->where('role_id', $role->id)->exists()) {
            $this->roles()->attach($role->id);
        }
    }

    /**
     * Primary role accessor: first pivot role name or fall back to legacy column.
     */
    public function getPrimaryRoleAttribute(): ?string
    {
        $first = $this->roles()->pluck('name')->first();
        return $first ?: ($this->role ?? null);
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
}
