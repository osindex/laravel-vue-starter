## 安装
```
php artisan key:generate
php artisan admin:install
php artisan migrate
php artisan db:seed --class="Moell\Mojito\Database\MojitoTableSeeder"
php artisan db:seed
# 运行测试数据
php artisan db:seed --calss="Category"
```
## 运行
```
.env
APP_URL=xxx
npm run watch
```

## 注意
添加菜单会自动添加目录和文件，若协作则需要写入seed，同步菜单数据。

