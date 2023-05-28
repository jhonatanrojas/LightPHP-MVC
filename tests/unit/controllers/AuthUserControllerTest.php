<?php
use PHPUnit\Framework\TestCase;
use controllers\AuthUserController;
use Dotenv\Dotenv;
use services\jwt\JwtAuth;
use repositories\UserRepositoryInterface;
use models\SocialAccessTokenModel;

class AuthUserControllerTest extends TestCase
{
    private $userRepository;
    private $AuthUserController;

    protected function setUp(): void
    {
          // Cargar las variables de entorno desde el archivo .env
          $dotenv = Dotenv::createImmutable(__DIR__.'/../../../');
          $dotenv->load();
        $this->userRepository = $this->createMock(UserRepositoryInterface::class);
        $this->AuthUserController = new AuthUserController($this->userRepository);
    }

    public function testIndex_ValidCredentials_ReturnsTokenAndPlatforms()
    {
        // Arrange
        $email = 'test@example.com';
        $password = 'password';
        $userId = 1;
        $token = 'jwt_token';
        $platforms = ['platform1', 'platform2'];

        // Se crea un objeto de datos simulado
        $dataObject = new \stdClass();
        $dataObject->email = $email;
        $dataObject->password = $password;

        // Se configuran los comportamientos esperados de las dependencias simuladas
        $user = [
            'id' => $userId,
            'password' => $password,
        ];

        $this->userRepository->expects($this->once())
            ->method('getUser')
            ->with($email)
            ->willReturn($user);

        $this->AuthUserController->jwtAuth = $this->createMock(JwtAuth::class);
        $this->AuthUserController->jwtAuth->expects($this->once())
            ->method('createJwt')
            ->with($userId)
            ->willReturn($token);

        $this->AuthUserController->socialAccessTokenModel = $this->createMock(SocialAccessTokenModel::class);
        $this->AuthUserController->socialAccessTokenModel->expects($this->once())
            ->method('getAccess')
            ->with($userId)
            ->willReturn($platforms);
        // Se define el resultado esperado
        $expectedResult = json_encode(['result' => true, 'token' => $token, 'platforms' => $platforms]);

        // Act
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['email'] = $email;
        $_POST['password'] = $password;
    
        ob_start();
        $this->AuthUserController->index();
        $actualResult = ob_get_clean();

        // Assert
        $this->assertEquals(
            $expectedResult,
            $actualResult,
            'El test "testIndex_ValidCredentials_ReturnsTokenAndPlatforms" ha fallado. El resultado esperado no coincide con el resultado actual.'
        );
    }

    public function testIndex_InvalidCredentials_ReturnsFalse()
    {
        // Arrange
      // Se definen credenciales inválidas

        $email = 'test@example.com';
        $password = 'password';

        $dataObject = new \stdClass();
        $dataObject->email = $email;
        $dataObject->password = $password;

        // Se configura el comportamiento esperado de la dependencia simulada
      
        $this->userRepository->expects($this->once())
            ->method('getUser')
            ->with($email)
            ->willReturn([]);
        // Se define el resultado esperado
        $expectedResult = json_encode(['result' => false, 'mensaje' => 'el email no se encuentra registrado']);

        // Act
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['email'] = $email;
        $_POST['password'] = $password;
        ob_start();
     
        $this->AuthUserController->index();
        $actualResult = ob_get_clean();

        // Assert
        $this->assertEquals(
            $expectedResult,
            $actualResult,
            'El test "testIndex_InvalidCredentials_ReturnsFalse" ha fallado. El resultado esperado no coincide con el resultado actual.'
        );
    }
}
