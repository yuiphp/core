<?php

use Yui\Application;

/**
 * Testar se a instância da classe Application é criada corretamente usando o método configure.
 * Testar se a instância da classe Application é recuperada corretamente usando o método getInstance.
 * Testar se uma exceção é lançada quando o método getInstance é chamado antes da configuração da classe Application.
 * Testar se o método build inicializa corretamente os inicializadores de bootstrap.
 * Testar se o método boot inicializa corretamente os inicializadores de bootstrap.
 * Testar se a propriedade container da classe Application é inicializada corretamente.
 */

it('should be able to create a new instance of the application', function () {
    $app = Application::configure(__DIR__);

    expect($app)->toBeInstanceOf(Application::class);
});

it('should be able to get the instance of the application', function () {
    $app = Application::configure(__DIR__);

    expect(Application::getInstance())->toBe($app);

    Application::$app = null;
});

it('should throw an exception when trying to get the instance of the application without initializing it', function () {
    Application::getInstance();
})->throws(RuntimeException::class, 'Application not initialized');