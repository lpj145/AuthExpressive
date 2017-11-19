<?php
namespace AuthExpressive;

use AuthExpressive\Controller\ListUsersController;
use AuthExpressive\Controller\LoginController;
use AuthExpressive\Controller\LogoutController;
use AuthExpressive\Controller\MeController;
use AuthExpressive\Controller\RegisterController;
use AuthExpressive\Controller\RememberTokenController;
use AuthExpressive\Controller\UpdateControllerMe;
use AuthExpressive\Controller\UpdateMeController;
use AuthExpressive\Factories\AuthenticationFactory;
use AuthExpressive\Factories\AuthProviderFactory;
use AuthExpressive\Factories\ListUsersControllerFactory;
use AuthExpressive\Factories\LoginControllerFactory;
use AuthExpressive\Factories\LogoutControllerFactory;
use AuthExpressive\Factories\MeControllerFactory;
use AuthExpressive\Factories\RegisterControllerFactory;
use AuthExpressive\Factories\RememberTokenControllerFactory;
use AuthExpressive\Factories\UpdateControllerMeFactory;
use AuthExpressive\Factories\UpdateMeControllerFactory;
use AuthExpressive\Factories\ValidatorFactory;
use AuthExpressive\Interfaces\AuthenticationInterface;
use AuthExpressive\Interfaces\AuthProviderInterface;
use AuthExpressive\Middleware\Factory\JwtMiddlewareFactory;
use AuthExpressive\Middleware\Factory\MeMiddlewareFactory;
use AuthExpressive\Middleware\JwtMiddleware;
use AuthExpressive\Middleware\MeMiddleware;
use AuthExpressive\Token\Factory\BuilderFactory;
use AuthExpressive\Token\Factory\EncoderFactory;
use AuthExpressive\Token\Factory\KeyFactory;
use AuthExpressive\Token\Factory\ParseFactory;
use AuthExpressive\Token\Factory\SignerFactory;
use AuthExpressive\Token\Factory\TokenFactory;
use AuthExpressive\Token\Factory\TokenValidatorFactory;
use Illuminate\Validation\Factory;
use AuthExpressive\Interfaces\TokenInterface;
use Lcobucci\Jose\Parsing\Parser as EncoderDecoder;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Validator;
use Lcobucci\JWT\Token\Parser;

class ConfigProvider
{
    public function __invoke()
    {
        return [
          'dependencies' => [
              'factories' => $this->getFactories(),

          ],
          AuthExpressive::class => [
              'secret' => null,
              'attributeToJwt' => 'uuid',
              'prefixStorage' => 'auth:',
              // See locale folder
              'locale' => 'pt-br',

              'middleware' => [
                  'secure' => true,
                  'expireIn' => 3600,
                  'attributeToRequest' => 'auth',
                  'attributeToMe' => 'me',
                  'passRoutes' => [], // Live routes of jwt
              ]
          ]
        ];
    }

    public function getFactories()
    {
        return [
            LoginController::class => LoginControllerFactory::class,
            UpdateMeController::class => UpdateMeControllerFactory::class,
            RegisterController::class => RegisterControllerFactory::class,
            RememberTokenController::class => RememberTokenControllerFactory::class,
            MeController::class => MeControllerFactory::class,
            
            //Middleware
            JwtMiddleware::class => JwtMiddlewareFactory::class,
            MeMiddleware::class => MeMiddlewareFactory::class,
            
            // by interfaces
            AuthenticationInterface::class => AuthenticationFactory::class,
            AuthProviderInterface::class => AuthProviderFactory::class,
            //Token encoder factories
            Key::class => KeyFactory::class,
            Sha256::class => SignerFactory::class,
            Builder::class => BuilderFactory::class,
            Validator::class => TokenValidatorFactory::class,
            TokenInterface::class => TokenFactory::class,
            Parser::class => ParseFactory::class,
            EncoderDecoder::class => EncoderFactory::class,
        ];
    }
}
