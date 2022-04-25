<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Ministry
 *
 * @property int $id
 * @property string $ministry
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Department[] $departments
 * @property-read int|null $departments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Department[] $units
 * @property-read int|null $units_count
 * @method static \Database\Factories\MinistryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Ministry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ministry newQuery()
 * @method static \Illuminate\Database\Query\Builder|Ministry onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Ministry query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ministry whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ministry whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ministry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ministry whereMinistry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ministry whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Ministry withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Ministry withoutTrashed()
 * @mixin \Eloquent
 */
class Ministry extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Get all of the units for the Ministry
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function units()
    {
        return $this->hasMany(Department::class);
    }

    /**
     * Get all of the departments for the Ministry
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function departments()
    {
        return $this->hasMany(Department::class)->where('department_id', null);
    }
}