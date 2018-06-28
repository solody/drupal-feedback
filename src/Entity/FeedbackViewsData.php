<?php

namespace Drupal\feedback\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Feedback entities.
 */
class FeedbackViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.

    return $data;
  }

}
