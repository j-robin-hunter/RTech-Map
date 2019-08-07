<?php
/**
 * Copyright © 2019 Roma Technology Limited. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace RTech\Map\Api\Data;

interface MapMarkerInterface {

  const CUSTOMER_GROUP_ID = 'customer_group_id';
  const MARKER_COLOR = 'marker_color';

  /**
  * Get map marker color
  *
  * @return string|null
  */
  public function getMarkerColor();

  /**
  * Set map marker color
  *
  * @param int $markerColor
  * @return $this
  */
  public function setMarkerColor($markerColor);
}