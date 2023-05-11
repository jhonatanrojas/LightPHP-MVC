<?php
namespace lib;


use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\Key;

class JwtAuth {
    private $secret_key;

    public function __construct($secret_key) {
        $this->secret_key = $secret_key;
    }

    public function createJwt($user_id) {
        $issued_at = time();
        $expiration_time = $issued_at + (120 * 120); // Token válido por 1 hora

        $payload = array(
            'iat' => $issued_at,
            'exp' => $expiration_time,
            'user_id' => $user_id
        );

        return JWT::encode($payload, $this->secret_key, 'HS256');
    }

    public function decodeJwt($jwt) {
      
  
 
        try {
            return JWT::decode(trim($jwt),  new Key($this->secret_key,'HS256'));
        } catch (ExpiredException $e) {
            return 'Token expirado';
        } catch (SignatureInvalidException $e) {
            return 'Firma del token inválida';
        } catch (BeforeValidException $e) {
            return 'Token no válido antes del tiempo configurado';
        } catch (\Exception $e) {
            // Captura cualquier otra excepción y devuelve su mensaje
            return 'Error decodificando el token: ' . $e->getMessage();
        }
    }
}
