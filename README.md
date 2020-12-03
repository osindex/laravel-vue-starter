## 介绍
本项目基础框架`laravel`、`vue`，根据以前的项目整合的脚手架，使用了[avue](https://avuejs.com/)、[mojito](https://github.com/osindex/mojito)、[lct](https://github.com/osindex/LaravelControllerTrait)等开源项目,开箱即用。
## 说明
技术有限，定期更新修复漏洞。
## 特点
 - 前后端分离后台模板
 - 后台菜单自动创建前端路由及基础vue文件
 - 后端使用`artisan trait:controller TestController`自动创建Restfull标准接口及model文件（只需要在api.php加入路由映射）
 - 前端使用自己二次封装的avue模板，几分钟完成一个页面（具体查看，js目录下的md文件）
## 安装
```
php artisan key:generate
php artisan admin:install
php artisan migrate
php artisan db:seed --class="Moell\Mojito\Database\MojitoTableSeeder"
php artisan db:seed
# 运行测试数据
php artisan db:seed --class="\FakerData"
```
## 运行
```
.env
APP_URL=xxx
npm run watch
```

## 注意
添加菜单会自动添加目录和文件，若协作则需要写入seed，同步菜单数据。

