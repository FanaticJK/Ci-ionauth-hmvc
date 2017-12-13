
#CI - Ion-Auth Hmvc - Material Design

This file contains a ready to go system which contains Codeigniter with Ion-Auth and HMVC with material design.

##Installation

- .htaccess
change the RewriteBase to your base folder name.
```
    RewriteEngine On
    RewriteBase /ci-ion-auth-hmvc-material-design/
```

- Database (application/database.php)
change the name, user and password as required
```
'username' => 'root',

'password' => '',

'database' => 'cihmva',
```

- Config (application/config.php)
change the url as required
```
$protocol = is_https() ? "https://" : "http://";
$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : "";
if ($_SERVER['HTTP_HOST'] == "localhost" || $_SERVER['HTTP_HOST'] == "127.0.1.1") {
    // $config['base_url']='http://localhost/yoursite/';
    $config['base_url'] = $protocol.$host."/radius/";
} else {
    $config['base_url'] = $protocol.$host;
}
```

##Login Credential
```
Default username and password are:
Username: admin@admin.com
Password: password
```