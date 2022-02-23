<?php
/**
 * FauxTwigExtension for Craft CMS 3.x
 *
 * This is intended to be used with the Symfony Plugin for PhpStorm:
 * https://plugins.jetbrains.com/plugin/7219-symfony-plugin
 *
 * It will provide full auto-complete for craft.app. and and many other useful things
 * in your Twig templates.
 *
 * Place the file somewhere in your project or include it via PhpStorm Settings -> Include Path.
 * You never call it, it's never included anywhere via PHP directly nor does it affect other
 * classes or Twig in any way. But PhpStorm will index it, and think all those variables
 * are in every single template and thus allows you to use Intellisense auto completion.
 *
 * Thanks to Robin Schambach; for context, see:
 * https://github.com/Haehnchen/idea-php-symfony2-plugin/issues/1103
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2019 nystudio107
 */

namespace nystudio107\craft;

use craft\elements\Asset;
use craft\elements\Category;
use craft\elements\Entry;
use craft\elements\GlobalSet;
use craft\elements\MatrixBlock;
use craft\elements\User;
use craft\models\Site;
use craft\web\twig\variables\CraftVariable;
use craft\web\twig\variables\Paginate;
use craft\web\view;
use putyourlightson\blitz\variables\BlitzVariable;
use putyourlightson\sprig\variables\PaginateVariable;
use spacecatninja\imagerx\models\LocalTransformedImageModel;
use spacecatninja\imagerx\variables\ImagerVariable;
use Spatie\SchemaOrg\Schema;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use verbb\supertable\elements\SuperTableBlockElement;

/**
 * @author    nystudio107
 * @package   FauxTwigExtension
 * @since     1.0.0
 */
class FauxTwigExtension extends AbstractExtension implements GlobalsInterface
{
    public function getGlobals(): array
    {
        return [
            // Craft Variable
            'craft' => new CraftVariable(),
            // Craft Elements
            'asset' => new Asset(),
            'image' => new Asset(),
            'category' => new Category(),
            'entry' => new Entry(),
            'block' => new MatrixBlock(),
            'user' => new User(),
            // Misc. Craft globals
            'currentUser' => new User(),
            'currentSite' => new Site(),
            'site' => new Site(),
            'view' => new view(),
            'siteInfo' => new GlobalSet(),
            'blitz' => new BlitzVariable(),
            'pageInfo' => new Paginate(),
            'sprigPageInfo' => new PaginateVariable(),
            'imager' => new ImagerVariable(),
            'transform' => new LocalTransformedImageModel(),

            'schema' => new Schema(),
            // Commerce Elements
            //'lineItem' => new \craft\commerce\models\LineItem(),
            //'order' => new \craft\commerce\elements\Order(),
            //'product' => new \craft\commerce\elements\Product(),
            //'variant' => new \craft\commerce\elements\Variant(),
            //'commerce' => new \craft\commerce\Plugin(),
            // Third party globals
            //'seomatic' => new \nystudio107\seomatic\variables\SeomaticVariable(),
        ];
    }
}
