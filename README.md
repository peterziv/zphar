# zphar
The tool is to package the php scripts as phar format



## Options

Usage: php zphar.phar [options]
options:
  --dir        The full or relative path to the directory
  --name       The package name (without .phar)
  --default    The file path handler to be used as the executable stub for this phar archive.
  --compress   [Optional]gz or bz2 or none, default is bz2



## How to use
- Download the zphar.phar

- Put your code files in one folder, such as MyFolder

- The directory structure:

  -- Current Workspace

  ​	-- zphar.phar

  ​	-- MyFolder (contains default.php)

- Example to do packaging:


```php
php zphar.phar --name a --default default.php --dir MyFoder
  
// It will package MyFoder as a.phar
// If MyFoder is just one Foder name, it should be under current work space -- the directionary to execute the command.
// default.php is the laucher script
```

ps: You can also put the zphar.phar in the system environment.

