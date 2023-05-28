#Proyecto PHP con MVC y SOLID

Este proyecto utiliza el patrón de diseño MVC (Modelo-Vista-Controlador), principios SOLID y DDD (Domain-Driven Design) para estructurar el código de manera limpia y mantenible. Utiliza el paquete `nikic/fast-route` para el manejo de rutas y `php-di/php-di` para la inyección de dependencias.

es proyecto ligero que te permite escalar cualquier aplicacion

## Descripción de los directorios

- `core`: Contiene clases fundamentales como `Controller`, `Core`, `Database` y `Model`.
- `app`:contiene los archivos principales de la aplicacion como el constrolador el modelo,
    - `controllers`: Contiene los controladores de la aplicación, que manejan la lógica de la interfaz de usuario.
    - `helpers`: Contiene funciones auxiliares que se pueden utilizar en toda la aplicación.
    - `models`: Contiene los modelos de la aplicación, que representan las entidades de negocio y contienen la lógica de negocio.
    - `repositories`: Contiene los repositorios, que proporcionan una abstracción para el acceso a los datos.
    - `services`: Contiene los servicios, que encapsulan la lógica de negocio que no pertenece a ninguna entidad específica.
    - `views`: Contiene las vistas de la aplicación, que son responsables de presentar la información al usuario- `uploads`: Contiene los archivos subidos por los usuarios.

- `assets`: Contiene los archivos estáticos como CSS, JavaScript e imágenes.
- `config`: Contiene archivos de configuración, como `services.php` para la configuración de la inyección de dependencias.
- `vendor`: Contiene las dependencias de Composer.

## Dependencias

- `nikic/fast-route`: Un paquete de enrutamiento rápido y simple para PHP. Se utiliza para manejar todas las rutas de la aplicación.
- `php-di/php-di`: Un contenedor de inyección de dependencias para PHP. Se utiliza para gestionar las dependencias de la aplicación y hacer que el código sea más flexible y fácil de probar.

## Cómo ejecutar el proyecto

1. Clona el repositorio en tu máquina local.
2. Navega al directorio del proyecto en tu terminal.
3. Ejecuta `composer install` para instalar las dependencias del proyecto.
4. Configura tu entorno y la base de datos en `config.php` y `environment.php`.
5. Ejecuta el servidor de desarrollo de PHP con `php -S localhost:8000` (o cualquier puerto de tu elección).
6. Abre tu navegador y navega a `http://localhost:8000` para ver la aplicación en acción.


# Aquí se muestra cómo configurar la clase User, que extiende de la clase Model:

 cualquier clase que extienda Model automáticamente asumirá el nombre de la tabla basándose en su nombre de clase. Por ejemplo, la clase User tendría una tabla llamada 'users', y una clase Restaurant tendría una tabla llamada 'restaurants'.
 si tu base de datos utiliza nombres de tabla en singular o alguna otra convención, tendrás que ajustar la propiedad
 protected $table; en tu modelo
 tambien puedes especificar los siguientes campos en el modelo
  - `protected primaryKey:` define el campo primary que de la tabla por defalut definido en 'id'
  - `protected array_result:` define el campo se rotornan los resultados del query por default retornan como array de lo contrario retornan como objeto-
 
  - `protected autoUpdateTimestamp:`  por default 'false' se usa para agregar autumaticamente valor de actualizacion en el campo updated_at de la tabla.
    - `protected updated_at:` define el campo timestamp para guardar la fecha y hora de la actualizacion de un registro  por default 'updated_at'
 ejemplo

```
<?php

class User extends Model;

class User extends Model {
    protected $table = 'users';

    public function posts() {
        $postModel = new Post();
        return $postModel->where('user_id', $this->id)->get();
    }
}

```
si se desea usar el constructor en el modelo es necesario agregar      parent::__construct();
- En este caso, configuramos la tabla a la que se aplica la clase User (users), y creamos un método (posts) que obtiene todas las publicaciones de un usuario.

Ahora puedes usar la clase User para hacer consultas relacionadas con los usuarios. Aquí hay algunos ejemplos:

 ## Métodos Disponibles:
`insert(array $data): Model`
- Este método inserta una nueva fila en la base de datos utilizando la información proporcionada en $data.

Ejemplo:
```
$userModel = new User();
$userModel->insert(['name' => 'John', 'email' => 'john@example.com']);

```

`update(array $data, array $conditions): Model`
 - Este método actualiza una fila en la base de datos que cumple con las condiciones proporcionadas.

Ejemplo:
``` $userModel = new User();
$userModel->update(['email' => 'john.doe@example.com'], ['id' => 1]);

```

`delete(array $conditions): Model`
- Este método elimina una fila de la base de datos que cumple con las condiciones proporcionadas.

Ejemplo
```
$userModel = new User();
$userModel->delete(['id' => 1]);
```
`where(string $field, mixed $value): Model`
Este método agrega una condición a la próxima consulta.

Ejemplo:
```
$userModel = new User();
$user = $userModel->where('id', 1)->first();
```

`first(): array`
Este método devuelve la primera fila que cumple con las condiciones previamente establecidas con el método where.

Ejemplo:
```
$userModel = new User();
$user = $userModel->where('id', 1)->first();
```

`get(): array`
Este método devuelve todas las filas que cumplen con las condiciones previamente establecidas con el método where.

Ejemplo:
```
$userModel = new User();
$users = $userModel->where('email', '%juan%','LIKE')->get();
```
`select()`
 puedes hacer una consulta personalizada utilizando el método select de la siguiente manera:
```
$userModel = new User();

$result = $userModel->select('users.nameUser', 'categories.nameCategory')
                    ->where('active', true)
                    ->orderBy('id', 'ASC')
                    ->get();
```
`limit(int $limit): Model`
Este método limita el número de filas devueltas por el método get.

Ejemplo:
```
$userModel = new User();
$users = $userModel->limit(10)->get();
$userModel->where('email', '%juan%','LIKE')->limit(10)->get();

```
metodos `join` ,`leftJoin`  `rightJoin` 
para usar consultas relacionas puedes usar de la siguiente manera ejemplo


```
$result = $userModel->select('users.nombre', 'titulo')
                    ->leftJoin('posts', 'users.id', '=', 'posts.user_id')
                    ->where('users.id', 1)
                    ->orderBy('id', 'ASC')
                    ->get();


```
metodo `count()`
$result = $postModel->count()
    ->where('active', true)
;
```

```

`query(string $sql, array $params = []): array`
Este método ejecuta una consulta SQL directamente en la base de datos.

Ejemplo:
```
$userModel = new User();
$results = $userModel->query("SELECT * FROM users WHERE id = ?", [1]);

```

php

## Inyección de Dependencias
 
Para agregar una nueva inyección de dependencia, debes modificar el archivo config/services.php. Este archivo es donde se definen todas las dependencias que se pueden inyectar en tu aplicación.

Aquí tienes un ejemplo de cómo agregar una nueva dependencia:
```
use DI\ContainerBuilder;

$containerBuilder = new ContainerBuilder();

$containerBuilder->addDefinitions([
    // Aquí es donde defines tus dependencias
    'repositories\socialMedia\SocialAccessTokenRepositoryInterface' => function () {
        return new \repositories\socialMedia\SocialAccessTokenRepository(new \models\SocialAccessTokenModel());
    },
    'repositories\UserRepositoryInterface' => function () {
        return new \repositories\UserRepository(new \models\());
    },
    'services\FileUploaderInterface' => function () {
        return new \services\FileUploader();
    },
]);

$container = $containerBuilder->build();
```

En este ejemplo, estamos definiendo tres dependencias: `SocialAccessTokenRepositoryInterface`, `UserRepositoryInterface` y `FileUploaderInterface`. Cada una de estas dependencias se define como una función anónima que devuelve una nueva instancia de la clase correspondiente.

Cuando necesites inyectar una de estas dependencias en tu código, simplemente puedes hacerlo a través del constructor de la clase o mediante un método setter. PHP-DI se encargará automáticamente de crear la instancia correcta y de inyectarla donde sea necesario.

Las contribuciones son bienvenidas. Por favor, abre un issue o un pull request si tienes algo que añadir o cambiar.

## Uso de la clase Request
La clase Request proporciona una forma sencilla de acceder a los datos de la solicitud HTTP entrante. Aquí tienes algunos ejemplos de cómo puedes usarla en tus controladores:
```
 use core\Request;

public function createPost(Request $request)
{
    // Acceder a los datos de la consulta
    $postId = $request->query('post_id');

    // Acceder a los datos de la entrada (ya sea JSON o form-data)
    $title = $request->input('title');

    // Acceder a los encabezados de la solicitud
    $contentType = $request->header('Content-Type');

    // Comprobar el método de la solicitud
    if ($request->isMethod('post')) {
        // ...
    }

    // Validar los datos de entrada
    $request->validate([
        'title' => 'required',
        'content' => 'required',
    ]);

    // ...
}
```
## Licencia

## Contribuir
Este proyecto está licenciado bajo los términos de la licencia MIT. Consulta el archivo `LICENSE` para más detalles.


@ MVC ligero creado por jhonatanrojas