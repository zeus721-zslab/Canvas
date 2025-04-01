<?php

use Myth\Auth\Entities\User;
if (! function_exists('logged_in'))
{
    /**
     * Checks to see if the user is logged in.
     *
     * @return bool
     */
    function isLogin()
    {
        return service('auth')->isLogin();
    }
}

if (! function_exists('user'))
{
    /**
     * Returns the User instance for the current logged in user.
     *
     * @return User|null
     */
    function user()
    {
//        $authenticate = service('authentication');
//        $authenticate->check();
//        return $authenticate->user();
    }
}

if (! function_exists('user_id'))
{
    /**
     * Returns the User ID for the current logged in user.
     *
     * @return int|null
     */
    function user_id()
    {
//        $authenticate = service('authentication');
//        $authenticate->check();
//        return $authenticate->id();
    }
}

if (! function_exists('has_permission'))
{
    /**
     * Ensures that the current user has the passed in permission.
     * The permission can be passed in either as an ID or name.
     *
     * @param int|string $permission
     *
     * @return bool
     */
    function has_permission($permission): bool
    {
//        $authenticate = service('authentication');
//        $authorize    = service('authorization');
//
//        if ($authenticate->check())
//        {
//            return $authorize->hasPermission($permission, $authenticate->id()) ?? false;
//        }
//
//        return false;
    }
}
