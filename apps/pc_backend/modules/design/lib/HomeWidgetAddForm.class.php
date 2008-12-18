<?php

/**
 * Home Widget Add Form.
 *
 * @package    OpenPNE
 * @subpackage form
 * @author     Kousuke Ebihara <ebihara@tejimaya.com>
 */
class HomeWidgetAddForm extends sfForm
{
  public function configure()
  {
    $this->setValidator('top', new sfValidatorCallback(array('callback' => array($this, 'validate'))));
    $this->setValidator('sideMenu', new sfValidatorCallback(array('callback' => array($this, 'validate'))));
    $this->setValidator('contents', new sfValidatorCallback(array('callback' => array($this, 'validate'))));
  }

  public function save()
  {
    foreach ($this->values as $type => $widgets)
    {
      if (!$widgets)
      {
        continue;
      }

      foreach ($widgets as $value)
      {
        $widget = new HomeWidget();
        $widget->setType($type);
        $widget->setName($value);
        $widget->save();
      }
    }
  }

  public function validate($validator, $value)
  {
    $result = array();

    foreach ($value as $key => $item)
    {
      if (array_key_exists($item, sfConfig::get('op_widget_list')))
      {
        $result[] = $item;
      }
    }

    return $result;
  }
}