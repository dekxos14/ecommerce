<?php

namespace App\Middleware;

class DisplayInputErrorsMiddleware extends Middleware
{
    /**
     * O slim entender o método mágico __invoke como se fosse uma função.
     */
    public function __invoke($request, $response, $next)
    {
        if (isset($_SESSION['errors'])) # verifica se tem uma sessão com erros.

            $this->container->view->getEnvironment()->addGlobal('errors', $_SESSION['errors']);
            /*dizendo para o Slim cria uma variável dentro do template Twig chamada 'errors',
            e ela vai conter todos os erros dentro das validações.*/

        # uma vez exibido os erros para o usuário, não é mais necessário  a sessão.
        unset($_SESSION['errors']);

        $response = $next($request, $response);
        return $response;
    }
}