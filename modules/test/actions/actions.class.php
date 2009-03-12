<?php

/**
 * test actions.
 *
 * @package    pgp
 * @subpackage test
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class testActions extends sfActions
{
  public function preExecute()
  {
  	include_once(sfConfigCache::getInstance()->checkConfig('config/artichow.yml'));
  }
  
  /**
   * Executes index action
   *
   */
  public function executeIndex()
  {
    $this->forward('test/nuancier');
  }

  public function executeNuancier()
  { 
    $this->colors = sfConfig::get('colors');
    $this->cols = $this->getRequestParameter('cols',7);

    $this->setLayout(false);
  }
  
  public function executeMacaron()
  {
  	$this->contracts = 512;
  	$this->companies = 62;
  	
  	$this->setLayout(false);
  }
}
