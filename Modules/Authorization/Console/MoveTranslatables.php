<?php

namespace Modules\Authorization\Console;

use Illuminate\Console\Command;
use Modules\Authorization\Entities\Permission;
use Modules\Authorization\Entities\PermissionTranslation;
use Modules\Authorization\Entities\Role;
use Modules\Authorization\Entities\RoleTranslation;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MoveTranslatables extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'authorization:move-translatable';

    private $display_name = [
        'statistics' => ['en' => 'dashboard access', 'ar' => 'لوحة التحكم'],
        'reports' => ['en' => 'reports', 'ar' => 'التقارير'],
        'categories' => ['en' => 'categories', 'ar' => 'الأقسام'],
        'subscriptions' => ['en' => 'subscriptions', 'ar' => 'الإشتراكات'],
        //course order
        'course' => ['en' => 'course orders', 'ar' => 'المتقدمين علي الكورسات'],
        'company' => ['en' => 'company owners', 'ar' => 'موظفين الشركات'],
        'courses' => ['en' => 'courses', 'ar' => 'الكورسات'],
        'cvs' => ['en' => 'cvs', 'ar' => 'السير الذاتيه'],
        'qualifications' => ['en' => 'qualifications', 'ar' => 'المؤهلات'],
        'jobs' => ['en' => 'jobs', 'ar' => 'الوظائف'],
        'states' => ['en' => 'states', 'ar' => 'المدن'],
        'cities' => ['en' => 'cities', 'ar' => 'المحافظات'],
        'countries' => ['en' => 'countries', 'ar' => 'الدول'],
        'attributes' => ['en' => 'attributes', 'ar' => 'الخصائص'],
        'packages' => ['en' => 'packages', 'ar' => 'الباقات'],
        'dashboard' => ['en' => 'dashboard access', 'ar' => 'لوحة التحكم'],
        'companies' => ['en' => 'companies', 'ar' => 'الشركات'],
        'notifications' => ['en' => 'notifications', 'ar' => 'الإشعارات العامة'],
        'settings' => ['en' => 'settings', 'ar' => 'الإعدادات'],
        'pages' => ['en' => 'pages', 'ar' => 'الصفحات'],
        'admins' => ['en' => 'admins', 'ar' => 'المدراء'],
        'users' => ['en' => 'users', 'ar' => 'الأعضاء'],
        'roles' => ['en' => 'roles', 'ar' => 'الأدوار والمهام'],
        'access' => ['en' => 'dashboard access', 'ar' => 'لوحة التحكم'],
    ];

    private $actions = [
        'add' => 'اضافة',
        'Add' => 'اضافة',
        'show' => 'عرض',
        'Show' => 'عرض',
        'edit' => 'تعديل',
        'Edit' => 'تعديل',
        'delete' => 'حذف',
        'Delete' => 'حذف',
        'admin Dashboard' => 'الوصول للوحة التحكم',
        'Access Company Dashboard' => 'الوصول للوحة تحكم الشركات',
    ];

    private $action_keys = [
        'add',
        'show',
        'edit',
        'delete',
        'Add',
        'Show',
        'Edit',
        'Delete',
        'Access Company Dashboard',
        'admin Dashboard',
        'Delete',
    ];
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'move translatable values from astrotomic/laravel-translatable package to spatie/laravel-translatable package for tables roles and permissions.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->comment("move permissions ...");
        foreach (Permission::all() as $perm) {
            $description_ar = '';
            $dec = PermissionTranslation::where(['permission_id' => $perm->id, 'locale' => 'ar'])->first();

            if ($dec) {

                if ($dec->description) {
                    if (in_array($dec->description , $this->action_keys)) {

                        $description_ar = $this->actions[$dec->description];
                    }else{
                        $description_ar = $dec->description;
                    }
                }
            }else{
                if (in_array(optional(PermissionTranslation::where(['permission_id' => $perm->id, 'locale' => 'en'])->first())->description , $this->action_keys)) {

                    $description_ar = $this->actions[optional(PermissionTranslation::where(['permission_id' => $perm->id, 'locale' => 'en'])->first())->description];
                }
            }
            $perm->update([
                'description' => [
                    'ar' => $description_ar,
                    'en' => optional(PermissionTranslation::where([
                            'permission_id' => $perm->id, 'locale' => 'en'
                        ])->first())->description ?? '',
                ],
                'display_name' => $this->display_name[explode('_', $perm->name)[count(explode('-', $perm->name))]]
            ]);
        }
        $this->info("permissions moved...");

        $this->comment("move Roles ...");
        foreach (Role::all() as $role) {
            $role->update([
                'description' => [
                    'ar' => optional(RoleTranslation::where([
                            'role_id' => $role->id, 'locale' => 'ar'
                        ])->first())->description ?? '',
                    'en' => optional(RoleTranslation::where([
                            'role_id' => $role->id, 'locale' => 'en'
                        ])->first())->description ?? '',
                ],
                'display_name' => [
                    'ar' => optional(RoleTranslation::where([
                            'role_id' => $role->id, 'locale' => 'ar'
                        ])->first())->display_name ?? '',
                    'en' => optional(RoleTranslation::where([
                            'role_id' => $role->id, 'locale' => 'en'
                        ])->first())->display_name ?? '',
                ],
            ]);
        }
        $this->info("Roles moved...");
    }
}
