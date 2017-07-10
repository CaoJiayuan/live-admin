<?php namespace App\Repository;

use App\Entity\Meta;
use App\Traits\CreditsHelper;
use App\Traits\PermissionHelper;
use App\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use App\Entity\IpBan;
use App\Entity\Area;
use App\Entity\Room;
use App\Entity\Group;
use Illuminate\Support\Facades\DB;

/**
 * @author <a href="mailto:smartydroid.com@gmail.com">Smartydroid</a>
 */
class UsersRepository extends Repository
{
    use PermissionHelper, CreditsHelper;

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
            case 'area_admin':
                $data['filter'] = 'area_id';
                $data['value'] = $user->area_id;
                break;
            case 'room_admin':
                $data['filter'] = 'room_id';
                $data['value'] = $user->room_id;
                break;
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

    public function users()
    {
        return $this->getSearchAbleData(User::class, [
            'username', 'mobile', 'last_ip', 'name', 'nickname', 'online', 'last_login',
        ], function ($builder) {
            $builder->orderByDesc('last_login');
            $builder->with('ipBan');
            $builder->with('role');
            $builder->with('inviter');
            if (count($filter = self::_getSearch())) {
                $builder = $builder->where($filter['filter'], '=', $filter['value']);
            }
            $conditions = \Request::only([
                'area', 'room', 'group', 'agent'
            ]);
            list($area, $room, $group, $agent) = array_values($conditions);
            if ($area) $builder->where('area_id', '=', $area);
            if ($room) $builder->where('room_id', '=', $room);
            if ($group) $builder->where('group_id', '=', $group);
            if ($agent) $builder->where('agent_id', '=', $agent);
            $builder->whereNull('master_id');
//      $builder->whereNotNull('agent_id');
            $builder->select(['id', 'name', 'nickname', 'online', 'last_ip', 'last_login', 'mobile', 'qq', 'enable', 'status', 'inviter_id']);
        });
    }

    public function create()
    {
        $data['role'] = self::_getRole();
        $data['user'] = Auth::user();
        return $data;
    }

    public function updateOrCreate($data)
    {
        if (!$data['id']) {
            if (User::whereMobile($data['mobile'])->count()) {
                $date['code'] = 422;
                $date['message'] = '手机号码已存在';
                return $date;
            }
            $data['username'] = $data['mobile'];
            $data['password'] = bcrypt(substr($data['mobile'], 5, 6));
        }
        if (!User::whereUsername($data['inviter'])->count() && $data['inviter']) {
            $date['code'] = 422;
            $date['message'] = '没有该推荐人';
            return $date;
        }
        if ($data['inviter'] == $data['username']) {
            $date['code'] = 422;
            $date['message'] = '推荐人有误';
            return $date;
        }

        $inviter = User::whereUsername($data['inviter'])->first();
        $data['inviter_id'] = $inviter['id'];
        unset($data['inviter']);

        $room = $this->getAccessibleRoom();
        $roomId = $room->id;
        if (!$room->permission && !$room->main) {
            $roomId = $room->main_id;
        }
        Meta::$roomId = $roomId;

        $credits = Meta::getItem('invite_credit', 0);

        DB::transaction(function() use($data,$credits,$inviter){
            if ($data['id']){
                $user = User::whereId($data['id'])->first();
                if ($user['inviter_id'] != $data['inviter_id']) {
                    $this->changeCredits($inviter, $credits, '推荐积分');
                }
            }else{
                $this->changeCredits($inviter, $credits, '推荐积分');
            }
            User::updateOrCreate([
                'id' => $data['id']
            ], $data);
        });

        return ['code' => 200];
    }

    public function banIp($id)
    {
        $user = User::whereId($id)->select('last_ip')->first();
        if (IpBan::whereIp($user['last_ip'])->count()) {
            IpBan::whereIp($user['last_ip'])->delete();
        } else {
            IpBan::create(['ip' => $user['last_ip']]);
        }
    }

    public function disable($id)
    {
        $user = User::whereId($id)->select('enable')->first();
        $enable = $user['enable'] ? 0 : 1;
        User::whereId($id)->update(['enable' => $enable]);
    }

    public function gag($id)
    {
        $user = User::whereId($id)->select('status')->first();
        $status = $user['status'] ? 0 : 1;
        User::whereId($id)->update(['status' => $status]);
    }

    public function delete($id)
    {
        \DB::transaction(function () use ($id) {
            User::destroy($id);
        });
    }

    public function online()
    {
        return $this->getSearchAbleData(User::class, ['users.username', 'users.ua', 'users.last_ip', 'users.name', 'users.nickname', 'users.online', 'users.last_login', 'areas.name', 'rooms.title', 'groups.name', 'agents.name'],
            function ($builder) {
                $builder->orderByDesc('users.last_login');
                $builder->with('role');
                if (count($filter = self::_getSearch())) {
                    $builder = $builder->where('users.' . $filter['filter'], '=', $filter['value']);
                }
                $conditions = \Request::only([
                    'area', 'room', 'group', 'agent', 'ua'
                ]);
                list($area, $room, $group, $agent, $ua) = array_values($conditions);
                if ($area) $builder->where('users.area_id', '=', $area);
                if ($room) $builder->where('users.room_id', '=', $room);
                if ($group) $builder->where('users.group_id', '=', $group);
                if ($agent) $builder->where('users.agent_id', '=', $agent);
                if ($ua) {
                    if ($ua == 1) {
                        $builder->where('users.ua', '=', 'pc');
                    } else {
                        $builder->whereIn('users.ua', array('android', 'ios'));
                    }
                }
                $builder->where('users.online', '!=', 0);
                $builder->whereNull('users.master_id');
//        $builder->whereNotNull('users.agent_id');
                $builder->leftJoin('areas', 'areas.id', '=', 'users.area_id');
                $builder->leftJoin('rooms', 'rooms.id', '=', 'users.room_id');
                $builder->leftJoin('groups', 'groups.id', '=', 'users.group_id');
                $builder->leftJoin('users as agents', 'agents.id', '=', 'users.agent_id');
                $builder->select(['users.id', 'users.name', 'users.ua', 'users.nickname', 'users.online', 'users.last_ip', 'users.last_login', 'users.mobile', 'areas.name as aname', 'rooms.title', 'groups.name as gname', 'agents.name as agname']);
            });
    }

    public function getConditions()
    {
        $user = Auth::user();
        switch (self::_getRole()) {
            case 'super_admin':
                $data['areas'] = Area::orderBy('id', 'desc')->get();
                $data['rooms'] = self::getRooms();
                $data['groups'] = self::getGroups();
                $data['agents'] = self::getAgents();
                break;
            case 'area_admin':
                $data['areas'] = Area::whereId($user['area_id'])->get();
                $data['rooms'] = Room::orderBy('id', 'desc')->where('area_id', '=', $user['area_id'])->where('main', '=', 0)->get();
                $data['groups'] = self::getGroups();
                $data['agents'] = self::getAgents();
                break;
            case 'room_admin':
                $data['areas'] = Area::whereId($user['area_id'])->get();
                $data['rooms'] = Room::whereId($user['room_id'])->get();
                $data['groups'] = Group::orderBy('id', 'desc')->where('room_id', '=', $user['room_id'])->get();
                $data['agents'] = self::getAgents();
                break;
            case 'group_admin':
                $data['areas'] = Area::whereId($user['area_id'])->get();
                $data['rooms'] = Room::whereId($user['room_id'])->get();
                $data['groups'] = Group::whereId($user['group_id'])->get();
                $data['agents'] = self::getAgents();
                break;
            case 'agent_admin':
                $data['areas'] = Area::whereId($user['area_id'])->get();
                $data['rooms'] = Room::whereId($user['room_id'])->get();
                $data['groups'] = Group::whereId($user['group_id'])->get();
                $data['agents'] = User::whereId($user['id'])->get();
                break;
            default:
                break;
        }
        return $data;
    }

    private static function getRooms()
    {
        $area = \Request::get('area');
        if ($area) {
            return Room::orderBy('id', 'desc')->where('area_id', '=', $area)->where('main', '=', 0)->get();
        }
        return array();
    }

    private static function getGroups()
    {
        $room = \Request::get('room');
        if ($room) {
            return Group::orderBy('id', 'desc')->where('room_id', '=', $room)->get();
        }
        return array();
    }

    private static function getAgents()
    {
        $user = Auth::user();
        $group = \Request::get('group');
        if (self::_getRole() == 'group_admin' && !$group) {
            $group = $user['group_id'];
        }
        if ($group) {
            $builder = User::join('role_user', 'role_user.user_id', '=', 'users.id');
            $builder = $builder->join('roles', function ($join) {
                $join->on('roles.id', '=', 'role_user.role_id')
                    ->where('roles.name', '=', 'agent_admin');
            });
            $builder = $builder->select('users.*');
            return $builder->whereGroupId($group)->get();
        }
        return array();
    }
}