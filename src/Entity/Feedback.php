<?php

namespace Drupal\feedback\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Feedback entity.
 *
 * @ingroup feedback
 *
 * @ContentEntityType(
 *   id = "feedback",
 *   label = @Translation("Feedback"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\feedback\FeedbackListBuilder",
 *     "views_data" = "Drupal\feedback\Entity\FeedbackViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\feedback\Form\FeedbackForm",
 *       "add" = "Drupal\feedback\Form\FeedbackForm",
 *       "edit" = "Drupal\feedback\Form\FeedbackForm",
 *       "delete" = "Drupal\feedback\Form\FeedbackDeleteForm",
 *     },
 *     "access" = "Drupal\feedback\FeedbackAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\feedback\FeedbackHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "feedback",
 *   admin_permission = "administer feedback entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "title",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/feedback/feedback/{feedback}",
 *     "add-form" = "/admin/feedback/feedback/add",
 *     "edit-form" = "/admin/feedback/feedback/{feedback}/edit",
 *     "delete-form" = "/admin/feedback/feedback/{feedback}/delete",
 *     "collection" = "/admin/feedback/feedback",
 *   },
 *   field_ui_base_route = "feedback.settings"
 * )
 */
class Feedback extends ContentEntityBase implements FeedbackInterface
{
    use EntityChangedTrait;

    /**
     * {@inheritdoc}
     */
    public static function preCreate(EntityStorageInterface $storage_controller, array &$values)
    {
        parent::preCreate($storage_controller, $values);
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->get('title')->value;
    }

    /**
     * {@inheritdoc}
     */
    public function setTitle($title)
    {
        $this->set('title', $title);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedTime()
    {
        return $this->get('created')->value;
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedTime($timestamp)
    {
        $this->set('created', $timestamp);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOwner()
    {
        return $this->get('user_id')->entity;
    }

    /**
     * {@inheritdoc}
     */
    public function getOwnerId()
    {
        return $this->get('user_id')->target_id;
    }

    /**
     * {@inheritdoc}
     */
    public function setOwnerId($uid)
    {
        $this->set('user_id', $uid);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setOwner(UserInterface $account)
    {
        $this->set('user_id', $account->id());
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isHandled()
    {
        return (bool)$this->getEntityKey('status');
    }

    /**
     * {@inheritdoc}
     */
    public function setHandled($handled)
    {
        $this->set('status', $handled ? TRUE : FALSE);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public static function baseFieldDefinitions(EntityTypeInterface $entity_type)
    {
        $fields = parent::baseFieldDefinitions($entity_type);

        $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
            ->setLabel(t('反馈用户'))
            ->setSetting('target_type', 'user')
            ->setSetting('handler', 'default')
            ->setDisplayOptions('view', [
                'label' => 'inline',
                'type' => 'author'
            ])
            ->setDisplayOptions('form', [
                'type' => 'entity_reference_autocomplete',
                'settings' => [
                    'match_operator' => 'CONTAINS',
                    'size' => '60',
                    'autocomplete_type' => 'tags',
                    'placeholder' => '',
                ],
            ]);

        $fields['title'] = BaseFieldDefinition::create('string')
            ->setLabel(t('标题'))
            ->setDefaultValue('')
            ->setDisplayOptions('view', [
                'label' => 'inline',
                'type' => 'string'
            ])
            ->setDisplayOptions('form', [
                'type' => 'string_textfield'
            ]);

        $fields['content'] = BaseFieldDefinition::create('string_long')
            ->setLabel(t('内容'))
            ->setSettings([
                'max_length' => 500,
                'text_processing' => 0,
            ])
            ->setDefaultValue('')
            ->setDisplayOptions('view', [
                'label' => 'above',
                'type' => 'string'
            ])
            ->setDisplayOptions('form', [
                'type' => 'string_textarea'
            ]);

        $fields['images'] = BaseFieldDefinition::create('image')
            ->setLabel(t('图片'))
            ->setCardinality(BaseFieldDefinition::CARDINALITY_UNLIMITED)
            ->setSettings([
                'file_directory' => 'feedback/feedback/images/[date:custom:Y]-[date:custom:m]',
                'file_extensions' => 'png gif jpg jpeg',
                'max_filesize' => '5 MB',
                'max_resolution' => '',
                'min_resolution' => '',
                'alt_field' => false,
                'alt_field_required' => true,
                'title_field' => false,
                'title_field_required' => false,
                'handler' => 'default:file',
                'handler_settings' => []
            ])
            ->setDisplayOptions('view', [
                'label' => 'above',
                'type' => 'image'
            ])
            ->setDisplayOptions('form', [
                'type' => 'image_image'
            ]);

        $fields['status'] = BaseFieldDefinition::create('boolean')
            ->setLabel(t('已处理'))
            ->setDefaultValue(false)
            ->setDisplayOptions('form', [
                'type' => 'boolean_checkbox',
            ]);

        $fields['created'] = BaseFieldDefinition::create('created')
            ->setLabel(t('Created'));

        $fields['changed'] = BaseFieldDefinition::create('changed')
            ->setLabel(t('Changed'));

        return $fields;
    }

}
