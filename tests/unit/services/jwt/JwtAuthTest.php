<?php
declare(strict_types=1);
namespace tests\unit\services\jwt;

use PHPUnit\Framework\TestCase;
use services\jwt\JwtAuth;

class JwtAuthTest extends TestCase
{
    private $jwtAuth;

    protected function setUp(): void
    {
        $this->jwtAuth = new JwtAuth('sk-WBXV1CZiDi1EQvg8o9xeT3Bl');
    }

    public function testCreateJwt()
    {
        $jwt = $this->jwtAuth->createJwt(1);
      
        $this->assertIsString($jwt);
        $this->assertMatchesRegularExpression('/^[A-Za-z0-9-_]+\.[A-Za-z0-9-_]+\.[A-Za-z0-9-_.]+$/u', $jwt,'El jwt no se creo en el formato correcto');

    }
}
