<?php

declare(strict_types=1);

namespace ClickedTran\WarpGUI\libs\muqsit\invmenu\session\network\handler;

use Closure;
use ClickedTran\WarpGUI\libs\muqsit\invmenu\session\network\NetworkStackLatencyEntry;

interface PlayerNetworkHandler{

	public function createNetworkStackLatencyEntry(Closure $then) : NetworkStackLatencyEntry;
}