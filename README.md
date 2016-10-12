# zphar
The tool is to package the php scripts as phar format



## Options

Usage: php zphar.phar [options]
options:

  --dir           The full or relative path to the directory

  --name          It can be full or relative package path( suggest that it ends with .phar)

  --default       The file path handler to be used as the executable stub for this phar archive.

  --compress      *[Optional]*  gz or bz2 or none, default is bz2



## How to use
- Download the zphar.phar (You can download in the release package, such as [1.0](https://github.com/peterziv/zphar/releases/download/1.0/zphar.phar))

- Put your code files in one folder, such as MyFolder

- The directory structure:

  -- Current Workspace

  ​	-- zphar.phar

  ​	-- MyFolder (contains default.php and others)

- Example to do packaging:


```php
php zphar.phar --name a.phar --default default.php --dir MyFoder
  
// It will package the code files in MyFoder as a.phar
// If MyFoder is just one Foder name, it should be under current work space -- the directionary to execute the command.
// default.php is the laucher script
```

ps: You can also put the zphar.phar in the system environment and add one shell script to load it.

example: add one bat script named zphar.bat on Windows:

```powershell
@echo off

set location=%~dp0
@php "%location%zphar.phar" %*
```

The command can be simplified as :

```powershell
zphar --name a.phar --default default.php --dir MyFoder
```





