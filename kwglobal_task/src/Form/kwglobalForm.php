<?php

namespace Drupal\Kwglobal_task\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;

/**
 * Provides a form for log & view data.
 */
class KwglobalForm extends FormBase {

  /**
   * The logger factory.
   *
   * @var \Drupal\Core\Logger\LoggerChannelFactoryInterface
   */
  protected $loggerFactory;

  /**
   * Constructs a logger object.
   *
   * @param \Drupal\Core\Logger\LoggerChannelFactoryInterface $logger_factory
   *   The logger factory.
   */
  public function __construct(LoggerChannelFactoryInterface $logger_factory) {
    $this->loggerFactory = $logger_factory;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('logger.factory')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'mail_notification';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['kwglobal_name'] = [
      '#title' => $this->t('Enter Your First Name'),
      '#type' => 'textfield',
      '#placeholder' => $this->t('Enter First Name'),
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#button_type' => 'primary',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {

    if (!preg_match("/^([a-zA-Z']+)$/", $form_state->getValue('kwglobal_name'))) {
      $form_state->setErrorByName("kwglobal_name", $this->t('Entered name is not valid. Please enter valid name'));
    }

  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $kwglobal_name = !empty($form_state->getValue('kwglobal_name')) ? $form_state->getValue('kwglobal_name') : NULL;
    // Set drupal message here.
    drupal_set_message($this->t('Hi %name', ['%name' => $kwglobal_name]), 'status', TRUE);

    // Log details.
    $this->loggerFactory->get('kwglobal_task')->notice($this->t('Submitted Name: %name', ['%name' => $kwglobal_name]));

  }

}
