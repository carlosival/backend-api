<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 18/03/17
 * Time: 14:56
 */

namespace DietaBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Hautelook\AliceBundle\Alice;
use Nelmio\Alice\Fixtures;
use Nelmio\Alice\Loader\NativeLoader;


class DietaFixtures implements FixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // TODO: Implement load() method.

        /*$objects = Fixtures::load(
            __DIR__.'/fixtures.yml',
            $manager,
            [
                'providers' => [$this]
            ]


        );*/

    }


    public function ingredientes(){

        return ['Ingrediente kg','Ingrediente 2 soup','Ingrediente 3','Ingrediente 4','Ingrediente 5'];
    }
    public  function preparacion(){

        return ['Operacion 1','Operacion 2','Operacion 3','Operacion 4','Operacion 5'];;
    }

    public function genus()
    {
        $genera = [
            'Octopus',
            'Balaena',
            'Orcinus',
            'Hippocampus',
            'Asterias',
            'Amphiprion',
            'Carcharodon',
            'Aurelia',
            'Cucumaria',
            'Balistoides',
            'Paralithodes',
            'Chelonia',
            'Trichechus',
            'Eumetopias'
        ];
        $key = array_rand($genera);
        return $genera[$key];
    }


}