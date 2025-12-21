<?php

declare(strict_types=1);

namespace Drupal\noahs_gallery;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining a noahs gallery entity type.
 */
interface NoahSGalleryInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
