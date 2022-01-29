# Theme Craft Starter

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

## Setting up a membership site

If you do not plan a membership site, you can safely delete templates/_members, the entry type page/members and the user group members.

Theme comes with preconfigured settings using 'members', you can change that to anything you want, but we will stick to that naming for this instructions.

We do not want to use boring default forms, therefore you can create pages with matching titles, teasers, featured images and add some helping content. 

Set up entries for all the relevant member actions. By default, use section=Page, type=Members. Make sure the URIs match this conventions for all sites:

* members - Starting point for member content. Add the dynamic block 'Members' as the first block.
* members/login - Login page
* members/register - Register new account
* members/forgotpassword - Request password reset
* members/setpassword - Set new password

You are free to customize any of this, just include the actions in templates/_members whereever you want.

Required Plugins: Sprig (Craft), Tailwind CSS Forms (Frontend)
