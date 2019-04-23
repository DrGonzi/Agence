<?php

namespace App\Listener;

use Doctrine\Common\EventSubscriber;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Mapping\PreUpdate;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;


class ImageCacheSubscriber implements EventSubscriber {

    /**
     * @var $cacheManager
     */
    private $cacheManager;

    /**
     * @var $uploadHelper
     */
    private $uploadHelper;

    public function __construct(CacheManager $cacheManager, UploaderHelper $uploadHelper)
    {
        $this->cacheManager = $cacheManager;
        $this->uploadHelper = $uploadHelper;
    }

    public function getSubscribedEvents()
    {
        return [
            'preRemove',
            'preUpdate'
        ];
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if(!$entity instanceof Property){
            return;
        }
        $this->cacheManager->remove($this->uploadHelper->asset($entity, 'imageFile'));
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();
        if(!$entity instanceof Property){
            return;
        }
        if($entity->getImageFile() instanceof UploadedFile){
            $this->cacheManager->remove($this->uploadHelper->asset($entity, 'imageFile'));
        }

    }

}