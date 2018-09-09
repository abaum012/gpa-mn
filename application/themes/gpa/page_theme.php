<?php
namespace Application\Theme\Gpa;

use Concrete\Core\Area\Layout\Preset\Provider\ThemeProviderInterface;
use Concrete\Core\Page\Theme\Theme;

class PageTheme extends Theme implements ThemeProviderInterface
{
    public function registerAssets()
    {
        $this->providesAsset('javascript', 'bootstrap/*');
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
        return [
            [
                'title' => t('Small'),
                'element' => ['p'],
                'attributes' => ['class' => 'small']
            ],
            [
                'title' => t('Image Full'),
                'element' => ['img'],
                'attributes' => ['class' => 'img-fluid']
            ],
            [
                'title' => t('Image - Left'),
                'element' => ['img'],
                'attributes' => ['class' => 'img-left']
            ],
            [
                'title' => t('Image - Right'),
                'element' => ['img'],
                'attributes' => ['class' => 'img-right']
            ],
            [
                'title' => t('Button'),
                'element' => ['a', 'button'],
                'attributes' => ['class' => 'button button-border button-circle']
            ],
            [
                'title' => t('Button Full Width'),
                'element' => ['a', 'button'],
                'attributes' => ['class' => 'btn btn-primary btn-block']
            ],
            [
                'title' => t('Button Small'),
                'element' => ['a', 'button'],
                'attributes' => ['class' => 'btn btn-secondary btn-sm']
            ]
        ];
    }

    public function getThemeAreaLayoutPresets()
    {
        return [];
    }

}
