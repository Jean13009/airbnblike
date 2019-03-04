<?php
namespace App\Service;

use Twig\Environment;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\RequestStack;

class PaginationService {
    private $entityClass;
    private $limit = 10;
    private $currentPage = 1;
    private $manager;
    private $twig;
    private $route;

    public function __construct(ObjectManager $manager, Environment $twig, RequestStack $request, $templatePath) {
        $this->route            = $request->getCurrentRequest()->attributes->get('_route');
        $this->manager       = $manager;
        $this->twig              = $twig;
        $this->templatePath = $templatePath;
    }

    public function setRoute($route) {
        $this->route = $route;
        return $this;
    }
    public function getRoute() {
        return $this->route;
    }

    public function display() {
        $this->twig->display($this->templatePath, [
            'page'   => $this->currentPage,
            'pages'  => $this->getPages(),
            'route'   => $this->getRoute()
        ]);
    }

    public function getPages() {
        if(empty($this->entityClass)) {
            throw new \Exception("Vous n'avez pas spécidifé l'entité sur laquelle paginer");
        }
        $repo = $this->manager->getRepository($this->entityClass);

        $total = count($repo->findAll());

        $pages = ceil($total / $this->limit);

        return $pages;

    }

    public function getData() {
        if(empty($this->entityClass)) {
            throw new \Exception("Vous n'avez pas spécidifé l'entité sur laquelle paginer");
        }
        $offset = $this->currentPage * $this->limit - $this->limit;

        $repo = $this->manager->getRepository($this->entityClass);

        $data = $repo->findBy([], [], $this->limit, $offset);

        return $data;
    }

    public function setEntityClass($entityClass) {
        $this->entityClass = $entityClass;

        return $this;
    }

    public function getEntityClass() {
        return $this->entityClass;
    }

    public function setLimit($limit) {
        $this->limit = $limit;

        return $this;
    }

    public function getLimit() {
        return $this->limit;
    }

    public function setPage($page) {
        $this->currentPage = $page;

        return $this;
    }

    public function getPage() {
        return $this->currentPage;
    }
}