<?php


namespace Cms\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use \Cms\Entity\Page as PageEntity;
use Cms\Form\Page as PageForm;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class PageController extends AbstractActionController
{
    public function indexAction()
    {
        $pageModel = $this->getServiceLocator()
            ->get('model.page');
        $pages = $pageModel->findAll();

        return array(
            'pages' => $pages
        );
    }

    public function editAction()
    {
        $id = $this->params('id');
        if (empty($id) && $this->getRequest()->isPost()) {
            $id = $this->params()->fromPost('id');
        }

        $pageModel = $this->getServiceLocator()
            ->get('model.page');
        $page = $pageModel->find($id);

        if (empty($page)) {
            $page = new PageEntity;
        }

        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        // Build form
        $form = new PageForm;

        $form->setHydrator(new DoctrineHydrator($em, 'Cms\Entity\Page'));
        $form->bind($page);

        // Handle form submission
        if ($this->getRequest()->isPost()) {

            // Handle deletes
            $buttons = $this->params()->fromPost('buttons');
            if (!empty($buttons['delete'])) {
                // Delete it
                $pageModel->delete($page);

                // Message
                $this->flashMessenger()->addSuccessMessage('Page deleted.');

                // Redirect
                $this->redirect()->toRoute('pages');

                return true;
            }

            // Hand the POST data to the form for validation
            $form->setData($this->params()->fromPost());

            if ($form->isValid()) {
                $pageModel->save($page);
                $this->getServiceLocator()
                    ->get('doctrine.entitymanager.orm_default')
                    ->flush();

                // Update the routeCache
                // @todo: Only do this when the route or status changes
                $routeCacheService = $this->getServiceLocator()
                    ->get('service.routeCache');
                $routeCacheService->rebuild();

                $this->flashMessenger()->addSuccessMessage('Page saved.');
                $this->redirect()->toRoute('pages');
            }

        }

        return array(
            'form' => $form
        );
    }

    /**
     * Look a page up by its route and display it
     */
    public function viewAction()
    {
        $pageRoute = $this->params('pageRoute');

        $pageModel = $this->getServiceLocator()
            ->get('model.page');
        $page = $pageModel->findOneByRoute($pageRoute);

        return array(
            'page' => $page
        );
    }
}
