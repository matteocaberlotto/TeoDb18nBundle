TeoDb18nBundle:
===============


INSTALLATION:
-------------

- add line to composer.json and run "php composer.phar require "teo/db18n-bundle" 

- activate bundle into AppKernel.php

	```new Teo\Db18nBundle\TeoDb18nBundle()```

- bundle requires SonataAdminBundle to have admin working and knp behaviour + a2lix translation form to have translations


USAGE:
------

inside twig:

if you use ```|trans_db``` filter, translations will be retrieved from database.
