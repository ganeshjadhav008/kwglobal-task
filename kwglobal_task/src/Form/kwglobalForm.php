<?php  
/**  
 * @file  
 * Contains Drupal\kwglobal_task\Form\kwglobalForm 
 */  

namespace Drupal\kwglobal_task\Form;  
use Drupal\Core\Form\FormBase;  
use Drupal\Core\Form\FormStateInterface;  

class kwglobalForm extends FormBase {  

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
      '#placeholder' => $this->t('Enter First Name')
    ];

    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#button_type' => 'primary',
    );

    return $form;
  }  

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {

    if(!preg_match("/^([a-zA-Z']+)$/", $form_state->getValue('kwglobal_name'))) {
      $form_state->setErrorByName("kwglobal_name", t('Entered name is not valid. Please enter valid name'));
    }

  }

  /**  
   * {@inheritdoc}  
   */  
  public function submitForm(array &$form, FormStateInterface $form_state) {  

    $kwglobal_name =  !empty($form_state->getValue('kwglobal_name')) ? $form_state->getValue('kwglobal_name') : NULL;
    //set message here
    drupal_set_message(t('Hi %name',['%name' => $kwglobal_name]), 'status', TRUE);
    
    // Logs a notice
    \Drupal::logger('kwglobal_task')->notice(t('Submitted Name: %name', ['%name' => $kwglobal_name]));

  }
}