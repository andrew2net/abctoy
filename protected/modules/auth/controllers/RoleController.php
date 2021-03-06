<?php

/**
 * RoleController class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2012-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package auth.controllers
 */

/**
 * Controller for role related actions.
 */
class RoleController extends AuthItemController {

  /**
   * @var integer the item type (0=operation, 1=task, 2=role).
   */
  public $type = CAuthItem::TYPE_ROLE;

  public function filters() {
    return array(
      array('auth.filters.AuthFilter'), // perform access control for CRUD operations
      'postOnly + delete', // we only allow deletion via POST request
    );
  }

}
