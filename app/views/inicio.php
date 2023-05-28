<!--div class="vue-app">
        <hello-world msg="header"></hello-world>
    </div-->

    <p>#LightPHP-MVC</p>
<p>##Proyecto PHP con MVC + VUE</p>
<p>Este proyecto utiliza el patrón de diseño MVC (Modelo-Vista-Controlador), principios SOLID y DDD (Domain-Driven Design) para estructurar el código de manera limpia y mantenible. Utiliza el paquete <code>nikic/fast-route</code> para el manejo de rutas y <code>php-di/php-di</code> para la inyección de dependencias.
Ademas incorpora vue.js y el manejador de paquetes vite.js</p>
<p>es proyecto ligero que te permite escalar cualquier aplicacion</p>
<h2 id="descripci-n-de-los-directorios">Descripción de los directorios</h2>
<ul>
<li><code>core</code>: Contiene clases fundamentales como <code>Controller</code>, <code>Core</code>, <code>Database</code> y <code>Model</code>.</li>
<li><p><code>app</code>:contiene los archivos principales de la aplicacion como el constrolador el modelo,</p>
<ul>
<li><code>controllers</code>: Contiene los controladores de la aplicación, que manejan la lógica de la interfaz de usuario.</li>
<li><code>helpers</code>: Contiene funciones auxiliares que se pueden utilizar en toda la aplicación.</li>
<li><code>models</code>: Contiene los modelos de la aplicación, que representan las entidades de negocio y contienen la lógica de negocio.</li>
<li><code>repositories</code>: Contiene los repositorios, que proporcionan una abstracción para el acceso a los datos.</li>
<li><code>services</code>: Contiene los servicios, que encapsulan la lógica de negocio que no pertenece a ninguna entidad específica.</li>
<li><code>views</code>: Contiene las vistas de la aplicación, que son responsables de presentar la información al usuario- <code>uploads</code>: Contiene los archivos subidos por los usuarios.</li>
</ul>
</li>
<li><p><code>assets</code>: Contiene los archivos estáticos como CSS, JavaScript e imágenes.</p>
</li>
<li><code>config</code>: Contiene archivos de configuración, como <code>services.php</code> para la configuración de la inyección de dependencias.</li>
<li><code>vendor</code>: Contiene las dependencias de Composer.</li>
</ul>
<h2 id="dependencias">Dependencias</h2>
<ul>
<li><code>nikic/fast-route</code>: Un paquete de enrutamiento rápido y simple para PHP. Se utiliza para manejar todas las rutas de la aplicación.</li>
<li><code>php-di/php-di</code>: Un contenedor de inyección de dependencias para PHP. Se utiliza para gestionar las dependencias de la aplicación y hacer que el código sea más flexible y fácil de probar.</li>
</ul>
<h2 id="c-mo-ejecutar-el-proyecto">Cómo ejecutar el proyecto</h2>
<ol>
<li>Clona el repositorio en tu máquina local.</li>
<li>Navega al directorio del proyecto en tu terminal.</li>
<li>Ejecuta <code>composer install</code> para instalar las dependencias del proyecto.</li>
<li>Configura tu entorno y la base de datos en <code>config.php</code> y <code>environment.php</code>.</li>
<li>Ejecuta el servidor de desarrollo de PHP con <code>php -S localhost:8000</code> (o cualquier puerto de tu elección).</li>
<li>Abre tu navegador y navega a <code>http://localhost:8000</code> para ver la aplicación en acción.</li>
</ol>
<h1 id="aqu-se-muestra-c-mo-configurar-la-clase-user-que-extiende-de-la-clase-model-">Aquí se muestra cómo configurar la clase User, que extiende de la clase Model:</h1>
<p> cualquier clase que extienda Model automáticamente asumirá el nombre de la tabla basándose en su nombre de clase. Por ejemplo, la clase User tendría una tabla llamada &#39;users&#39;, y una clase Restaurant tendría una tabla llamada &#39;restaurants&#39;.
 si tu base de datos utiliza nombres de tabla en singular o alguna otra convención, tendrás que ajustar la propiedad
 protected $table; en tu modelo
 tambien puedes especificar los siguientes campos en el modelo</p>
<ul>
<li><code>protected primaryKey:</code> define el campo primary que de la tabla por defalut definido en &#39;id&#39;</li>
<li><p><code>protected array_result:</code> define el campo se rotornan los resultados del query por default retornan como array de lo contrario retornan como objeto-</p>
</li>
<li><p><code>protected autoUpdateTimestamp:</code>  por default &#39;false&#39; se usa para agregar autumaticamente valor de actualizacion en el campo updated_at de la tabla.</p>
<ul>
<li><code>protected updated_at:</code> define el campo timestamp para guardar la fecha y hora de la actualizacion de un registro  por default &#39;updated_at&#39;
ejemplo</li>
</ul>
</li>
</ul>
<pre><code>&lt;?php

<span class="hljs-class"><span class="hljs-keyword">class</span> <span class="hljs-title">User</span> <span class="hljs-keyword">extends</span> <span class="hljs-title">Model</span></span>;

<span class="hljs-class"><span class="hljs-keyword">class</span> <span class="hljs-title">User</span> <span class="hljs-keyword">extends</span> <span class="hljs-title">Model</span> </span>{
    <span class="hljs-keyword">protected</span> $table = <span class="hljs-symbol">'user</span>s';

    public function posts() {
        $postModel = <span class="hljs-keyword">new</span> <span class="hljs-type">Post</span>();
        <span class="hljs-keyword">return</span> $postModel-&gt;where(<span class="hljs-symbol">'user_i</span>d', $<span class="hljs-keyword">this</span>-&gt;id)-&gt;get();
    }
}
</code></pre><p>si se desea usar el constructor en el modelo es necesario agregar      parent::__construct();</p>
<ul>
<li>En este caso, configuramos la tabla a la que se aplica la clase User (users), y creamos un método (posts) que obtiene todas las publicaciones de un usuario.</li>
</ul>
<p>Ahora puedes usar la clase User para hacer consultas relacionadas con los usuarios. Aquí hay algunos ejemplos:</p>
<h2 id="m-todos-disponibles-">Métodos Disponibles:</h2>
<p><code>insert(array $data): Model</code></p>
<ul>
<li>Este método inserta una nueva fila en la base de datos utilizando la información proporcionada en $data.</li>
</ul>
<p>Ejemplo:</p>
<pre><code>$userModel = <span class="hljs-keyword">new</span> User();
$userModel-&gt;insert([<span class="hljs-string">'name'</span> =&gt; <span class="hljs-string">'John'</span>, <span class="hljs-string">'email'</span> =&gt; <span class="hljs-string">'john@example.com'</span>]);
</code></pre><p><code>update(array $data, array $conditions): Model</code></p>
<ul>
<li>Este método actualiza una fila en la base de datos que cumple con las condiciones proporcionadas.</li>
</ul>
<p>Ejemplo:
``` $userModel = new User();
$userModel-&gt;update([&#39;email&#39; =&gt; &#39;john.doe@example.com&#39;], [&#39;id&#39; =&gt; 1]);</p>
<pre><code>
`delete(array <span class="hljs-variable">$conditions</span>): Model`
- Este <span class="hljs-keyword">m</span>étodo elimina una fila <span class="hljs-keyword">de</span> <span class="hljs-keyword">la</span> base <span class="hljs-keyword">de</span> datos <span class="hljs-keyword">que</span> cumple con las condiciones proporcionadas.

Ejemplo
</code></pre><p>$userModel = new User();
$userModel-&gt;delete([&#39;id&#39; =&gt; 1]);</p>
<pre><code>`where(string <span class="hljs-variable">$field</span>, mixed <span class="hljs-variable">$value</span>): Model`
Este <span class="hljs-keyword">m</span>étodo agrega una condició<span class="hljs-keyword">n</span> a <span class="hljs-keyword">la</span> <span class="hljs-keyword">pr</span>óxima consulta.

Ejemplo:
</code></pre><p>$userModel = new User();
$user = $userModel-&gt;where(&#39;id&#39;, 1)-&gt;first();</p>
<pre><code>
`<span class="hljs-keyword">first</span>(): array`
Este <span class="hljs-keyword">m</span>étodo devuelve <span class="hljs-keyword">la</span> primera fila que cumple <span class="hljs-keyword">con</span> las condiciones previamente establecidas <span class="hljs-keyword">con</span> <span class="hljs-keyword">el</span> <span class="hljs-keyword">m</span>étodo where.

Ejemplo:
</code></pre><p>$userModel = new User();
$user = $userModel-&gt;where(&#39;id&#39;, 1)-&gt;first();</p>
<pre><code>
`<span class="hljs-built_in">get</span>(): array`
Este <span class="hljs-keyword">m</span>étodo devuelve todas las filas que cumplen <span class="hljs-keyword">con</span> las condiciones previamente establecidas <span class="hljs-keyword">con</span> <span class="hljs-keyword">el</span> <span class="hljs-keyword">m</span>étodo where.

Ejemplo:
</code></pre><p>$userModel = new User();
$users = $userModel-&gt;where(&#39;email&#39;, &#39;%juan%&#39;,&#39;LIKE&#39;)-&gt;get();</p>
<pre><code>`select()`
 puedes hacer <span class="hljs-keyword">una</span> consulta personalizada utilizando <span class="hljs-keyword">el</span> <span class="hljs-keyword">m</span>étodo select de <span class="hljs-keyword">la</span> siguiente maner<span class="hljs-variable">a:</span>
</code></pre><p>$userModel = new User();</p>
<p>$result = $userModel-&gt;select(&#39;users.nameUser&#39;, &#39;categories.nameCategory&#39;)
                    -&gt;where(&#39;active&#39;, true)
                    -&gt;orderBy(&#39;id&#39;, &#39;ASC&#39;)
                    -&gt;get();</p>
<pre><code>`limit(<span class="hljs-keyword">int</span> $limit): Model`
Este <span class="hljs-keyword">m</span>étodo limita <span class="hljs-keyword">el</span> número de filas devueltas por <span class="hljs-keyword">el</span> <span class="hljs-keyword">m</span>étodo <span class="hljs-built_in">get</span>.

Ejemplo:
</code></pre><p>$userModel = new User();
$users = $userModel-&gt;limit(10)-&gt;get();
$userModel-&gt;where(&#39;email&#39;, &#39;%juan%&#39;,&#39;LIKE&#39;)-&gt;limit(10)-&gt;get();</p>
<pre><code>metodos `join` ,`leftJoin`  `rightJoin` 
para usar consultas relacionas puedes usar de la siguiente manera ejemplo
</code></pre><p>$result = $userModel-&gt;select(&#39;users.nombre&#39;, &#39;titulo&#39;)
                    -&gt;leftJoin(&#39;posts&#39;, &#39;users.id&#39;, &#39;=&#39;, &#39;posts.user_id&#39;)
                    -&gt;where(&#39;users.id&#39;, 1)
                    -&gt;orderBy(&#39;id&#39;, &#39;ASC&#39;)
                    -&gt;get();</p>
<pre><code>metodo `count()`
$result = $postModel-&gt;count()
    -&gt;<span class="hljs-keyword">where</span>(<span class="hljs-string">'active'</span>, true)
;
</code></pre><p>$page = isset($_GET[&#39;page&#39;]) &amp;&amp; is_numeric($_GET[&#39;page&#39;]) &amp;&amp; $_GET[&#39;page&#39;] &gt; 0 ? (int) $_GET[&#39;page&#39;] : 1;</p>
<pre><code>El <span class="hljs-keyword">m</span>étodo `paginate`  del siguiente modo:
Primero, necesitarás instanciar tu modelo. Por ejemplo, si tienes un modelo <span class="hljs-keyword">de</span> usuarios `(UserModel)`, lo instanciarí<span class="hljs-keyword">as</span> <span class="hljs-keyword">as</span>í:
`<span class="hljs-variable">$userModel</span> = new UserModel();`

Luego, puedes llamar al <span class="hljs-keyword">m</span>étodo `paginate` <span class="hljs-keyword">en</span> tu modelo. Deberás pasar tres argumentos a este <span class="hljs-keyword">m</span>étodo:

El <span class="hljs-keyword">n</span>úmero <span class="hljs-keyword">de</span> registros <span class="hljs-keyword">que</span> quieres mostrar por página.
<span class="hljs-keyword">La</span> página actual.
<span class="hljs-keyword">La</span> URL  <span class="hljs-keyword">de</span> <span class="hljs-keyword">la</span> peticion.
Aquí tienes un ejemplo <span class="hljs-keyword">de</span> cómo podrí<span class="hljs-keyword">as</span> hacerlo:
<span class="hljs-variable">$perPage</span> = 10; <span class="hljs-comment">// Muestra 10 usuarios por página.</span>
<span class="hljs-variable">$currentPage</span> = 1; <span class="hljs-comment">// Estamos en la primera página.</span>
<span class="hljs-variable">$path</span> = '/users';

``
    <span class="hljs-variable">$pagination</span> = <span class="hljs-variable">$userModel</span>-&gt;orderBy('id', 'ASC')-&gt;paginate(<span class="hljs-variable">$perPage</span>, <span class="hljs-variable">$currentPage</span>, <span class="hljs-variable">$path</span>);
  responseJson(<span class="hljs-variable">$pagination</span>);

``
<span class="hljs-keyword">La</span> variable <span class="hljs-variable">$pagination</span> será un array <span class="hljs-keyword">que</span> contiene <span class="hljs-keyword">la</span> data paginada, los enlaces <span class="hljs-keyword">de</span> paginació<span class="hljs-keyword">n</span> y metadatos sobre <span class="hljs-keyword">la</span> paginació<span class="hljs-keyword">n</span>.
tambien puedes aplicarle los metodos where join y <span class="hljs-keyword">order</span> <span class="hljs-keyword">by</span>


`<span class="hljs-keyword">query</span>(string <span class="hljs-variable">$sql</span>, array <span class="hljs-variable">$params</span> = []): array`
Este <span class="hljs-keyword">m</span>étodo ejecuta una consulta SQL directamente <span class="hljs-keyword">en</span> <span class="hljs-keyword">la</span> base <span class="hljs-keyword">de</span> datos.

Ejemplo:
</code></pre><p>$userModel = new User();
$results = $userModel-&gt;query(&quot;SELECT * FROM users WHERE id = ?&quot;, [1]);</p>
<pre><code>
php

## Inyección de Dependencias

Para agregar <span class="hljs-keyword">una</span> nueva inyección de dependencia, debes modificar <span class="hljs-keyword">el</span> archivo config/services.php. Este archivo es donde <span class="hljs-keyword">se</span> definen todas las dependencias que <span class="hljs-keyword">se</span> pueden inyectar <span class="hljs-keyword">en</span> <span class="hljs-keyword">tu</span> aplicación.

Aquí tienes un ejemplo de <span class="hljs-keyword">c</span>ómo agregar <span class="hljs-keyword">una</span> nueva dependenci<span class="hljs-variable">a:</span>
</code></pre><p>use DI\ContainerBuilder;</p>
<p>$containerBuilder = new ContainerBuilder();</p>
<p>$containerBuilder-&gt;addDefinitions([
    // Aquí es donde defines tus dependencias
    &#39;repositories\socialMedia\SocialAccessTokenRepositoryInterface&#39; =&gt; function () {
        return new \repositories\socialMedia\SocialAccessTokenRepository(new \models\SocialAccessTokenModel());
    },
    &#39;repositories\UserRepositoryInterface&#39; =&gt; function () {
        return new \repositories\UserRepository(new \models());
    },
    &#39;services\FileUploaderInterface&#39; =&gt; function () {
        return new \services\FileUploader();
    },
]);</p>
<p>$container = $containerBuilder-&gt;build();</p>
<pre><code>
<span class="hljs-keyword">En</span> este ejemplo, estamos definiendo tres dependencias: `SocialAccessTokenRepositoryInterface`, `UserRepositoryInterface` y `FileUploaderInterface`. Cada una <span class="hljs-keyword">de</span> estas dependencias <span class="hljs-keyword">se</span> define como una funció<span class="hljs-keyword">n</span> <span class="hljs-keyword">an</span>ónima <span class="hljs-keyword">que</span> devuelve una nueva instancia <span class="hljs-keyword">de</span> <span class="hljs-keyword">la</span> clase correspondiente.

Cuando necesites inyectar una <span class="hljs-keyword">de</span> estas dependencias <span class="hljs-keyword">en</span> tu código, simplemente puedes hacerlo a través del constructor <span class="hljs-keyword">de</span> <span class="hljs-keyword">la</span> clase o mediante un <span class="hljs-keyword">m</span>étodo setter. PHP-<span class="hljs-keyword">DI</span> <span class="hljs-keyword">se</span> encargará automáticamente <span class="hljs-keyword">de</span> crear <span class="hljs-keyword">la</span> instancia correcta y <span class="hljs-keyword">de</span> inyectarla donde sea necesario.

Las contribuciones son bienvenidas. Por favor, abre un issue o un pull request si tienes algo <span class="hljs-keyword">que</span> añadir o cambiar.

## Uso <span class="hljs-keyword">de</span> <span class="hljs-keyword">la</span> clase Request
<span class="hljs-keyword">La</span> clase Request proporciona una <span class="hljs-keyword">forma</span> sencilla <span class="hljs-keyword">de</span> acceder a los datos <span class="hljs-keyword">de</span> <span class="hljs-keyword">la</span> solicitud HTTP entrante. Aquí tienes algunos ejemplos <span class="hljs-keyword">de</span> cómo puedes usarla <span class="hljs-keyword">en</span> tus controladores:
</code></pre><p> use core\Request;</p>
<p>public function createPost(Request $request)
{
    // Acceder a los datos de la consulta
    $postId = $request-&gt;query(&#39;post_id&#39;);</p>
<pre><code><span class="hljs-comment">// Acceder a los datos de la entrada (ya sea JSON o form-data)</span>
$title = $request-&gt;input(<span class="hljs-string">'title'</span>);

<span class="hljs-comment">// Acceder a los encabezados de la solicitud</span>
$contentType = $request-&gt;header(<span class="hljs-string">'Content-Type'</span>);

<span class="hljs-comment">// Comprobar el método de la solicitud</span>
<span class="hljs-keyword">if</span> ($request-&gt;isMethod(<span class="hljs-string">'post'</span>)) {
    <span class="hljs-comment">// ...</span>
}

<span class="hljs-comment">// Validar los datos de entrada</span>
$request-&gt;validate([
    <span class="hljs-string">'title'</span> =&gt; <span class="hljs-string">'required'</span>,
    <span class="hljs-string">'content'</span> =&gt; <span class="hljs-string">'required'</span>,
]);

<span class="hljs-comment">// ...</span>
</code></pre><p>}</p>
<pre><code>El <span class="hljs-keyword">m</span>étodo `validate`<span class="hljs-keyword">se</span> puede usar <span class="hljs-keyword">de</span> <span class="hljs-keyword">la</span> siguiente manera <span class="hljs-keyword">en</span> el controlador al intentar insertar un usuario. Primero debes crear una instancia <span class="hljs-keyword">de</span> <span class="hljs-keyword">la</span> clase Request y luego pasar el arreglo <span class="hljs-keyword">de</span> reglas <span class="hljs-keyword">de</span> validació<span class="hljs-keyword">n</span> al <span class="hljs-keyword">m</span>étodo validate. Aquí tienes un ejemplo <span class="hljs-keyword">de</span> cómo <span class="hljs-keyword">se</span> haría <span class="hljs-keyword">en</span> un <span class="hljs-keyword">m</span>étodo del controlador para crear un usuario:
</code></pre><p>use exceptions\ValidationException;
public function create() {
    $request = new Request();</p>
<pre><code><span class="hljs-keyword">try</span> {
    $request-&gt;validate([
        <span class="hljs-string">'name'</span> =&gt; <span class="hljs-string">'required'</span>,
        <span class="hljs-string">'email'</span> =&gt; <span class="hljs-string">'required|email|unique:users,email'</span>,
        <span class="hljs-string">'password'</span> =&gt; <span class="hljs-string">'required'</span>,
        <span class="hljs-string">'birthdate'</span> =&gt; <span class="hljs-string">'date'</span>
    ]);

    $user = <span class="hljs-keyword">new</span> User();
    $user-&gt;name = $_POST[<span class="hljs-string">'name'</span>];
    $user-&gt;email = $_POST[<span class="hljs-string">'email'</span>];
    $user-&gt;password = password_hash($_POST[<span class="hljs-string">'password'</span>], PASSWORD_DEFAULT);
    $user-&gt;birthdate = $_POST[<span class="hljs-string">'birthdate'</span>];
    $user-&gt;save();

    <span class="hljs-comment">// Redirige a la página de inicio de sesión, por ejemplo</span>
</code></pre><p>   } catch (ValidationException $ve) {
    // Maneja ValidationException...
            $errors = $ve-&gt;getErrors();
            // Procesa los errores...
        } catch (Exception $e) {
            // Maneja excepciones generales...
            echo $e-&gt;getMessage();
        }
}</p>
<p>```</p>
<h2 id="helper-dd-no-mas-var_dump">Helper dd() no mas var_dump</h2>
<ul>
<li>Incorporamos al proyecto la funcion dd del proyecto de laravel, pequeña función muy útil para probar rápidamente el contenido de una variable: dd() (Dump and Die). Se utiliza para mostrar texto en pantalla y finalizar la ejecución del programa<h2 id="licencia">Licencia</h2>
Este proyecto está licenciado bajo los términos de la licencia MIT. Consulta el archivo <code>LICENSE</code> para más detalles.<h2 id="contribuir">Contribuir</h2>
</li>
</ul>
<p>@ MVC ligero creado por jhonatanrojas</p>
