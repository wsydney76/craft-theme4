# Theme Craft Starter

(Semi-) flexible Craft Starter Project.

Usefull for demos and hobby projects.

##  Installation

* Run `composer install`
* Edit `config/Env.php` with your environment specific settings
* Run `php craft install`

Set up your dev environment:

* Run 'npm install' to enable frontend builds and IDE code completion for Tailwind. Available commands:
  * npm run dev - creates dev assets
  * npm run hot - enable hot module reload
  * npm run build - create production assets
* PhpStorm: Enable Symfony plugin, mark `web/assets/dist` and `web/cpresources` as excluded. Invalided caches and Restart

## Theme customization

* Update Globals
* Change settings in `config/theme.php`
* Update `tailwind.config.js` and run `npm run ...`
* By default, the main navigation reflects the structure of your Pages section, but you can override this by setting `Globals -> Site Info -> Navigation Entries`

## Faker content

* Upload some images into the images volume
* Run `php craft main/seed/create-entries` to seed the system with some dummy entries.

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
* Forgotpassword - Request password reset
* Setpassword - Set new password
* Invalidtoken - Invalid or expired token message

Run `php craft main/seed/create-members-entries` to generate simple starter entries.

You are free to customize any of this, just include the actions in templates/_members whereever you want.

Required Plugins: Sprig (Craft), Tailwind CSS Forms (Frontend)

## TBD

Some optimizations are missing

* Set image sizes attributes where appropriate
* More eager loading
