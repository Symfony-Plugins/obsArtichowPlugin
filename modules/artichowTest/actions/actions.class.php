<?php

/**
 * test actions.
 *
 * @package    pgp
 * @subpackage test
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class artichowTestActions extends sfActions
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
    $this->forward('artichowTest','nuancier');
  }

  public function executeNuancier()
  {
    $this->colors = sfConfig::get('artichow_colors', array());
    $this->cols = $this->getRequestParameter('cols', 8);
  }

}
