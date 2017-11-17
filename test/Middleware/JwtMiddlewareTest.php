<?php
/**
 * Created by PhpStorm.
 * User: Marcos
 * Date: 16/10/2017
 * Time: 22:12
 */

namespace Middleware;

use AuthExpressive\Middleware\JwtMiddleware;
use AuthExpressive\Response\SuccessResponse;
use AuthExpressive\Response\Unauthorized;
use Interop\Http\ServerMiddleware\DelegateInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Token\TokenTest;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Uri;

class JwtMiddlewareTest extends TestCase
{
    public function testImplementation()
    {
        self::assertTrue(self::getMiddleware() instanceof JwtMiddleware);
    }

    /**
     * Tests depend if jwt is not expired, you can see valid jwt on test console
     */
    public function testSuccess()
    {
        $middleware = self::getMiddleware();
        $jwt = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOiIxNTA4MjA3NjgwLjIwODAxMyIsInV1aWQiOiI3OHlocXdlODlodXdlbiJ9.FMHgm5Y_qs5leR33p-qzUwPfqZ4WJAePYLUiF9I3BCU';
        $request = new ServerRequest();
        $request = $request->withHeader('Authorization', 'Bearer '.$jwt);
        $response = $middleware->process($request, self::getDelegate());
        self::assertTrue($response instanceof SuccessResponse);
    }

    public function testUnauthorized()
    {
        $middleware = self::getMiddleware();
        $jwt = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ2LjIwODAxMyIsInV1aWQiOiI3OHlocXdlODlodXdlbiJ9.FMHgm5Y_qs5leR33p-qzUwPfqZ4WJAePYLUiF9I3BCU';
        $request = new ServerRequest();
        $request = $request->withHeader('Authorization', 'Bearer '.$jwt);
        $response = $middleware->process($request, self::getDelegate());
        self::assertTrue($response instanceof Unauthorized);
    }

    /**
     * Tests depend if jwt is not expired, you can see valid jwt on test console
     */
    public function testOnlyHttps()
    {
        $middleware = self::getMiddleware(true);
        $jwt = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOiIxNTA4MjA3NjgwLjIwODAxMyIsInV1aWQiOiI3OHlocXdlODlodXdlbiJ9.FMHgm5Y_qs5leR33p-qzUwPfqZ4WJAePYLUiF9I3BCU';
        $request = new ServerRequest();
        $request = $request->withUri(new Uri('https:\\teste.com'));
        $request = $request->withHeader('Authorization', 'Bearer '.$jwt);
        $response = $middleware->process($request, self::getDelegate());
        self::assertTrue($response instanceof SuccessResponse);
    }
    
    public static function getMiddleware($onlyHttps = false)
    {
        $token = TokenTest::getToken();
        $middlewareConfig = [
            'secure' => $onlyHttps,
            'expireIn' => 3600,
            'attributeToRequest' => 'auth',
            'attributeToMe' => 'me',
            'passRoutes' => []
        ];
        return new JwtMiddleware($token, 'uuid',$middlewareConfig);
    }

    public static function getDelegate()
    {
        return new class implements DelegateInterface {
            public function process(ServerRequestInterface $request)
            {
                return new SuccessResponse(['users' => []]);
            }

        };
    }
}
