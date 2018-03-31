<?php
namespace Application\Theme\Gpa;

use Concrete\Core\Area\Layout\Preset\Provider\ThemeProviderInterface;
use Concrete\Core\Page\Theme\Theme;

class PageTheme extends Theme implements ThemeProviderInterface
{
    public function registerAssets()
    {
        //$this->providesAsset('javascript', 'bootstrap/*');
        $this->providesAsset('css', 'bootstrap/*');

        $this->requireAsset('css', 'font-awesome');
        $this->requireAsset('javascript', 'jquery');
        $this->requireAsset('javascript-conditional', 'html5-shiv');
        $this->requireAsset('javascript-conditional', 'respond');
    }

    protected $pThemeGridFrameworkHandle = 'bootstrap4';

    public function getThemeName()
    {
        return t('GPA MN');
    }

    public function getThemeDescription()
    {
        return t('Theme designed for Greyhound Pets of America, Minnesota');
    }

    /**
     * @return array
     */
    public function getThemeBlockClasses()
    {
        return [];
    }

    /**
     * @return array
     */
    public function getThemeAreaClasses()
    {
        return [];
    }

    /**
     * @return array
     */
    public function getThemeDefaultBlockTemplates()
    {
        return [];
    }

    /**
     * @return array
     */
    public function getThemeResponsiveImageMap()
    {
        return [
            'large' => '1200px',
            'medium' => '992px',
            'small' => '768px',
            'extra_small' => '0',
        ];
    }

    /**
     * @return array
     */
    public function getThemeEditorClasses()
    {
        return [];
    }

    /**
     * @return array
     */
    public function getThemeAreaLayoutPresets()
    {
        $presets = [];

        return $presets;
    }
}
