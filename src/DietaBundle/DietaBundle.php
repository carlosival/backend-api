<?php

namespace DietaBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class DietaBundle extends Bundle
{

    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
