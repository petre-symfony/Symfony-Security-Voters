<?php
namespace AppBundle\Security;

use Symfony\Component\Security\Core\Authorization\Voter\AbstractVoter;

class CookieVoter extends AbstractVoter {
  protected function getSupportedAttributes() {
    return array('NOM');
  }

  protected function getSupportedClasses() {
    return array('AppBundle\Entity\DeliciousCookie');  
  }

  protected function isGranted($attribute, $object, $user = null) {
    if(!is_object($user)){
      return false;
    } 
    
    if($object->getBakerUsername() == $user->getUsername()){
      return true;
    }
    
    return false;
  }

}
