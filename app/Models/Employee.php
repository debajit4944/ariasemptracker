<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','address','phno','email','status','level','project_id','emp_file'
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function designations(): BelongsToMany
    {
        return $this->belongsToMany(Designation::class, 'employees_designations', 'employees_id', 'designations_id')->withTimestamps()->withPivot('id','desg_effect_date','file')->orderBy('pivot_desg_effect_date','desc');
    }

    public function latestDesignation(): BelongsToMany
    {
        return $this->designations()->limit(1);
    }

    public function offices(): BelongsToMany
    {
        return $this->belongsToMany(Office::class, 'employees_offices', 'employees_id', 'offices_id')->withTimestamps()->withPivot('id','office_effect_date','file')->orderBy('pivot_office_effect_date','desc');
    }
    public function latestOffice(): BelongsToMany
    {
        return $this->offices()->limit(1);
    }

    public function districts(): BelongsToMany
    {
        return $this->belongsToMany(District::class, 'employees_districts', 'employees_id', 'districts_id')->withTimestamps()->withPivot('id','district_effect_date','file')->orderBy('pivot_district_effect_date','desc');
    }

    public function latestDistrict(): BelongsToMany
    {
        return $this->districts()->limit(1);
    }

    public function ctps(): HasMany
    {
        return $this->hasMany(Ctp::class)->orderBy('ctp_effect_date','desc');
    }
    public function latestCtp(): HasMany
    {
        return $this->ctps()->limit(1);
    }

    public function leaves(): BelongsToMany
    {
        return $this->belongsToMany(Leave::class, 'employees_leaves', 'employees_id', 'leaves_id')->withTimestamps()->withPivot('id','no_of_days','year','dates','approved','file')->orderBy('created_at','desc');
    }
    public function currentYearLeaves(): BelongsToMany
    {
        $date = Carbon::now()->format('Y');//return current year data only
        return $this->leaves()->where('year','=',$date);
    }
    public function currentYearCasualLeaves()
    {
        return $this->currentYearLeaves()->where('leaves_id','=',1);
    }
    public function currentYearMedicalLeaves()
    {
        return $this->currentYearLeaves()->where('leaves_id','=',2);
    }
    public function currentYearRestrictedLeaves()
    {
        return $this->currentYearLeaves()->where('leaves_id','=',3);
    }
    public function currentYearSpecialLeaves()
    {
        return $this->currentYearLeaves()->where('leaves_id','=',4);
    }
    public function currentYearMaternityLeaves()
    {
        return $this->currentYearLeaves()->where('leaves_id','=',5);
    }
    public function currentYearPaternityLeaves()
    {
        return $this->currentYearLeaves()->where('leaves_id','=',6);
    }

    public function resignation()
    {
        return $this->hasOne(Resignation::class);
    }
}
