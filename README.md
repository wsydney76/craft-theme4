# Theme Craft Starter

(Semi-) flexible Craft Starter Project.

Usefull for demos and hobby projects.

## Prerequisits

* Check [recommended server requirements](https://craftcms.com/docs/3.x/requirements.html).
* PHP 8 is required in `composer.json`, but you can set that to 7.4 before running `composer install` if needed.
* Create a MySql database.
* Set up a web server pointing to the `web` directory of your project. Alternatively you can run `php craft serve` and use `http://localhost:8080` as your domain.

##  Installation

* Run `composer install --no-dev`
* Edit `config/Env.php` with your environment specific settings.
* Run `php craft install` Enter you user data and confirm the other settings.
* Run `php craft main/init` Sets up things you will always need.

## Install with Craft Nitro

Replace `project` with your project name

* Open Terminal (On Windows: Open WSL2 Terminal (e.g. Ubuntu) as administrator)
* `cd <your-dev-directory`
* `nitro create https://github.com/wsydney76/craft-theme project`
  * Confirm hostname `project.nitro` and webroot `web`
  * Choose a PHP version: 8.0
  * Add a database: Y
  * Select MySql
  * Enter database name: project
* On Windows: Follow the instructions to update your hosts file from a Windows shell terminall
* On Windows: run `sudo chmod -R 777 project` (More sensitive minds follow the 'Nitro on Windows' documentation...)
* Edit `config/Env.php` with your environment specific settings
  * DB_SERVER: Name of the nitro db container, typically `mysql-8.0-3306.database.nitro`
  * DB_DATABASE: As assigned above
  * DB_USER: nitro
  * DB_PASSWORTD: nitro
  * DEFAULT_SITE_URL: `https://project.nitro`
* `cd project`
* Run `nitro craft install` Enter you user data and confirm the other settings.
* Run `nitro craft migrate/all`

* For creating faker content/membership entries as described below replace `php craft` with `nitro craft`

## Set up your dev environment:

* Run 'npm install' to enable frontend builds and IDE code completion for Tailwind. Available commands:
  * npm run dev - creates dev assets
  * npm run hot - enable hot module reload
  * npm run build - create production assets
* PhpStorm: Enable Symfony plugin, mark `web/assets/dist` and `web/cpresources` as excluded. Invalided caches and Restart

## Customization

* Update user settings (name, photo, preferred language)
* Update Globals
* Change settings in `config/theme.php`
* Update `tailwind.config.js` and run `npm run ...`
* By default, the main navigation reflects the structure of your Pages section, but you can override this by setting `Globals -> Site Info -> Navigation Entries`
* By default, versioning of entries is not enabled. (We have never seen this used in the wild...) Goto settings -> section to enable versioning if needed.
* CP styles can be customized in `modules/resources/cp/dist/cp_styles.css`

## Faker content

* Upload some images into the images volume, if you want to use your own images for faked content.
* Run `php craft main/seed/seed-content` to seed the system with some images and dummy entries, update Homepage and global Site Info, and create image transforms.
* Run `php craft main/seed/create-entries` at any time to create more random entries.
* Run `php craft main/seed/create-images` at any time to download random images.
* Run `php craft main/seed/create-transform` at any time to create missing image transforms.
* Run `php craft main/seed/reset-homepage` at any time populate the homepage with some random article blocks.

## Localization

The default web site is set up for German, any starter content is only created in German.

A second site is prepared for English, however it is not enabled by default.

Do one of the following:

### You do not plan a multi site project?

* Delete the second site
* Change the language of the primary site, if required.

### You plan a multi site project?

* Enable the second site
* Change the language of the second site.
* Translate any existing content.

### You plan a third, fourth, fifth... site

* Add the site and select the required language.
* Update sections settings accordingly.
* Translate any existing content.

### You created a site other than German or English?
* Add translations for static strings. `translations/<lang>/site.php`
* If you run a membership sites, update the relevant paths in `config/general.php`.

### You don't know what you want?
* Do nothing. Like in real life.

## Setting up a membership site

If you do not plan a membership site, you can safely delete templates/_members, the entry type page/members and the user group members.

Theme comes with preconfigured settings using 'members', you can change that to anything you want, but we will stick to that naming for this instructions.

We do not want to use boring default forms, therefore you can create pages with matching titles, teasers, featured images and add some helping content. 

Set up entries for all the relevant member actions. By default, use section=Page, type=Members. Make sure the URIs match the corresponding settings in `config/general.php` for all sites.
Select a members template in order to include the required action: 

* Members - Starting point for member content
* Login - Login page
* Register - Register new account
* Profile - Edit profile, incl. username, photo, email, password,
* Forgotpassword - Request password reset
* Setpassword - Set new password
* Invalidtoken - Invalid or expired token message

Run `php craft main/seed/create-members-entries` to generate simple starter entries.

You are free to customize any of this, just include the actions in templates/_members whereever you want.

Required Plugins: Sprig (Craft), Tailwind CSS Forms (Frontend)

## License

Both Craft CMS and the Imager X Plugin are paid software. However you can use both for free
on any [non public domain.](https://craftcms.com/knowledge-base/how-craft-license-enforcement-works#how-do-we-determine-craft-is-running-on-a-public-domain).

In case you can't pay for use on a public domain: (You should, the devs have to pay for their living...)

* Downgrade Craft edition to 'SOLO'. You will loose all multi user and GraphQL functionality.
* Uninstall Imager X. Will fallback to Crafts own image handling, loosing a bit of quality and a lot of control.

## Plugins

The following plugins are used:

### Required Craft plugins

Will not work at all without those (or require some dev work to drop them)

* Super Table: Workaround for missing 'matrix in matrix'. Used a lot in content modelling.
* Redactor: Rich text editing 
* Asset Rev: Required to match the build workflow.
* Embedded Assets: Required for Embed block.
* Sprig: Frontend reactivity, used in search und pagination

### Other plugins

These can be uninstall without breaking the site.

* Imager X (paid): Better quality and more control for image handling. Will fallback to Crafts native functionality if uninstalled.
* SEOMate: Can be uninstalled if you do not want to be found. Or replace with (paid) SEOMatic plugin.
* Smith: Adds copy & paste functionality to matrix blocks.
* MatrixMate: Adds grouping of blocks and tabs to matrix blocks.

Private Plugins: 'Unofficial' plugins. Consider as beta.

* Element Map: Shows reverse relationships in the Control Panel
* Work: Proof of concept for improving the editing workflow (most useful for comparing draft content with current version)

Not installed, but recommended

* Blitz:  Paid caching plugin. A `config/blitz.php` settings file is provided.

## TBD

Guide default content is not yet updated to match the workflow changes in Craft 3.7

Some optimizations are missing

* Set image sizes attributes where appropriate
* More eager loading
