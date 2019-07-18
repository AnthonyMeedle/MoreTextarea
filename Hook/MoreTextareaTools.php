<?php
namespace MoreTextarea\Hook;

use Thelia\Core\Event\Hook\HookRenderBlockEvent;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Tools\URL;

class MoreTextareaTools extends BaseHook {
    public function onMainTopMenuToolsContents(HookRenderBlockEvent $event)
    {
		$event->add(array(
			"id" => "moreTextareaTools",
			"class" => '',
			"url" => URL::getInstance()->absoluteUrl('/admin/modules/moretextarea/moretextarea-accueil'),
			"title" => $this->trans("More textarea")
		));		
    }
	
    public function onProductModificationFormBottom(HookRenderEvent $event){
		$html = $this->render("moreTextareaProduct.html", array("object_id" => $event->getArgument('id', null), "object_type" => $event->getArgument('type', null)));
		$event->add($html);	
    }
    public function onCategoryModificationFormRightBottom(HookRenderEvent $event){
		$html = $this->render("moreTextareaCategory.html", array("object_id" => $event->getArgument('id', null), "object_type" => $event->getArgument('type', null)));
		$event->add($html);	
    }
    public function onFolderModificationFormRightBottom(HookRenderEvent $event){
		$html = $this->render("moreTextareaFolder.html", array("object_id" => $event->getArgument('id', null), "object_type" => $event->getArgument('type', null)));
		$event->add($html);	
    }
    public function onContentModificationFormRightBottom(HookRenderEvent $event){
		$html = $this->render("moreTextareaContent.html", array("object_id" => $event->getArgument('id', null), "object_type" => $event->getArgument('type', null)));
		$event->add($html);	
    }
}