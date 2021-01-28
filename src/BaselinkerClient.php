<?php

namespace AwemaPL\BaselinkerClient;

use Illuminate\Routing\Router;
use AwemaPL\BaselinkerClient\Contracts\BaselinkerClient as BaselinkerClientContract;
use Illuminate\Support\Facades\Artisan;

class BaselinkerClient implements BaselinkerClientContract
{
    /** @var Router $router */
    protected $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Routes
     */
    public function routes()
    {
        if ($this->isActiveRoutes()) {
            if ($this->isActiveAdminInstallationRoutes() && !$this->isMigrated()) {
                $this->adminInstallationRoutes();
            }
            if ($this->isActiveAdminSettingRoutes()) {
                $this->adminSettingRoutes();
            }
            if ($this->isActiveAccountRoutes()) {
                $this->accountRoutes();
            }
        }
    }

    /**
     * Admin installation routes
     */
    protected function adminInstallationRoutes()
    {
        $prefix = config('baselinker-client.routes.admin.installation.prefix');
        $namePrefix = config('baselinker-client.routes.admin.installation.name_prefix');
        $this->router->prefix($prefix)->name($namePrefix)->group(function () {
            $this->router
                ->get('/', '\AwemaPL\BaselinkerClient\Admin\Sections\Installations\Http\Controllers\InstallationController@index')
                ->name('index');
            $this->router->post('/', '\AwemaPL\BaselinkerClient\Admin\Sections\Installations\Http\Controllers\InstallationController@store')
                ->name('store');
        });

    }

    /**
     * Admin setting routes
     */
    protected function adminSettingRoutes()
    {
        $prefix = config('baselinker-client.routes.admin.setting.prefix');
        $namePrefix = config('baselinker-client.routes.admin.setting.name_prefix');
        $middleware = config('baselinker-client.routes.admin.setting.middleware');
        $this->router->prefix($prefix)->name($namePrefix)->middleware($middleware)->group(function () {
            $this->router
                ->get('/', '\AwemaPL\BaselinkerClient\Admin\Sections\Settings\Http\Controllers\SettingController@index')
                ->name('index');
            $this->router
                ->get('/applications', '\AwemaPL\BaselinkerClient\Admin\Sections\Settings\Http\Controllers\SettingController@scope')
                ->name('scope');
            $this->router
                ->patch('{id?}', '\AwemaPL\BaselinkerClient\Admin\Sections\Settings\Http\Controllers\SettingController@update')
                ->name('update');
        });
    }

    /**
     * Account routes
     */
    protected function accountRoutes()
    {
        $prefix = config('baselinker-client.routes.user.account.prefix');
        $namePrefix = config('baselinker-client.routes.user.account.name_prefix');
        $middleware = config('baselinker-client.routes.user.account.middleware');
        $this->router->prefix($prefix)->name($namePrefix)->middleware($middleware)->group(function () {
            $this->router
                ->get('/', '\AwemaPL\BaselinkerClient\User\Sections\Accounts\Http\Controllers\AccountController@index')
                ->name('index');
            $this->router
                ->post('/', '\AwemaPL\BaselinkerClient\User\Sections\Accounts\Http\Controllers\AccountController@store')
                ->name('store');
            $this->router
                ->get('/accounts', '\AwemaPL\BaselinkerClient\User\Sections\Accounts\Http\Controllers\AccountController@scope')
                ->name('scope');
            $this->router
                ->patch('{id?}', '\AwemaPL\BaselinkerClient\User\Sections\Accounts\Http\Controllers\AccountController@update')
                ->name('update');
            $this->router
                ->delete('{id?}', '\AwemaPL\BaselinkerClient\User\Sections\Accounts\Http\Controllers\AccountController@delete')
                ->name('delete');
            $this->router
                ->get('/statuses/{id?}', '\AwemaPL\BaselinkerClient\User\Sections\Accounts\Http\Controllers\AccountController@statuses')
                ->name('statuses');
            $this->router
                ->get('/select-storage/{id?}', '\AwemaPL\BaselinkerClient\User\Sections\Accounts\Http\Controllers\AccountController@selectStorage')
                ->name('select_storage');
        });
    }

    /**
     * Can installation
     *
     * @return bool
     */
    public function canInstallation()
    {
        $canForPermission = $this->canInstallForPermission();
        return $this->isActiveRoutes()
            && $this->isActiveAdminInstallationRoutes()
            && $canForPermission
            && !$this->isMigrated();
    }

    /**
     * Is migrated
     *
     * @return bool
     */
    public function isMigrated()
    {
        $tablesInDb = array_map('reset', \DB::select('SHOW TABLES'));

        $tables = array_values(config('baselinker-client.database.tables'));
        foreach ($tables as $table){
            if (!in_array($table, $tablesInDb)){
                return false;
            }
        }
        return true;
    }

    /**
     * Is active routes
     *
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    public function isActiveRoutes()
    {
        return config('baselinker-client.routes.active');
    }

    /**
     * Is active admin setting routes
     *
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    public function isActiveAdminSettingRoutes()
    {
        return config('baselinker-client.routes.admin.setting.active');
    }

    /**
     * Is active admin installation routes
     *
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private function isActiveAdminInstallationRoutes()
    {
        return config('baselinker-client.routes.admin.installation.active');
    }

    /**
     * Is active account routes
     *
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private function isActiveAccountRoutes()
    {
        return config('baselinker-client.routes.user.account.active');
    }

    /**
     * Include lang JS
     */
    public function includeLangJs()
    {
        $lang = config('indigo-layout.frontend.lang', []);
        $lang = array_merge_recursive($lang, app(\Illuminate\Contracts\Translation\Translator::class)->get('baselinker-client::js')?:[]);
        app('config')->set('indigo-layout.frontend.lang', $lang);
    }

    /**
     * Can install for permission
     *
     * @return bool
     */
    private function canInstallForPermission()
    {
        $userClass = config('auth.providers.users.model');
        if (!method_exists($userClass, 'hasRole')) {
            return true;
        }

        if ($user = request()->user() ?? null){
            return $user->can(config('baselinker-client.installation.auto_redirect.permission'));
        }

        return false;
    }

    /**
     * Menu merge in navigation
     */
    public function menuMerge()
    {
        if ($this->canMergeMenu()){
            $baselinkerClientMenu = config('baselinker-client-menu.navs', []);
            $navTemp = config('temp_navigation.navs', []);
            $nav = array_merge_recursive($navTemp, $baselinkerClientMenu);
            config(['temp_navigation.navs' => $nav]);
        }
    }

    /**
     * Can merge menu
     *
     * @return boolean
     */
    private function canMergeMenu()
    {
        return !!config('baselinker-client-menu.merge_to_navigation') && self::isMigrated();
    }

    /**
     * Execute package migrations
     */
    public function migrate()
    {
         Artisan::call('migrate', ['--force' => true, '--path'=>'vendor/awema-pl/module-baselinker-client/database/migrations']);
    }

    /**
     * Install package
     *
     * @param array $data
     */
    public function install(array $data)
    {
        $this->migrate();
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('cache:clear');
    }

    /**
     * Add permissions for module permission
     */
    public function mergePermissions()
    {
       if ($this->canMergePermissions()){
           $baselinkerClientPermissions = config('baselinker-client.permissions');
           $tempPermissions = config('temp_permission.permissions', []);
           $permissions = array_merge_recursive($tempPermissions, $baselinkerClientPermissions);
           config(['temp_permission.permissions' => $permissions]);
       }
    }

    /**
     * Can merge permissions
     *
     * @return boolean
     */
    private function canMergePermissions()
    {
        return !!config('baselinker-client.merge_permissions');
    }
}
