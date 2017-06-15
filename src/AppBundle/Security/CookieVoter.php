<?php
namespace AppBundle\Security;

use Symfony\Component\Security\Core\Authorization\Voter\AbstractVoter;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CookieVoter extends AbstractVoter {
  const ATTRIBUTE_NOM = 'NOM';
  const ATTRIBUTE_DONATE = 'DONATE';
  
  /**
   * @var \Symfony\Component\DependencyInjection\ContainerInterface
   */
  private $container;
  
  public function __construct(ContainerInterface $container) {
    $this->container =$container;
  }

  protected function getSupportedAttributes() {
    return array(self::ATTRIBUTE_NOM, self::ATTRIBUTE_DONATE);
  }

  protected function getSupportedClasses() {
    return array('AppBundle\Entity\DeliciousCookie');  
  }

  protected function isGranted($attribute, $object, $user = null) {
    if(!is_object($user)){
      return false;
    } 
    
    //in Symfony 2.5 - $this->container->get('security.context')
    $authChecker = $this->container->get('security.authorization_checker');
    
    switch($attribute){
      case self::ATTRIBUTE_NOM:
        if ($authChecker->isGranted('ROLE_COOKIE_MONSTER')){
          return true;
        }

        if($object->getBakerUsername() == $user->getUsername()){
          return true;
        }

        return false;
      case self::ATTRIBUTE_DONATE:
        if(strpos($object->getFlavor(), 'Chocolate') === false){
          return true;
        }
        return false;
    }
    
    throw new \LogicException('How did we get here!?');
    
  }

}
