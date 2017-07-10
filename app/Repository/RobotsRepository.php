<?php namespace App\Repository;

use App\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * @author <a href="mailto:smartydroid.com@gmail.com">Smartydroid</a>
 */
class RobotsRepository extends Repository
{

    private static function _getRole()
    {
        return Auth::user()->roles->first()->name;
    }

    private static function _getSearch()
    {
        $role = self::_getRole();
        $user = Auth::user();
        $data = array();
        switch ($role) {
            case 'group_admin':
                $data['filter'] = 'group_id';
                $data['value'] = $user->group_id;
                break;
            case 'agent_admin':
                $data['filter'] = 'agent_id';
                $data['value'] = $user->id;
                break;
            default:
                break;

        }
        return $data;
    }

    public function index()
    {
        return $this->getSearchAbleData(User::class, [
            'agent.name', 'users.name'
        ], function ($builder) {
            if (count($filter = self::_getSearch())) {
                $builder = $builder->where('users.' . $filter['filter'], '=', $filter['value']);
            }
            $builder->join('users as agent', 'agent.id', '=', 'users.agent_id');
            $builder->whereNotNull('users.master_id');
            $builder->select(['agent.name as aname', 'users.name', 'users.level', 'users.id']);
        });
    }

    public function create()
    {
        $data['role'] = self::_getRole();
        $data['user'] = Auth::user()->toArray();
        return $data;
    }

    public function store($data)
    {
        if(!$data['id']) {
            $data['name'] = ltrim(chop($data['name'], "，"), "，");
            DB::transaction(function () use ($data) {
                $names = explode("，", $data['name']);
                unset($data['name']);
                foreach ($names as $v) {
                    $data['name'] = $v;
                    User::updateOrCreate([
                        'id' => $data['id']
                    ], $data);
                }
            });
        }else{
            User::updateOrCreate([
                'id' => $data['id']
            ], $data);
        }
    }

    public function edit($id)
    {
        return User::find($id)->toArray();
    }

    public function destroy($id)
    {
        User::destroy($id);
    }
}