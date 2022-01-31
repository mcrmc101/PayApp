<?php

namespace Mcrmc\Ureg;

use Backend;
use System\Classes\PluginBase;
use RainLab\User\Models\User;
use RainLab\User\Models\UserGroup;
use Event;
use Mcrmc\Payapp\Models\Account;

/**
 * ureg Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'ureg',
            'description' => 'No description provided yet...',
            'author'      => 'Mcrmc',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
        // extend user model with addUserGroup method
        User::extend(function ($model) {
            $model->addDynamicMethod('addUserGroup', function ($group) use ($model) {
                if ($group instanceof Collection) {
                    return $model->groups()->saveMany($group);
                }

                if (is_string($group)) {
                    $group = UserGroup::whereCode($group)->first();

                    return $model->groups()->save($group);
                }

                if ($group instanceof UserGroup) {
                    return $model->groups()->save($group);
                }
            });
        });

        // create new account on register
        Event::listen('rainlab.user.activate', function ($user) {
            $acc = new Account;
            $acc->userid = $user->id;
            $acc->email = $user->email;
            $acc->save();
            return;
        });
    }


    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'Mcrmc\Ureg\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'mcrmc.ureg.some_permission' => [
                'tab' => 'ureg',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'ureg' => [
                'label'       => 'ureg',
                'url'         => Backend::url('mcrmc/ureg/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['mcrmc.ureg.*'],
                'order'       => 500,
            ],
        ];
    }
}
