<?php

namespace Code\Role\database\seeds;

use Code\Admin\Model\Admin;
use Code\Role\Model\Permission;
use Code\Role\Model\Role;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Admin::where('email', 'me@sarav.co')->first();

        $role = Role::create([
            'name'         => 'super_admin',
            'display_name' => 'Super Admin',
            'description'  => 'Has overall access throughout the website'
        ]);

        $admin->roles()->sync([$role->id]);

        $routeCollection = \Route::getRoutes();

		$permissions = Permission::pluck('name')->toArray();

		$modules = ['admins', 'users', 'settings', 'roles'];

		foreach ($routeCollection as $value) {
			$name = explode('.', trim($value->getName()));
			$desc = null;
			if (count($name) > 1) {
                if(count($name) == 4){
                    if ($name[0] === "admin" && in_array($name[1].".".$name[2], $modules)) {
                        if (!in_array(implode('.', $name), $permissions)) {
                            $module = str_singular($name[1]).".".str_singular($name[2]);
                            $end    = isset($name[3]) ? $name[3] : null;
                            switch($end) {
                                case 'index':
                                case 'get':
                                    $desc = "Ability to view ".$name[1]." ".$name[2]." listings";
                                    break;

                                case 'create':
                                    $desc = "Ability to create new ".$module;
                                    break;

                                case 'store':
                                    $desc = "Ability to store ".$module." listings";
                                    break;

                                case 'show':
                                    $desc = "Ability to view individual ".$module." records";
                                    break;

                                case 'edit':
                                    $desc = "Ability to edit ".$module;
                                    break;

                                case 'update':
                                case 'post':
                                    $desc = "Ability to update ".$module." records";
                                    break;

                                case 'destroy':
                                    $desc = "Ability to delete ".$module;
                                    break;

                                default :
                                    $desc = "";
                                    break;
                            }

                            Permission::create([
                                'name'         => implode('.', $name),
                                'display_name' => ucfirst($name[1])." ".ucfirst($name[2]),
                                'description'  => $desc
                            ]);
                        }
                    }
                }else{
                    if ($name[0] === "admin" && in_array($name[1], $modules)) {
                        if (!in_array(implode('.', $name), $permissions)) {
                            $module = str_singular($name[1]);
                            $end    = isset($name[2]) ? $name[2] : null;
                            switch($end) {
                                case 'index':
                                case 'get':
                                    $desc = "Ability to view ".$name[1]." listings";
                                    break;

                                case 'create':
                                    $desc = "Ability to create new ".$module;
                                    break;

                                case 'store':
                                    $desc = "Ability to store ".$module." listings";
                                    break;

                                case 'show':
                                    $desc = "Ability to view individual ".$module." records";
                                    break;

                                case 'edit':
                                    $desc = "Ability to edit ".$module;
                                    break;

                                case 'update':
                                case 'post':
                                    $desc = "Ability to update ".$module." records";
                                    break;

                                case 'destroy':
                                    $desc = "Ability to delete ".$module;
                                    break;

                                default :
                                    $desc = "";
                                    break;
                            }
                            Permission::create([
                                'name'         => implode('.', $name),
                                'display_name' => ucfirst($name[1]),
                                'description'  => $desc
                            ]);
                        }
                    }
                }
			}
		}

		$permissions = Permission::all();

		$role = Role::first();

		$role->permission()->sync(collect($permissions)->pluck('id')->toArray());

		cache()->forget('permissions.records');
		cache()->forever('permissions.records', $permissions);
    }
}
