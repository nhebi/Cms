CMS
===

Introduction
------------
This is a content management module for Zend Framework 2 apps.

Requirements
------------
Requires Zend Framework 2 and DoctrineORMModule.

Installation
------------
You'll need to have a ZF2 application already up and running, so get that first.

Install into your vendor directory from GitHub with this command:

     git clone git@github.com:nhebi/cms.git

Then install dependencies using Composer:

     php composer.phar update

Next you'll need to update your database with the table for pages. Run the SQL
file here:

     [data/schema.sql](data/schema.sql)

(Or just use Doctrine Migrations to generate the SQL from the [page entity]
(src/Nhebi/Cms/Entity/Page.php) annotations.

Make sure that the data/cache folder exists in your application and is writable.

Now navigate to /pages and you should be able to click "Add a Page."


