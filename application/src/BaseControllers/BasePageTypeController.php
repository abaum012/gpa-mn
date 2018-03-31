<?php namespace Application\BaseControllers;

use Concrete\Core\Page\Controller\PageTypeController;

class BasePageTypeController extends PageTypeController
{
    public function view()
    {
        $this->set('ptImage', $this->getPageTitleImage());
    }

    public function getPageTitleImage()
    {
        $ptImage = $this->c->getAttribute('page_title_image');
        return ($ptImage) ? $ptImage->getURL() : null;
    }

    public function return404()
    {
        return \RedirectResponse::create('/page_not_found');
    }

    public function currentUserCanEditPage()
    {
        $cp = new \Permissions($this->c);
        return $cp->canEditPageContents();
    }
}