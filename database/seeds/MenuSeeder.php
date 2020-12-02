<?php

use Illuminate\Database\Seeder;
use Moell\Mojito\Models\Menu;
use Moell\Mojito\Models\PermissionGroup;
use Moell\Mojito\Models\Role;
use Spatie\Permission\Models\Permission;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->add('page-design', '页面设计', [
            'index' => 'el-icon-s-grid',
        ], true, 0, '/admin/page-design');
        $this->add('setting', trans('mojito.Setting'), [
            'index' => 'el-icon-guide',
            'update' => null,
            'store' => null,
            'destroy' => null,
        ], true, 2, '/admin/setting');
        // $this->add('room', '空间管理', [
        //     'index' => 'el-icon-house',
        // ], true, $systemId);
        $contentId = $this->add('content', '内容管理', [
            'index' => 'el-icon-wallet',
        ], true, 0, '/admin/content');
        $this->add('category', '栏目设置', [
            'index' => null,
            'update' => null,
            'store' => null,
            'destroy' => null,
        ], true, $contentId, '/admin/content/category');
        $this->add('article', '资讯内容', [
            'index' => null,
            'update' => null,
            'store' => null,
            'destroy' => null,
        ], true, $contentId, '/admin/content/article');
        $this->add('slider_group', '焦点图组', [
            'index' => null,
            'update' => null,
            'store' => null,
            'destroy' => null,
        ], true, $contentId, '/admin/content/slider_group');

        $this->add('user', '用户库', [
            'index' => 'el-icon-user',
        ], true, 0, '/admin/user');

        $organizeId = $this->add('organize', '组织机构', [
            'index' => 'el-icon-menu',
        ], true, 0, '/admin/organize');
        $this->add('dept', '部门管理', [
            'index' => null,
            'update' => null,
            'store' => null,
            'destroy' => null,
        ], true, $organizeId, '/admin/organize/dept');
        $this->add('dept-user', '部门用户', [
            'index' => null,
            'update' => null,
            'store' => null,
            'destroy' => null,
        ], true, $organizeId, '/admin/organize/dept-user');
        $this->preGivePermissionAndMenu();
        $this->AdminRoleGivePermission();
        $exitCode = \Artisan::call('permission:cache-reset', []);
    }
    public function add($router, $name, $permision, $createPermisson, $pid = 0, $routerReal = null)
    {
        $exsits = Menu::where('name', $name)->first();
        if (!$exsits) {
            $permisionKey = array_keys($permision);
            $mid = Menu::insertGetId([
                'parent_id' => $pid,
                'icon' => $permision[$permisionKey[0]] ?? null,
                'uri' => $routerReal ? $routerReal : '/' . $router,
                'is_link' => 0,
                'permission_name' => $createPermisson ? $router . '.' . ($permisionKey[0] ?? 'index') : '',
                'name' => $name,
                'guard_name' => 'admin',
            ]);
            if ($createPermisson) {
                $id = optional(PermissionGroup::where('name', $router)->first())->id;
                if (!$id) {
                    $id = PermissionGroup::insertGetId([
                        'name' => $router,
                    ]);
                }
                $this->addPermissions($permisionKey, $id, $router);
            }
        } else {
            $mid = $exsits->id;
        }
        return $mid;
    }

    public function addPermissions($permision, $id, $router = null)
    {
        foreach ($permision as $v) {
            if (is_null($router)) {
                $data = [
                    'name' => $v,
                    'guard_name' => 'admin',
                    'pg_id' => $id,
                    'display_name' => $v,
                    'created_name' => 'admin',
                ];
            } else {
                $data = [
                    'name' => $router . '.' . $v,
                    'guard_name' => 'admin',
                    'pg_id' => $id,
                    'display_name' => $v,
                    'created_name' => 'admin',
                ];
            }
            Permission::create($data);
        }
    }

    public function assign($name, $permissions)
    {
        if ($name instanceof Role) {
            $model = $name;
        } else {
            $model = Role::findByName($name, 'admin');
        }
        foreach ($permissions as $permission) {
            $model->givePermissionTo($permission);
        }
    }
    public function AdminRoleGivePermission()
    {
        $role = Role::first();
        // dd($role);
        $role->menus()->sync(Menu::pluck('id'));
        $permissions = Permission::all();
        $this->assign($role, $permissions);
    }

    public function preGivePermissionAndMenu()
    {
        // 需要添加的权限
        // $addPermissions = [
        //     'setting' => [
        //         'setting.index',
        //         'setting.update',
        //         'setting.store',
        //         'setting.destroy',
        //     ],
        // ];
        // foreach ($addPermissions as $key => $value) {
        //     $id = optional(PermissionGroup::where('name', $key)->first())->id;
        //     if (!$id) {
        //         $id = PermissionGroup::insertGetId([
        //             'name' => $key,
        //         ]);
        //     }
        //     $this->addPermissions($value, $id);
        // }
        /*
    // 需要给哪些用户分配什么权限
    $rolePermissions = [
    'consultation' => [
    'system.dialog',
    'student.index',
    'student_list.index',
    'student_followings.index',
    ],
    'teacher' => [
    'system.dialog',
    ],
    ];
    // 需要给哪些用户分配哪些菜单
    $roleMenus = [
    'consultation' => [
    '/student',
    '/student_list',
    '/dashboard',
    '/student_followings',
    ],
    'teacher' => [
    '/dashboard',
    ],
    ];
    // $roles = Role::all();
    // $menus = Menu::all();
    // $permissions = Permission::all();
    // foreach ($rolePermissions as $key => $value) {
    //     $role = $roles->where('name', $key)->first();
    //     if ($role) {
    //         $permission = $permissions->whereIn('name', $value);
    //         $this->assign($role, $permission);
    //     }
    // }
    // foreach ($roleMenus as $key => $value) {
    //     $role = $roles->where('name', $key)->first();
    //     if ($role) {
    //         $menuId = $menus->whereIn('uri', $value)->pluck('id');
    //         $role->menus()->sync($menuId);
    //     }
    // }
     */
    }
}
