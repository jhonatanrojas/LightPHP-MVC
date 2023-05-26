<?php
declare(strict_types=1);
namespace tests\unit\services\jwt;

use PHPUnit\Framework\TestCase;
use services\jwt\JwtDecoder;
use  exceptions\JwtException;
class JwtDecoderTest extends TestCase
{
    private $jwtDecoder;

    protected function setUp(): void
    {
        $this->jwtDecoder = new JwtDecoder('sk-WBXV1CZiDi1EQvg8o9xeT3Bl');
    }

    public function testDecodeJwt()
    {
        // Aquí necesitarías un JWT válido para probar. Podrías generar uno con JwtAuth::createJwt.
        $validJwt = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2ODUwNjMzMTEsImV4cCI6MTY4NTA3NzcxMSwidXNlcl9pZCI6MX0.wTpilF5W8mzEJxLeT0lxhJvK0X5tOqf4j3PKQ8mxyeU';

        $decoded = $this->jwtDecoder->decodeJwt($validJwt);
       
        $this->assertIsObject($decoded);
 
        $this->assertIsInt($decoded->iat,'No es un entero la propiedad int'); // Asegura que 'iat' es un entero
        $this->assertIsInt($decoded->exp); // Asegura que 'exp' es un entero
        $this->assertIsInt($decoded->user_id); // Asegura que 'user_id' es un entero
        
    }

    public function testDecodeInvalidJwt()
    {
        $this->expectException(JwtException::class);
        $this->jwtDecoder->decodeJwt('invalid_jwt');
    }
}
