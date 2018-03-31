<?php namespace Application\Installer;

use Concrete\Core\Entity\Attribute\Key\PageKey;
use Concrete\Core\Entity\Attribute\Key\UserKey;
use Concrete\Core\Entity\Attribute\Key\Settings\SelectSettings;
use Concrete\Core\Entity\Attribute\Value\Value\SelectValueOption;
use Concrete\Core\Entity\Attribute\Value\Value\SelectValueOptionList;
use Concrete\Core\Page\Page;
use Concrete\Core\Page\Template;
use Concrete\Core\Page\Template as PageTemplate;
use Concrete\Core\Page\Type\Type as PageType;
use Concrete\Core\Page\Theme\Theme;
use Concrete\Core\File\Set\Set as FileSet;
use Concrete\Core\Entity\File\Image\Thumbnail\Type\Type as ThumbEntity;
use Concrete\Core\File\Image\Thumbnail\Type\Type as Thumb;
use Concrete\Core\Block\BlockType\BlockType;
use Concrete\Core\Support\Facade\Application;
use Concrete\Core\Support\Facade\DatabaseORM as ORM;
use Concrete\Core\Database\DatabaseStructureManager;
use Concrete\Core\Attribute\Type as AttributeType;
use Concrete\Core\Attribute\Key\Category  as AttributeKeyCategory;
use Concrete\Core\Attribute\Key\Key as AttributeKey;
use Concrete\Core\User\Group\Group as Group;

/**
 * Class Installer
 * @package Application\Installer
 */
class Installer
{
    /**
     * @var string
     */
    public $check = '<span style="color:green;">&#x2714;</span>';

    /**
     * @var string
     */
    public $times = '<span style="color:red;">&#x2718;</span>';

    /**
     * @var \Concrete\Core\Application\Application
     */
    protected $app;

    /**
     * Installer constructor.
     */
    public function __construct()
    {
        $this->app = Application::getFacadeApplication();
    }

    public function refreshEntities()
    {
        $em = ORM::entityManager();
        $manager = new DatabaseStructureManager($em);
        $manager->refreshEntities();
        return $this->response("{$this->check} Refreshed entities. Any database schema changes have been applied.");
    }

    /**
     * @param string $handle
     * @param string $name
     * @param string $icon
     * @return InstallerResponse
     */
    public function installPageTemplate($handle, $name, $icon)
    {
        $msg = "{$this->times} {$handle} page template already installed";
        $template = Template::getByHandle($handle);

        if(!is_object($template))
        {
            $template = Template::add($handle, $name, $icon);
            $msg = "{$this->check} Installed {$handle} page template";
        }

        return $this->response($msg, $template);
    }

    /**
     * @param string $handle
     * @param string $settings
     * @return InstallerResponse
     */
    public function installPageType($handle, $settings)
    {
        $msg = "{$this->times} {$handle} page type already installed";
        $pageType = PageType::getByHandle($handle);

        if(!is_object($pageType))
        {
            // see \Concrete\Core\Page\Type\Type for full docs.
            $pageType = PageType::add($settings);
            $msg = "{$this->check} Installed {$handle} page template";
        }
        return $this->response($msg, $pageType);
    }

    /**
     * @param string $path
     * @param string $name
     * @param array $attributes
     * @param bool $inherited - true if master will have a version of this single page
     * @return InstallerResponse
     */
    public function installSinglePage($path, $name, $attributes = array(), $inherited = false)
    {
        $sp = Page::getByPath($path);
        $msg = "{$this->times} {$path} single page already installed";

        if($sp->isError() && $sp->getError() == COLLECTION_NOT_FOUND)
        {
            $msg = "{$this->times} found single page at {$path}, Please install via the dashboard";
        }
        return $this->response($msg, $sp);
    }

    /**
     * @param string $handle
     * @return InstallerResponse
     */
    public function installTheme($handle)
    {
        $theme = Theme::getByHandle($handle);
        $msg = "{$this->times} {$handle} theme already installed";

        if(!is_object($theme))
        {
            $theme = Theme::add($handle);
            $msg = "{$this->check} Installed {$handle} theme";
        }

        return $this->response($msg, $theme);
    }

    /**
     * @param string $handle
     * @return InstallerResponse
     */
    public function installBlockType($handle)
    {
        $blockType = BlockType::getByHandle($handle);
        $msg = "{$this->times} {$handle} block type already installed";

        if(!is_object($blockType))
        {
            $blockType = BlockType::installBlockType($handle);
            $msg = "{$this->check} Installed {$handle} block type";
        }

        return $this->response($msg, $blockType);
    }

    /**
     * @param $handle
     * @return InstallerResponse
     */
    public function refreshBlockType($handle)
    {
        $bt = BlockType::getByHandle($handle);
        $bt->refresh();
        return $this->response("{$this->check} {$handle} block type Refreshed. Any database schema changes have been applied.");
    }

    /**
     * @param $handle
     * @param $name
     * @param $category_handle
     * @return InstallerResponse
     */
    public function installAttributeType($handle, $name, $category_handle)
    {
        $msg = "{$this->times} {$handle} attribute type already installed";
        $type = AttributeType::getByHandle($handle);

        if(is_null($type))
        {
            $type = AttributeType::add($handle, $name);
            $category = AttributeKeyCategory::getByHandle($category_handle);
            $category->associateAttributeKeyType($type);
            $msg = "{$this->check} Installed {$handle} attribute type";
        }
        return $this->response($msg, $type);

    }

    /**
     * @param $handle
     * @return InstallerResponse
     */
    public function installUserGroup($groupName)
    {
        $msg = "{$this->times} {$groupName} user group already installed";
        $group = Group::getByName($groupName);

        if(is_null($group))
        {
            $group = Group::add($groupName, '');
            $msg = "{$this->check} Installed {$groupName} group";
        }
        return $this->response($msg, $group);

    }

    /**
     * NOTE - right now this just does basic attributes like text. No support yet for dropdown, textarea, etc.
     *
     * @param string $handle
     * @param string $name
     * @param string $type
     * @return InstallerResponse
     */
    public function installUserAttribute($handle, $name, $type, $editable = false, $required = false)
    {
        $msg = "{$this->times} {$handle} user attribute already installed";
        $service = $this->app->make('Concrete\Core\Attribute\Category\CategoryService');
        $categoryEntity = $service->getByHandle('user');
        $category = $categoryEntity->getController();
        $key = $category->getByHandle($handle);

        if (!is_object($key)) {
            $key = new UserKey();
            $key->setAttributeKeyHandle($handle);
            $key->setAttributeKeyName($name);
            $key->setAttributeKeyEditableOnRegister($editable);
            $key->setAttributeKeyRequiredOnRegister($required);
            $key = $category->add($type, $key);
            $msg = "{$this->check} Installed {$handle} user attribute";
        }
        return $this->response($msg, $key);
    }

    /**
     * @param string $handle
     * @param string $name
     * @param string $type
     * @param array|null $selectOptions
     * @param bool $selectAllowMultiple
     * @return InstallerResponse
     */
    public function installPageAttribute($handle, $name, $type, $selectOptions = null, $selectAllowMultiple = false, $settings = [])
    {
        $msg = "{$this->times} {$handle} page attribute already installed";
        $service = $this->app->make('Concrete\Core\Attribute\Category\CategoryService');
        $categoryEntity = $service->getByHandle('collection');
        $category = $categoryEntity->getController();
        $key = $category->getByHandle($handle);

        if (!is_object($key)) {
            $key = new PageKey();
            $key->setAttributeKeyHandle($handle);
            $key->setAttributeKeyName($name);

            if($type == 'select')
            {
                $key = $category->add($type, $key, $this->selectSettings($selectOptions, $selectAllowMultiple));
            }
            else
            {
                $key = $category->add($type, $key);
            }

            if($type == 'textarea' && isset($settings['akTextareaDisplayMode']))
            {
                $s = $key->getAttributeKeySettings();
                $s->setMode($settings['akTextareaDisplayMode']);
            }

            $msg = "{$this->check} Installed {$handle} page attribute";
        }
        return $this->response($msg, $key);
    }

    /**
     * @param $name
     * @return InstallerResponse
     */
    public function installFileSet($name)
    {
        $set = FileSet::getByName($name);
        $msg = "{$this->times} {$name} file set already installed";
        if(!$set)
        {
            $set = FileSet::create($name);
            $msg = "{$this->check} Installed {$name} file set";
        }
        return $this->response($msg, $set);
    }

    /**
     * @param $handle
     * @param $name
     * @param $width
     * @param null $height - if null, this will be calculated automatically
     * @param bool $required - if true, this type cannot be deleted from the dashboard
     * @return InstallerResponse
     */
    public function installThumbnailType($handle, $name, $width, $height = null, $required = true)
    {
        $thumb = Thumb::getByHandle($handle);
        $msg = "{$this->times} {$handle} thumbnail already installed";

        if(!is_object($thumb))
        {
            $thumb = new ThumbEntity();
            $thumb->setHandle($handle);
            $thumb->setName($name);
            $thumb->setWidth($width);
            if(!is_null($height))
            {
                $thumb->setHeight($height);
            }
            if($required)
            {
                $thumb->requireType();
            }
            $thumb->save();
            $msg = "{$this->check} {$handle} thumbnail installed";
        }
        return $this->response($msg, $thumb);
    }

    public function installGroup($groupName, Callable $install)
    {
        echo '<fieldset style="margin-bottom:10px;">';
        echo "<legend><strong>{$groupName}</strong></legend>";
        $install($this);
        echo '</fieldset>';
    }

    /**
     * Get the settings for a Select attribute type. Got this function and the selectOptions function from a comment at:
     * https://documentation.concrete5.org/developers/attributes/working-with-attribute-keys/creating-attribute-keys-in-a-package
     *
     * @param array $optionarray
     * @param bool $allowMultiple
     * @param bool $allowOtherValues
     * @return SelectSettings
     */
    protected function selectSettings(array $optionarray, $allowMultiple = false, $allowOtherValues = false)
    {
        $select_settings = new SelectSettings();
        $list = new SelectValueOptionList();
        $list->setOptions($this->selectOptions($optionarray,$list));
        $select_settings->setOptionList($list);
        $select_settings->setAllowMultipleValues($allowMultiple);
        $select_settings->setAllowOtherValues($allowOtherValues);
        return $select_settings;
    }

    /**
     * Convert the array of options into SelectValueOption objects
     *
     * @param array $optionarray
     * @param SelectValueOptionList $list
     * @return array
     */
    protected function selectOptions(array $optionarray, SelectValueOptionList $list)
    {
        $options = array();
        $displayOrder = 0;
        foreach($optionarray AS $option)
        {
            $opt = new SelectValueOption();
            $opt->setSelectAttributeOptionValue($option);
            $opt->setDisplayOrder($displayOrder);
            $opt->setOptionList($list);
            if (is_object($opt))
            {
                $options[] = $opt;
                ++$displayOrder;
            }
        }
        return $options;
    }

    /**
     * @param string $msg
     * @param $obj
     * @return InstallerResponse
     */
    protected function response($msg, $obj = null)
    {
        return new InstallerResponse($msg, $obj);
    }
}
