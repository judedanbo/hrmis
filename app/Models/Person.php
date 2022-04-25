<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Person
 *
 * @property int $id
 * @property string|null $title
 * @property string $surname
 * @property string $other_names
 * @property string $gender
 * @property string $date_of_birth
 * @property string|null $social_security_number
 * @property string|null $about
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read mixed $full_name
 * @method static \Database\Factories\PersonFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Person newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Person newQuery()
 * @method static \Illuminate\Database\Query\Builder|Person onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Person query()
 * @method static \Illuminate\Database\Eloquent\Builder|Person whereAbout($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Person whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Person whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Person whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Person whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Person whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Person whereOtherNames($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Person whereSocialSecurityNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Person whereSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Person whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Person whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Person withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Person withoutTrashed()
 * @mixin \Eloquent
 */
class Person extends Model
{
    use HasFactory, SoftDeletes;

    public function getFullNameAttribute()
    {
        return "{$this->title} {$this->other_names} {$this->surname}" ;
    }

    public function scopeOrderDob($query){
        return $query->orderBy('date_of_birth');
    }

    /**
     * The departments that belong to the Person
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function departments(): BelongsToMany
    {
        return $this->belongsToMany(Department::class);
    }
}