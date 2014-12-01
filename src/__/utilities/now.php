<?php

namespace utilities;

/**
 * @utilities @now
 *
 ** __::now();
 ** // → unix timestamp
 */

function now() {
  $now = time();
  return $now;
}