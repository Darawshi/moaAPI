<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $first_name_ar
 * @property string $last_name_ar
 * @property string $first_name_en
 * @property string $last_name_en
 * @property string $email
 * @property string $emp_id
 * @property string $password
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $role_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AdvAttach[] $adv_attaches
 * @property-read int|null $adv_attaches_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Adv[] $advs
 * @property-read int|null $advs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Article[] $articles
 * @property-read int|null $articles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Role $role
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmpId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable ,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name_ar',
        'last_name_ar',
        'first_name_en',
        'last_name_en',
        'emp_id',
        'email',
        'password',
        'role_id',
        'img_resized',
        'img_thumb',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public function role(){
        return $this->belongsTo(Role::class , 'role_id' ,'id');
    }

    public function articles(){
        return $this->hasMany(Article::class,'user_id' ,'id');
    }

    public function advs()
    {
        return $this->hasMany(Adv::class, 'user_id', 'id');
    }


        public function adv_attaches(){
            return $this->hasMany(AdvAttach::class,'user_id' ,'id');
        }




}
