<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------


use think\Route;

Route::get('/', 'admin/index/index');
Route::get('ht', 'admin/index/index');

// 后台admin分组路由
Route::group('admin', function (){

    /********************  商 品   **********************/
    // 分类列表
    Route::get('goods/index', 'admin/goods/index');
    // 分类新增
    Route::any('goods/add', 'admin/goods/add');
    // 分类更新
    Route::any('goods/upd', 'admin/goods/upd');
    // 分类删除
    Route::get('goods/del', 'admin/goods/del');



    /********************  商品分类  **********************/
    // 分类列表
    Route::get('category/index', 'admin/category/index');
    // 分类新增
    Route::any('category/add', 'admin/category/add');
    // 分类更新
    Route::any('category/upd', 'admin/category/upd');
    // 分类删除
    Route::get('category/del', 'admin/category/del');


    /********************  属性类型  **********************/
    // 属性列表
    Route::get('attr/index', 'admin/attribute/index');
    // 属性新增
    Route::any('attr/add', 'admin/attribute/add');
    // 属性更新
    Route::any('attr/upd', 'admin/attribute/upd');
    // 属性删除
    Route::get('attr/del', 'admin/attribute/del');


    /********************  商品类型  **********************/
    // 查看商品类型的属性列表
    Route::get('type/getattr', 'admin/type/getAttr');
    // 商品类型列表
    Route::get('type/index', 'admin/type/index');
    // 商品类型编辑
    Route::any('type/upd', 'admin/type/upd');
    // 商品类型添加
    Route::any('type/add', 'admin/type/add');
    // 商品类型删除
    Route::get('type/del', 'admin/type/del');

    /********************  角色管理  **********************/
    // 角色添加
    Route::any('role/add', 'admin/role/add');
    // 角色列表
    Route::get('role/index', 'admin/role/index');
    // 角色编辑
    Route::any('role/upd', 'admin/role/upd');
    // 角色删除
    Route::get('role/del', 'admin/role/del');

    /********************  用户权限管理  **********************/
    // 权限添加
    Route::any('auth/add', 'admin/auth/add');
    // 权限列表
    Route::get('auth/index', 'admin/auth/index');
    // 权限编辑
    Route::any('auth/upd', 'admin/auth/upd');
    // 权限删除
    Route::get('auth/del', 'admin/auth/del');



    /********************  后台首页路由  **********************/
    // 后台首页路由
    Route::get('index/top', 'admin/index/top');
    Route::get('index/left', 'admin/index/left');
    Route::get('index/main', 'admin/index/main');



    /********************  用户管理路由  **********************/
    Route::any('user/add', 'admin/user/add');
    // 用户列表
    Route::get('user/index', 'admin/user/index');
    // 删除用户
    Route::get('user/del', 'admin/user/del');
    // 编辑用户
    Route::any('user/upd', 'admin/user/upd');



    /************************  登录与退出  ************************/
    // 登录
    Route::any('public/login', 'admin/public/login');
    // 退出登录
    Route::any('public/logout', 'admin/public/logout');

});

