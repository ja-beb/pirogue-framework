<?php

/**
 * Simple string tuple for testing the pirogue framework.
 * php version 8.0.0
 *
 * @author Bourg, Sean <sean.bourg@gmail.com>
 * @license https://opensource.org/licenses/GPL-3.0 GPL-v3
 */

namespace Pirogue\Test;

class Tuple
{
    public function __construct(
        public string $label,
        public string $value
    ) {
    }

    public function __toString(): string
    {
        return sprintf('(%s=%s)', $label, $value);
    }
}
