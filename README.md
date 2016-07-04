<h1>Развертывание на локальной машине</h1>

<h2>Требования: </h2>

<ul>
	<li>Nginx 1.x</li>
	<li>MySQL 5.x</li>
	<li>Git</li>
	<li>PHP 5.4</li>
</ul>

<h2>Условные обозначения</h2>

<p>{project-url} - адрес проекта<br />
{project-name} - имя проекта<br />
{project-path} – корневой каталог приложения<br />
{user-name} – имя пользователя на локальной машине</p>

<h2>Клонирование проекта</h2>

<p>Предварительно [[Подключение к GitLab через SSH|настроить SSH-подключение]], если требуется.</p>

<pre>
cd {project-path}

git clone git@gitlab.com:{project-name}.git
</pre>

<h2>Обновление субмодулей</h2>

<pre>
cd {project-name}

git submodule init

git submodule update
</pre>

<h2>Создание папки runtime</h2>

<pre>
mkdir protected/runtime

chmod 755 protected/runtime

chown www-data:www-data
</pre>

<p>Последняя команда устанавливает владельца и группу директории protected/runtime. Пользователь, от имени которого работают Nginx и php-fpm, должен совпадать с пользователем данной директории. В противном случае необходимо установить полные права на каталог - chmod 777 protected/runtime</p>

<h2>Создание базы данных</h2>

<p>В третьй команде замените {password} любым набором символов</p>

<pre>
mysql -u root –p

CREATE DATABASE `{project-name}` CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE USER '{project-name}'@'localhost' IDENTIFIED BY '{password}';

USE `{project-name}`;

GRANT ALL PRIVILEGES ON `{project-name}`.* TO '{project-name}'@'localhost';

</pre>

<p>Для первичного заполнения базы данных выполните миграции. В корне проекта: </p>
<pre>
php prodected/yiic migrate
</pre>

<p> </p>

<h2>Создание пользовательского файла конфигурации</h2>

<pre>
cp protected/config/dev_user.php protected/config/dev_{user-name}.php
</pre>

<p>Заполните и проверьте настройки базы данных в файле protected/config/dev_{user-name}.php</p>

<pre>
<code class="php">
<!--?php
Yii::import('system.collections.CMap');
$config = CMap::mergeArray(require('_main.php'), [
    'components' =--> [
        'db'  => [
            'connectionString' => 'mysql:host=127.0.0.1;dbname={project-name}', // check your db name
            'emulatePrepare'   => true,
            'username'         => 'user', // check your username
            'password'         => 'user', // enter your password
            'charset'          => 'utf8',
        ],
    ],
]
);
return $config;
</code></pre>

<h2>Редактирование файла hosts</h2>

<pre>
sudo nano /etc/hosts 
</pre>

<p>Добавляем строку</p>

<pre>
127.0.0.1 {project-url}
</pre>

<h2>Создание конфигурационного файла nginx</h2>

<pre>
cd /etc/nginx/sites-enabled/

sudo touch {project-name}.conf

sudo nano {project-name}.conf
</pre>

<p>Вставляем следующие настройки, заменив {project-path}, {project-name} и {user-name}</p>

<pre>
server 
{
    listen 80;
    server_name {project-name}.dev;
    charset utf-8;
    root {project-path}/public/;

    access_log /var/log/nginx/{project-name}/access.log;
    error_log /var/log/nginx/{project-name}/error.log;

    location / 
    {
        rewrite ^ /index.php?$args;
    }

    location ~ /\. 
    {
        deny all;
    }

    location ~ \.(js|css|png|jpg|gif|svg|swf|ico|pdf|mov|fla|zip|rar|xml|eot|svg|ttf|woff)$ 
    {
        try_files $uri =404;
    }

    location ~ \.php$ 
    {
        try_files $uri /index.php?$args;
        include fastcgi_params;
        fastcgi_param APPLICATION_MODE dev_{user-name};
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
}
</pre>

<h2>Создание символической ссылки</h2>

<pre>
sudo ln -s /etc/nginx/sites-enabled/{project-name}.conf /etc/nginx/sites-available/{project-name}.conf
</pre>

<p>В каталоге sites-enabled хранится полный список конфигурационных файлов nginx. Для того, чтобы активировать необходимую конфигурацию, на нее создается символическая ссылка в папке sites-available. Для отключения ненужной конфигурации достаточно удалить ссылку в директории sites-available. При этом сам файл настроек остается в каталоге sites-enabled. Для реализации этой возможности в файле /etc/nginx/nginx.conf должна быть строка include /opt/local/etc/nginx/sites-available/*.conf;</p>

<h2>Создание файлов для лога</h2>

<pre>
сd /var/log/nginx/

sudo mkdir {project-name}

sudo touch {project-name}/access.log

sudo touch {project-name}/error.log
</pre>

<h2>Перезагрузка nginx</h2>

<pre>
sudo nginx -s stop

sudo nginx 
</pre>

<h2>Запуск приложения</h2>

<p>Сайт должен быть доступен по адресу {project-url}</p>
