<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-4-28
 * Time: 上午11:34
 */
return [
  [
    'name'         => 'home',
    'display_name' => '首页',
    'path'         => '/',
    'icon'         => 'fa fa-th-large',
    'type'         => 0,
  ],
  [
    'name'         => 'room',
    'display_name' => '房间管理',
    'path'         => '#',
    'icon'         => 'fa fa-home',
    'type'         => 0,
    'node'         => [
      [
        'name'         => 'room.areas',
        'display_name' => '区域列表',
        'path'         => '/room/areas',
        'type'         => 0,
      ],
      [
        'name'         => 'room.rooms',
        'display_name' => '子房间列表',
        'path'         => '/room/rooms',
        'type'         => 0,
      ],
      [
        'name'         => 'room.setting',
        'display_name' => '房间设置',
        'path'         => '/room/setting',
        'type'         => 0,
      ],
      [
        'name'         => 'room.groups',
        'display_name' => '团队列表',
        'path'         => '/room/groups',
        'type'         => 0,
      ],
      [
        'name'         => 'room.votes',
        'display_name' => '投票管理',
        'path'         => '/room/votes',
        'type'         => 0,
      ],
      [
        'name'         => 'room.popups',
        'display_name' => '弹窗广告',
        'path'         => '/room/popups',
        'type'         => 0,
      ],
      [
        'name'         => 'room.services',
        'display_name' => '客服管理',
        'path'         => '/room/services',
        'type'         => 0,
      ],
      [
        'name'         => 'room.notices',
        'display_name' => '视频公告',
        'path'         => '/room/notices',
        'type'         => 0,
      ],
      [
        'name'         => 'room.banners',
        'display_name' => '广告管理',
        'path'         => '/room/banners',
        'type'         => 0,
      ],
      [
        'name'         => 'room.lecturers',
        'display_name' => '讲师管理',
        'path'         => '/room/lecturers',
        'type'         => 0,
      ],
      [
        'name'         => 'room.schedules',
        'display_name' => '课程表管理',
        'path'         => '/room/schedules',
        'type'         => 0,
      ],
      [
        'name'         => 'room.copyright',
        'display_name' => '版权说明',
        'path'         => '/room/copyright',
        'type'         => 0,
      ],
      [
        'name'         => 'room.disclaimer',
        'display_name' => '免责声明',
        'path'         => '/room/disclaimer',
        'type'         => 0,
      ],
      [
        'name'         => 'room.interactive',
        'display_name' => '活动介绍',
        'path'         => '/room/interactive',
        'type'         => 0,
      ],
      [
        'name'         => 'room.goldLecturer',
        'display_name' => '金牌讲师',
        'path'         => '/room/goldLecturer',
        'type'         => 0,
      ],
      [
        'name'         => 'room.gifts',
        'display_name' => '礼物管理',
        'path'         => '/room/gifts',
        'type'         => 0,
      ],
      [
        'name'         => 'room.credits',
        'display_name' => '积分规则',
        'path'         => '/room/credits',
        'type'         => 0,
      ],
      [
        'name'         => 'room.goods',
        'display_name' => '商品管理',
        'path'         => '/room/goods',
        'type'         => 0,
      ],
      [
        'name'         => 'room.orders',
        'display_name' => '兑换管理',
        'path'         => '/room/orders',
        'type'         => 0,
      ],
    ],
  ],
  [
    'name'         => 'credits',
    'display_name' => '积分管理',
    'path'         => '#',
    'icon'         => 'fa fa-credit-card',
    'type'         => 0,
    'node'         => [
      [
        'name'         => 'credits.online',
        'display_name' => '上线积分规则',
        'path'         => '/credits/online',
        'type'         => 0,
      ],
      [
        'name'         => 'credits.others',
        'display_name' => '其他',
        'path'         => '/credits/others',
        'type'         => 0,
      ]
    ],
  ],
  [
    'name'         => 'users',
    'display_name' => '用户管理',
    'path'         => '#',
    'icon'         => 'fa fa-users',
    'type'         => 0,
    'node'         => [
      [
        'name'         => 'users.index',
        'display_name' => '用户列表',
        'path'         => '/users',
        'type'         => 0,
        'node'         => [
          [
            'name' => 'users.add',
            'type' => 1,
          ],
          [
            'name' => 'users.edit',
            'type' => 1,
          ],
          [
            'name' => 'users.banip',
            'type' => 1,
          ],
          [
            'name' => 'users.status',
            'type' => 1,
          ],
          [
            'name' => 'users.disable',
            'type' => 1,
          ],
        ],
      ],
      [
        'name'         => 'users.robots.index',
        'display_name' => '机器人列表',
        'path'         => '/users/robots',
        'type'         => 0,
        'node'         => [
          [
            'name' => 'users.robots.add',
            'type' => 1,
          ],
          [
            'name' => 'users.robots.edit',
            'type' => 1,
          ],
          [
            'name' => 'users.robots.delete',
            'type' => 1,
          ],
        ],
      ],
      [
        'name'         => 'users.online.index',
        'display_name' => '在线用户列表',
        'path'         => '/users/online',
        'type'         => 0,
      ],
    ],
  ],
  [
    'name'         => 'admin',
    'display_name' => '管理员管理',
    'path'         => '#',
    'icon'         => 'fa fa-user',
    'type'         => 0,
    'node'         => [
      [
        'name'         => 'admin.groupsl',
        'display_name' => '团队列表',
        'path'         => '/admin/groupsl',
        'type'         => 0,
      ],
      [
        'name'         => 'admin.areas',
        'display_name' => '区域管理员',
        'path'         => '/admin/areas',
        'type'         => 0,
      ],
      [
        'name'         => 'admin.rooms',
        'display_name' => '房间管理员',
        'path'         => '/admin/rooms',
        'type'         => 0,
      ],
      [
        'name'         => 'admin.groups',
        'display_name' => '团队经理',
        'path'         => '/admin/groups',
        'type'         => 0,
      ],
      [
        'name'         => 'admin.agents',
        'display_name' => '业务员',
        'path'         => '/admin/agents',
        'type'         => 0,
      ],
    ],
  ],
  [
    'name'         => 'statistics',
    'display_name' => '数据统计',
    'path'         => '#',
    'icon'         => 'fa fa-paper-plane',
    'type'         => 0,
    'node'         => [
      [
        'name'         => 'statistics.login',
        'display_name' => '今日登陆',
        'path'         => '/statistics/login',
        'type'         => 0,
      ],
      [
        'name'         => 'statistics.online',
        'display_name' => '日在线人数',
        'path'         => '/statistics/online',
        'type'         => 0,
      ],
      [
        'name'         => 'statistics.history',
        'display_name' => '历史统计数据',
        'path'         => '/statistics/history',
        'type'         => 0,
      ],
      [
        'name'         => 'statistics.area',
        'display_name' => '区域统计',
        'path'         => '/statistics/area',
        'type'         => 0,
      ],
      [
        'name'         => 'statistics.room',
        'display_name' => '房间统计',
        'path'         => '/statistics/room',
        'type'         => 0,
      ],
      [
        'name'         => 'statistics.group',
        'display_name' => '团队统计',
        'path'         => '/statistics/group',
        'type'         => 0,
      ],
      [
        'name'         => 'statistics.groupjl',
        'display_name' => '团队统计',
        'path'         => '/statistics/groupjl',
        'type'         => 0,
      ],
    ],
  ],
];