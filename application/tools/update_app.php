<?php defined('C5_EXECUTE') or die("Access Denied");

use Application\Installer\Installer;

$installer = Core::make('installer');
$nav = Core::make('helper/navigation');

/*
|--------------------------------------------------------------------------
| Refresh Entities
|--------------------------------------------------------------------------
*/

$installer->installGroup("Database Updates", function (Installer $installer)
{
    echo $installer->refreshEntities();
});


/*
|--------------------------------------------------------------------------
| Install Page Templates
|--------------------------------------------------------------------------
*/

$installer->installGroup("Page Templates", function (Installer $installer)
{
    echo $installer->installPageTemplate('full', t('Full Width'), 'full.png');
    echo $installer->installPageTemplate('home', t('Home Page'), 'home.png');
    // echo $installer->installPageTemplate('right_sidebar', t('Right Sidebar'), 'right_sidebar.png');
    // echo $installer->installPageTemplate('left_sidebar', t('Left Sidebar'), 'left_sidebar.png');
});

/*
|--------------------------------------------------------------------------
| Install Attribute Types
|--------------------------------------------------------------------------
*/

$installer->installGroup("Attribute Types", function (Installer $installer)
{
    echo "No custom attribute types defined";
});

/*
|--------------------------------------------------------------------------
| Install Page Attribute Keys
|--------------------------------------------------------------------------
*/

$installer->installGroup("Page Attributes", function (Installer $installer)
{
    echo $installer->installPageAttribute('title_image', 'Title Image', 'image_file');
});

/*
|--------------------------------------------------------------------------
| Install Single Pages
|--------------------------------------------------------------------------
*/

$installer->installGroup("Single Pages", function (Installer $installer)
{
    echo $installer->installSinglePage('/dashboard/system/basics/keys', 'Keys & IDs');
    echo $installer->installSinglePage('/adopt/available-dogs', 'Available Dogs');
});

/*
|--------------------------------------------------------------------------
| Install Themes
|--------------------------------------------------------------------------
*/

$installer->installGroup("Themes", function (Installer $installer)
{
    echo $installer->installTheme('gpa');
});

/*
|--------------------------------------------------------------------------
| Install and Refresh Block Types
|--------------------------------------------------------------------------
*/

$installer->installGroup("Block Types", function (Installer $installer)
{
    $blockTypes = [];

    foreach ($blockTypes as $blockType)
    {
        echo $installer->installBlockType($blockType);
        echo $installer->refreshBlockType($blockType);
    }
});

?>
<p>Done!</p>

<a href="<?php echo $nav->getLinkToCollection(Page::getByID(HOME_CID)); ?>">Home</a> |
<a href="<?php echo $nav->getLinkToCollection(Page::getByPath('/dashboard')); ?>">Dashboard</a>
