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
    $data['feedback']['user_id']['filter']['id'] = 'entity_reference';
    return $data;
  }

}
