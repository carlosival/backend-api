<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),

            new JMS\SerializerBundle\JMSSerializerBundle(),
            new FOS\CommentBundle\FOSCommentBundle(),
            new FOS\RestBundle\FOSRestBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new Bazinga\Bundle\HateoasBundle\BazingaHateoasBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Vich\UploaderBundle\VichUploaderBundle(),
          //  new Lexik\Bundle\JWTAuthenticationBundle\LexikJWTAuthenticationBundle(),
            //new Nelmio\ApiDocBundle\NelmioApiDocBundle(),
           // new FOS\HttpCacheBundle\FOSHttpCacheBundle(),
           // new Bazinga\Bundle\HateoasBundle\BazingaHateoasBundle(),
           // new Hautelook\TemplatedUriBundle\HautelookTemplatedUriBundle(),
           // new Bazinga\Bundle\RestExtraBundle\BazingaRestExtraBundle(),



            new DietaBundle\DietaBundle(),
            new FrontDietaBundle\FrontDietaBundle(),
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();

            $bundles[] = new Nelmio\Alice\Bridge\Symfony\NelmioAliceBundle();
            $bundles[] = new Fidry\AliceDataFixtures\Bridge\Symfony\FidryAliceDataFixturesBundle();
            $bundles[] = new Hautelook\AliceBundle\HautelookAliceBundle();

        }

        return $bundles;
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return dirname(__DIR__).'/var/cache/'.$this->getEnvironment();
    }

    public function getLogDir()
    {
        return dirname(__DIR__).'/var/logs';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
