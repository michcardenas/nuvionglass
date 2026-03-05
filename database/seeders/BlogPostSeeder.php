<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Seeder;

class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => '¿Qué es la luz azul y por qué deberías protegerte?',
                'slug' => 'que-es-la-luz-azul-y-por-que-protegerte',
                'content' => '<p>La luz azul es una porción del espectro de luz visible que tiene una longitud de onda corta (entre 380 y 500 nanómetros) y, por lo tanto, produce una mayor cantidad de energía. Se encuentra de forma natural en la luz solar, pero también es emitida en grandes cantidades por pantallas digitales, luces LED y dispositivos electrónicos.</p>

<h2>¿Por qué es peligrosa la sobreexposición?</h2>
<p>Nuestros ojos no están diseñados para filtrar eficientemente la luz azul artificial. Cuando pasamos horas frente a pantallas — algo cada vez más común en el trabajo remoto y el entretenimiento digital — exponemos nuestros ojos a niveles de luz azul que pueden causar:</p>
<ul>
<li><strong>Fatiga visual digital:</strong> Ojos secos, irritados y cansados después de largas sesiones frente a pantallas.</li>
<li><strong>Alteración del sueño:</strong> La luz azul suprime la producción de melatonina, la hormona que regula nuestro ciclo de sueño.</li>
<li><strong>Dolores de cabeza:</strong> La tensión ocular provocada por la luz azul puede desencadenar cefaleas frecuentes.</li>
<li><strong>Posible daño retinal:</strong> Estudios sugieren que la exposición prolongada podría contribuir a la degeneración macular.</li>
</ul>

<h2>¿Cómo te protegen los lentes nuvion?</h2>
<p>Los lentes nuvion glass incorporan un filtro especializado que bloquea hasta el 95% de la luz azul dañina (entre 380-450nm), mientras permite el paso de la luz azul beneficiosa. Esto significa protección sin distorsión del color, para que puedas trabajar, jugar y crear con total comodidad visual.</p>',
                'excerpt' => 'Descubre qué es la luz azul, cómo afecta tu salud visual y por qué es importante proteger tus ojos en la era digital.',
                'meta_title' => '¿Qué es la Luz Azul? Guía Completa — nuvion glass',
                'meta_description' => 'Aprende qué es la luz azul, sus efectos en la salud visual y cómo proteger tus ojos con lentes especializados.',
                'published_at' => now()->subDays(14),
            ],
            [
                'title' => '5 señales de que necesitas lentes anti luz azul',
                'slug' => '5-senales-necesitas-lentes-anti-luz-azul',
                'content' => '<p>En un mundo donde pasamos un promedio de 7-10 horas diarias frente a pantallas, la fatiga visual digital se ha convertido en una epidemia silenciosa. Pero, ¿cómo saber si realmente necesitas lentes con filtro de luz azul? Aquí te presentamos las 5 señales más claras.</p>

<h2>1. Tus ojos se sienten cansados al final del día</h2>
<p>Si al terminar tu jornada laboral sientes los ojos pesados, irritados o con una sensación de ardor, es probable que estés experimentando fatiga visual digital. Este es el síntoma más común y el primer indicador de que tus ojos necesitan protección adicional.</p>

<h2>2. Te cuesta conciliar el sueño</h2>
<p>Si revisas tu teléfono o computadora antes de dormir y luego tardas más de 20 minutos en quedarte dormido, la luz azul podría estar suprimiendo tu producción de melatonina. Los lentes con filtro de luz azul pueden ayudar a regular tu ciclo de sueño.</p>

<h2>3. Sufres dolores de cabeza frecuentes</h2>
<p>Los dolores de cabeza que aparecen después de sesiones prolongadas frente a la pantalla son una señal clara de tensión ocular. Si notas un patrón entre tu uso de pantallas y las cefaleas, es hora de considerar protección.</p>

<h2>4. Parpadeas menos de lo normal</h2>
<p>Estudios demuestran que parpadeamos hasta un 66% menos cuando miramos pantallas. Si notas que tus ojos se sienten secos o necesitas usar lágrimas artificiales frecuentemente, los lentes anti luz azul pueden complementar tu cuidado ocular.</p>

<h2>5. Tu visión se vuelve borrosa temporalmente</h2>
<p>Si después de trabajar en la computadora notas que tu visión se vuelve borrosa por unos momentos al mirar a distancia, estás experimentando espasmo acomodativo. Es una señal importante de estrés visual digital.</p>

<h2>La solución es más simple de lo que piensas</h2>
<p>Los lentes nuvion glass están diseñados específicamente para combatir estos síntomas. Con nuestro filtro de luz azul de alta eficiencia, protegerás tus ojos sin comprometer la calidad del color en tu pantalla.</p>',
                'excerpt' => 'Descubre las 5 señales que indican que necesitas lentes con filtro de luz azul y cómo pueden mejorar tu bienestar visual.',
                'meta_title' => '5 Señales de que Necesitas Lentes Anti Luz Azul — nuvion glass',
                'meta_description' => '¿Ojos cansados, insomnio, dolores de cabeza? Conoce las 5 señales de que necesitas lentes anti luz azul para proteger tu salud visual.',
                'published_at' => now()->subDays(7),
            ],
            [
                'title' => 'Trabajo remoto: cómo cuidar tus ojos en la oficina en casa',
                'slug' => 'trabajo-remoto-como-cuidar-tus-ojos',
                'content' => '<p>El trabajo remoto llegó para quedarse, y con él, un aumento significativo en el tiempo que pasamos frente a pantallas. Ya no solo es la jornada laboral: también son las videollamadas, los correos desde el celular y el entretenimiento al final del día. Tu oficina en casa puede ser cómoda, pero ¿es amigable con tus ojos?</p>

<h2>La regla 20-20-20</h2>
<p>Una de las estrategias más efectivas y sencillas para combatir la fatiga visual: cada 20 minutos, mira algo a 20 pies (6 metros) de distancia durante 20 segundos. Esto permite que tus ojos se relajen y se reenfoquen naturalmente.</p>

<h2>Iluminación correcta</h2>
<p>La iluminación de tu espacio de trabajo es crucial. Evita que la pantalla sea la fuente de luz más brillante en la habitación. Usa iluminación ambiental cálida y posiciona tu pantalla perpendicular a las ventanas para minimizar reflejos.</p>

<h2>Configuración ergonómica de pantalla</h2>
<p>Tu monitor debe estar a la distancia de un brazo extendido (50-70 cm) y el borde superior de la pantalla debe estar al nivel de tus ojos o ligeramente por debajo. Ajusta el brillo de la pantalla para que se asemeje a la iluminación de tu entorno.</p>

<h2>Filtro de luz azul: tu aliado esencial</h2>
<p>Mientras que las estrategias anteriores ayudan, un buen par de lentes con filtro de luz azul es la protección más consistente que puedes darle a tus ojos. A diferencia del modo nocturno de tu pantalla, los lentes nuvion glass filtran la luz azul dañina sin alterar los colores — esencial para diseñadores, fotógrafos y cualquier profesional que dependa de colores precisos.</p>

<h2>Hidratación y parpadeo consciente</h2>
<p>Mantén una botella de agua cerca y bebe regularmente. La hidratación afecta directamente la producción de lágrimas. Además, practica el parpadeo consciente: cierra los ojos completamente por 2 segundos cada vez que parpadees, especialmente durante tareas intensas de lectura en pantalla.</p>

<h2>Tu inversión en salud visual</h2>
<p>Cuidar tus ojos en el trabajo remoto no es un lujo, es una necesidad. Con las herramientas y hábitos correctos, puedes mantener tu productividad y proteger tu visión a largo plazo.</p>',
                'excerpt' => 'Consejos prácticos para proteger tu salud visual mientras trabajas desde casa. La regla 20-20-20, iluminación y más.',
                'meta_title' => 'Trabajo Remoto: Cómo Cuidar tus Ojos en Casa — nuvion glass',
                'meta_description' => 'Guía completa para proteger tus ojos en el trabajo remoto. Ergonomía, iluminación, la regla 20-20-20 y por qué necesitas lentes anti luz azul.',
                'published_at' => now()->subDays(2),
            ],
        ];

        foreach ($posts as $post) {
            BlogPost::create($post);
        }
    }
}
