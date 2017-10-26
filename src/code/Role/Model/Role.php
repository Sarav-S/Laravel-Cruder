<?php 

namespace Code\Role\Model;

use Code\Core\Model\Model;
use Illuminate\Cache\TaggableStore;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;

class Role extends Model
{
    protected $fillable = ["name", "display_name", "description"];

	public function permission()
	{
		return $this->belongsToMany(Permission::class, 'permission_role', 'role_id', 'permission_id');
	}

    public function cachedPermissions()
    {
        $rolePrimaryKey = $this->primaryKey;
        $cacheKey       = 'permissions_for_role_' . $this->$rolePrimaryKey;

        if (Cache::getStore() instanceof TaggableStore) {
            return Cache::tags('permission_role')
            ->remember($cacheKey, 60, function () {
                return $this->permission()->get();
            });
        } 

        return $this->permission()->get();
    }

	public $columns = [
        [
            'name'  => 'Display Name',
            'index' => 'display_name'
        ],
        [
            'name'  => 'Name',
            'index' => 'name'
        ],
        [
            'name'  => 'Created On',
            'index' => 'created_at',
            'type'  => 'date'
        ],
    ];
}