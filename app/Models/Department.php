<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Department
 *
 * @property int $id
 * @property string $name
 * @property int $ministry_id
 * @property int|null $department_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Department[] $children
 * @property-read int|null $children_count
 * @property-read \App\Models\Ministry|null $institution
 * @method static \Database\Factories\DepartmentFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Department newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Department newQuery()
 * @method static \Illuminate\Database\Query\Builder|Department onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Department query()
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereMinistryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Department withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Department withoutTrashed()
 * @mixin \Eloquent
 */
class Department extends Model
{
    use HasFactory, SoftDeletes;

    public function scopeDepartments($query)
    {
       $query->whereNull('department_id');
    }

    /**
     * Get the institution that owns the Department
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function institution()
    {
        return $this->belongsTo(Ministry::class, 'ministry_id');
    }

    /**
     * Get all of the children for the Department
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(Department::class);
    }

    /**
     * Get the parent that owns the Department
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public static function tree(){
        $allUnits =  Department::all();
        $rootUnits = $allUnits->whereNull('department_id');
        self::formatTree($rootUnits, $allUnits);
        return $rootUnits;
    }

    private static function formatTree($units, $allUnits){
        foreach($units as $unit){
            $unit->children = $allUnits->where('department_id', $unit->id)->values();

            if($unit->children->isNotEmpty()){
                self::formatTree($unit->children, $allUnits);
            }
        }
    }

    /**
     * The staff that belong to the Department
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function staff(): BelongsToMany
    {
        return $this->belongsToMany(Person::class);
    }
    /**
     * Get all of the units for the Department
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function units(): HasManyThrough
    {
        return $this->hasManyThrough(Department::class, Department::class);
    }

    public function getAllStaffAttribute()
    {
        if($this->has('children')){
           $sumChildrenStaff =  $this->children->reduce(function($carry, $child){
                    return $carry + $child->all_staff ;
            });
            return $this->staff->count() +  $sumChildrenStaff;

        }
        return $this->staff->count();
    }
}