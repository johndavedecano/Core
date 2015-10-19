<?php
/**
 * Created by PhpStorm.
 * User: jdecano
 * Date: 10/16/15
 * Time: 2:35 PM
 */

namespace Jdecano\Core\Services;

use \Event;

trait DispatchesEvent {
    public function dispatch($event, $payload) {
        return Event::fire($event, array($payload));
    }
}