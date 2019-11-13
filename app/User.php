<?php

namespace App;

use App\Presenters\User\UserPresenter;
use App\Presenters\User\UserSubscriptionPresenter;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $presenters = [
        'subscription' => UserSubscriptionPresenter::class,
        'default' => UserPresenter::class,
    ];

    public function presenter($type = 'default')
    {
        if (Arr::has($this->presenters, $type)) {
            return new $this->presenters[$type]($this);
        }

        throw new \Exception('Presenter not found.');
    }
}
