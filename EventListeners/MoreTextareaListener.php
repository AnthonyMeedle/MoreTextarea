<?php

namespace MoreTextarea\EventListeners;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Action\BaseAction;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Core\Event\Product\ProductUpdateEvent;
use Thelia\Core\Event\Content\ContentUpdateEvent;
use Thelia\Core\Event\Category\CategoryUpdateEvent;
use Thelia\Core\Event\Folder\FolderUpdateEvent;
use Thelia\Core\Event\Brand\BrandUpdateEvent;
use MoreTextarea\Model\MoretextareaQuery;
use MoreTextarea\Model\Moretextarea;
use MoreTextarea\Model\CategoryMoretextareaQuery;
use MoreTextarea\Model\CategoryMoretextarea;
use MoreTextarea\Model\ProductMoretextareaQuery;
use MoreTextarea\Model\ProductMoretextarea;
use MoreTextarea\Model\FolderMoretextareaQuery;
use MoreTextarea\Model\FolderMoretextarea;
use MoreTextarea\Model\ContentMoretextareaQuery;
use MoreTextarea\Model\ContentMoretextarea;
use MoreTextarea\Model\BrandMoretextareaQuery;
use MoreTextarea\Model\BrandMoretextarea;

class MoreTextareaListener extends BaseAction implements EventSubscriberInterface
{
	
    public function product(ProductUpdateEvent $event)
    {
        if(isset($_REQUEST['moretextarea']))
		foreach($_REQUEST['moretextarea'] as $idmore => $val){
			if(null === $more = ProductMoretextareaQuery::create()->filterByLocale($event->getLocale())->filterByProductId($event->getProductId())->filterByMoretextareaId($idmore)->findOne()){
				$more = new ProductMoretextarea();
				$more->setProductId($event->getProductId())->setMoretextareaId($idmore)->setLocale($event->getLocale());
			}
			$more->setValue($val)->save();
		}
    }

    public function category(CategoryUpdateEvent $event)
    {
        if(isset($_REQUEST['moretextarea']))
		foreach($_REQUEST['moretextarea'] as $idmore => $val){
			if(null === $more = CategoryMoretextareaQuery::create()->filterByLocale($event->getLocale())->filterByCategoryId($event->getCategoryId())->filterByMoretextareaId($idmore)->findOne()){
				$more = new CategoryMoretextarea();
				$more->setCategoryId($event->getCategoryId())->setMoretextareaId($idmore)->setLocale($event->getLocale());
			}
			$more->setValue($val)->save();
		}
    }
    public function content(ContentUpdateEvent $event)
    {
        if(isset($_REQUEST['moretextarea']))
		foreach($_REQUEST['moretextarea'] as $idmore => $val){
			if(null === $more = ContentMoretextareaQuery::create()->filterByLocale($event->getLocale())->filterByContentId($event->getContentId())->filterByMoretextareaId($idmore)->findOne()){
				$more = new ContentMoretextarea();
				$more->setContentId($event->getContentId())->setMoretextareaId($idmore)->setLocale($event->getLocale());
			}
			$more->setValue($val)->save();
		}
    }

    public function folder(FolderUpdateEvent $event)
    {
        if(isset($_REQUEST['moretextarea']))
		foreach($_REQUEST['moretextarea'] as $idmore => $val){
			if(null === $more = FolderMoretextareaQuery::create()->filterByLocale($event->getLocale())->filterByFolderId($event->getFolderId())->filterByMoretextareaId($idmore)->findOne()){
				$more = new FolderMoretextarea();
				$more->setFolderId($event->getFolderId())->setMoretextareaId($idmore)->setLocale($event->getLocale());
			}
			$more->setValue($val)->save();
		}
    }
    public function brand(BrandUpdateEvent $event)
    {
        if(isset($_REQUEST['moretextarea']))
		foreach($_REQUEST['moretextarea'] as $idmore => $val){
			if(null === $more = BrandMoretextareaQuery::create()->filterByLocale($event->getLocale())->filterByBrandId($event->getBrandId())->filterByMoretextareaId($idmore)->findOne()){
				$more = new BrandMoretextarea();
				$more->setBrandId($event->getBrandId())->setMoretextareaId($idmore)->setLocale($event->getLocale());
			}
			$more->setValue($val)->save();
		}
    }

    public static function getSubscribedEvents()
    {
        return array(
            TheliaEvents::PRODUCT_UPDATE => array('product', 128),
            TheliaEvents::CATEGORY_UPDATE => array('category', 128),
            TheliaEvents::FOLDER_UPDATE => array('folder', 128),
            TheliaEvents::CONTENT_UPDATE => array('content', 128),
            TheliaEvents::BRAND_UPDATE => array('brand', 128)
        );
    }
}