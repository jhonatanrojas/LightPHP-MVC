<?php
namespace services\jwt;

use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\Key;
use exceptions\JwtException;

class JwtDecoder {
    private $secret_key;

    public function __construct(string $secret_key) {
        $this->secret_key = $secret_key;
    }

    public function decodeJwt(string $jwt) {
        try {
            return JWT::decode(trim($jwt),  new Key($this->secret_key,'HS256'));
        } catch (ExpiredException $e) {
            throw new JwtException('Token expirado');
        } catch (SignatureInvalidException $e) {
            throw new JwtException('Firma del token inválida');
        } catch (BeforeValidException $e) {
            throw new JwtException('Token no válido antes del tiempo configurado');
        } catch (\Exception $e) {
            // Captura cualquier otra excepción y devuelve su mensaje
            throw new JwtException('Error decodificando el token: ' . $e->getMessage());
        }
    }
}