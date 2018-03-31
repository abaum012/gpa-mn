<?php
namespace Application\Controller\SinglePage\Dashboard\System\Basics;

use Concrete\Core\Cache\Page\PageCache;
use Concrete\Core\Page\Controller\DashboardSitePageController;
use Core;

class Keys extends DashboardSitePageController
{
    public function view()
    {
        $config = $this->getSite()->getConfigRepository();
        $this->set('rescue_groups_api_key', $config->get('keys.rescue_groups_api_key'));
        $this->set('rescue_groups_id', $config->get('keys.rescue_groups_id'));
        $this->set('form', Core::make('helper/form'));

        if ($this->isPost()) {
            if ($this->token->validate('update_keys')) {
                $config->save('keys.rescue_groups_api_key', $this->post('rescue_groups_api_key'));
                $config->save('keys.rescue_groups_id', $this->post('rescue_groups_id'));

                $pageCache = PageCache::getLibrary();
                if (is_object($pageCache)) {
                    $pageCache->flush();
                }
                $this->redirect('/dashboard/system/basics/keys', 'saved');
            } else {
                $this->error->add($this->token->getErrorMessage());
            }
        }
    }

    public function saved()
    {
        $this->set('message', implode(PHP_EOL, array(
            t('Keys and ID settings updated successfully.'),
            t('Cached files removed.')
        )));
        $this->view();
    }
}
