<?php

namespace Drupal\feedback;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Feedback entities.
 *
 * @ingroup feedback
 */
class FeedbackListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Feedback ID');
    $header['title'] = $this->t('Title');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /** @var \Drupal\feedback\Entity\Feedback $entity */
    $row['id'] = $entity->id();
    $row['title'] = Link::createFromRoute(
      $entity->label() ?? $entity->id(),
      'entity.feedback.canonical',
      ['feedback' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
