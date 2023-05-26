<?php

namespace services\jwt;

use Firebase\JWT\JWT;

class JwtAuth {
    private $secret_key;

    public function __construct(string $secret_key) {
       $this->secret_key = $secret_key;
    }

    public function createJwt(int $user_id): string {
        $issued_at = time();
        $expiration_time = $issued_at + (120 * 120); // Token válido por 1 hora

        $payload = array(
            'iat' => $issued_at,
            'exp' => $expiration_time,
            'user_id' => $user_id
        );

        return JWT::encode($payload, $this->secret_key, 'HS256');
    }
}