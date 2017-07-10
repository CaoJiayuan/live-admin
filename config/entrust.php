<?php

/**
 * This file is part of Entrust,
 * a role & permission management solution for Laravel.
 *
 * @license MIT
 * @package Zizaco\Entrust
 */

return [

  /*
  |--------------------------------------------------------------------------
  | Entrust Role Model
  |--------------------------------------------------------------------------
  |
  | This is the Role model used by Entrust to create correct relations.  Update
  | the role if it is in a different namespace.
  |
  */
  'role'                  => 'App\Entity\Role',

  /*
  |--------------------------------------------------------------------------
  | Entrust Roles Table
  |--------------------------------------------------------------------------
  |
  | This is the roles table used by Entrust to save roles to the database.
  |
  */
  'roles_table'           => 'roles',

  /*
  |--------------------------------------------------------------------------
  | Application User Model
  |--------------------------------------------------------------------------
  |
  | This is the User model used by Entrust to create correct relations.
  | Update the User if it is in a different namespace.
  |
  */
  'user'                  => 'App\User',

  /*
  |--------------------------------------------------------------------------
  | Application Users Table
  |--------------------------------------------------------------------------
  |
  | This is the users table used by the application to save users to the
  | database.
  |
  */
  'users_table'           => 'users',

  /*
  |--------------------------------------------------------------------------
  | Entrust Permission Model
  |--------------------------------------------------------------------------
  |
  | This is the Permission model used by Entrust to create correct relations.
  | Update the permission if it is in a different namespace.
  |
  */
  'permission'            => 'App\Entity\Permission',

  /*
  |--------------------------------------------------------------------------
  | Entrust Permissions Table
  |--------------------------------------------------------------------------
  |
  | This is the permissions table used by Entrust to save permissions to the
  | database.
  |
  */
  'permissions_table'     => 'permissions',

  /*
  |--------------------------------------------------------------------------
  | Entrust permission_role Table
  |--------------------------------------------------------------------------
  |
  | This is the permission_role table used by Entrust to save relationship
  | between permissions and roles to the database.
  |
  */
  'permission_role_table' => 'permission_role',

  'role_user_table' => 'role_user',

  'user_foreign_key' => 'user_id',

  'role_foreign_key' => 'role_id',

  'super_admin' => [
    'username' => 'admin@honc.tech',
    'password' => '123456',
    'name'     => '总部管理员',
  ],
];