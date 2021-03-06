<?php

declare(strict_types=1);

namespace Nittro\Bridges\NittroDI;

use Nette\Bridges\ApplicationLatte\ILatteFactory;
use Nette\DI\CompilerExtension;
use Nette\DI\Definitions\Statement;
use Nittro\Bridges\NittroLatte\NittroMacros;
use Nittro\Bridges\NittroLatte\NittroRuntime;


class NittroExtension extends CompilerExtension {

    public $defaults = [
        'noconflict' => false,
    ];


    public function loadConfiguration() : void {
        $this->validateConfig($this->defaults);
    }


    public function beforeCompile() : void {
        $builder = $this->getContainerBuilder();
        $config = $this->getConfig();

        if ($latte = $builder->getByType(ILatteFactory::class)) {
            $builder->getDefinition($latte)
				->getResultDefinition()
                ->addSetup('addProvider', [ 'nittro', new Statement(NittroRuntime::class) ])
                ->addSetup(
                    '?->onCompile[] = function ($engine) { ' . NittroMacros::class . '::install($engine->getCompiler(), ?); }', [
                    '@self',
                    $config['noconflict'],
                ]);
        }
    }

}
