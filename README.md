# AuthFernet 

Auth plugin for the Fernet framework

## Configuration

The configuration in fernet.yml is optional:

```yml
auth:
 invalidMessage: "Wrong username or password"
 userEntity: "App\Entity\MyUser"
 redirectTo: "/admin/"
```

If you set up the plugin manually don't forget to add **"fernet/doctrine"** to the plugins.json file.

## Usage

```php
<?php if ($this->auth->isLogged()): ?>
<Logout>Sign out</Logout>
<?php else: ?>
<Login />
<?php endif; ?>
```
