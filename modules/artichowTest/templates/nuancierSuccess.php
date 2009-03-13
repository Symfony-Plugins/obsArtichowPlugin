<?php

// @param integer $cols
// @param array $colors

$num = count($colors);
$rows = ceil($num / $cols);

$width  = $cols * 55 + 5;
$height = $rows * 55 + 5;

$image = new awGraph($width,$height);
$image->border->hide();

$image->setDriver('gd');
$driver = $image->getDriver();

// Fond blanc
//$driver->filledRectangle(new White, new awLine(new awPoint(0,0),new awPoint($width,$height)));

$offset = new awPoint(5,5);
$i = 0;
foreach($colors as $colorname)
{
  if(!class_exists($colorname)) continue;

  $color = new $colorname();
  $driver->filledRectangle($color, new awLine(
    $offset,
    $offset->move(50, 50)
  ));
  $offset = $offset->move(55,0);

  if(++$i % $cols == 0)
  {
    $offset->setX(5);
    $offset = $offset->move(0,55);
  }
}

// Affichage de l'image
$image->draw();

