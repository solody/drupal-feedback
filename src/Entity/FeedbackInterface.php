<?php

namespace Drupal\feedback\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Feedback entities.
 *
 * @ingroup feedback
 */
interface FeedbackInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  /**
   * Gets the Feedback title.
   *
   * @return string
   *   Title of the Feedback.
   */
  public function getTitle(): string;

  /**
   * Sets the Feedback title.
   *
   * @param string $title
   *   The Feedback title.
   *
   * @return \Drupal\feedback\Entity\FeedbackInterface
   *   The called Feedback entity.
   */
  public function setTitle(string $title): FeedbackInterface;

  /**
   * Gets the Feedback creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Feedback.
   */
  public function getCreatedTime(): int;

  /**
   * Sets the Feedback creation timestamp.
   *
   * @param int $timestamp
   *   The Feedback creation timestamp.
   *
   * @return \Drupal\feedback\Entity\FeedbackInterface
   *   The called Feedback entity.
   */
  public function setCreatedTime(int $timestamp): FeedbackInterface;

  /**
   * Returns the Feedback handled status indicator.
   *
   * Unhandled Feedback are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Feedback is handled.
   */
  public function isResolved(): bool;

  /**
   * Sets the handled status of a Feedback.
   *
   * @param bool $handled
   *   TRUE to set this Feedback to handled, FALSE to set it to unhandled.
   *
   * @return \Drupal\feedback\Entity\FeedbackInterface
   *   The called Feedback entity.
   */
  public function setResolved(bool $handled): FeedbackInterface;

}
