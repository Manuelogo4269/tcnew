# Presentación del Proyecto: Atelier Zacatecas
> **Plataforma E-Commerce Multi-Tienda y Progressive Web App (PWA) para el Centro Histórico de Zacatecas**

---

## 📌 Diapositiva 1: Portada
* **Título:** Atelier Zacatecas — E-Commerce Multi-Tienda & PWA
* **Subtítulo:** Digitalización del comercio local del Centro Histórico y el poder de las aplicaciones web progresivas.
* **Puntos clave de inicio:**
  - 10 Comercios emblemáticos en producción.
  - Arquitectura PWA instalable y tolerante a fallos de red.
  - Ruta comercial y turística peatonal.
  - Pedidos directos sin intermediarios por WhatsApp.

---

## 📌 Diapositiva 2: ¿Qué es el proyecto y cuál es su funcionalidad?
### El Problema
Los comercios tradicionales de Zacatecas Centro (cafeterías de tradición, platerías de plata ley .925, tiendas de ropa, dulcerías típicas y artesanías) carecen de tiendas virtuales independientes o se ven forzados a usar plataformas centralizadas con comisiones del 20% al 30% por venta.

### La Solución
Una plataforma digital donde:
1. **Cada negocio tiene su propia tienda online independiente:** Cada comercio opera con su propia base de datos SQLite aislada en modo WAL, subdominio personalizado (ejemplo: `/acropolis`, `/rosadeplata`), panel privado de inventario y 0% de comisiones por venta.
2. **Un portal central unificado:** Los clientes y turistas pueden explorar un directorio completo de comercios, buscar productos en todas las tiendas a la vez y seguir una ruta turística peatonal trazada en el mapa.

---

## 📌 Diapositiva 3: Funcionalidades Principales (Para el Cliente)
1. **Catálogos Autónomos en Vivo:** Exploración de productos reales con fotografías de alta resolución, descripción, variantes, precios en pesos mexicanos y stock.
2. **Pedidos Inmediatos por WhatsApp:** Sin registros complicados ni pasarelas forzosas; el cliente arma su carrito y con un clic envía su pedido formateado al WhatsApp oficial del comercio.
3. **Estado de Apertura en Tiempo Real:** El sistema calcula automáticamente si el comercio está "Abierto Ahora" o "Cerrado" según su horario real de atención en Zacatecas.
4. **Ruta Peatonal del Centro Histórico:** Guía turística interactiva paso a paso para visitar los negocios caminando (Plaza de Armas, Catedral, Tacuba, Plazuela Miguel Auza).

---

## 📌 Diapositiva 4: ¿Por qué es una PWA (Progressive Web App)?
### Definición simple
> **Una PWA es una página web con los superpoderes de una aplicación móvil instalada.**

### 3 Razones clave de por qué es PWA:
1. **Se instala en el celular en 1 segundo:**
   - Al entrar desde Chrome o Safari, el usuario puede presionar *"Instalar"* o *"Añadir a pantalla de inicio"*.
   - Aparece un icono idéntico al de cualquier app móvil nativa, abriendo a pantalla completa sin la barra del navegador.
2. **No depende de tiendas de apps (Play Store / App Store):**
   - No requiere pagar licencias de desarrollador a Apple o Google.
   - El usuario no tiene que esperar descargas pesadas de 100 MB ni actualizaciones manuales.
3. **Funciona sin conexión a internet (Modo Offline):**
   - Utiliza un archivo inteligente llamado **Service Worker** que guarda en la memoria caché del teléfono los catálogos y las tiendas visitadas.
   - Si el teléfono pierde señal, la página **no se rompe** y sigue mostrando la información.

---

## 📌 Diapositiva 5: Diferencias Clave (Página Web Normal vs. PWA)

| Característica | ❌ Página Web Normal (Sin PWA) | ✅ Nuestra PWA (Atelier Zacatecas) |
| :--- | :--- | :--- |
| **¿Funciona sin conexión?** | **No.** Si no hay internet, muestra la pantalla de error ("Sin conexión" o el dinosaurio). | **Sí.** El Service Worker almacena el catálogo en caché local y sigue navegable sin señal. |
| **Instalación en el teléfono** | **No se puede.** Siempre exige abrir el navegador y escribir la URL completa. | **Sí.** Se instala como icono directo en la pantalla del celular y abre a pantalla completa. |
| **Velocidad de carga** | **Lenta.** Cada clic solicita todo de nuevo al servidor; si el internet es lento, se congela. | **Instantánea.** Carga recursos desde la memoria del dispositivo, ahorrando hasta un 80% de datos móviles. |
| **Actualizaciones** | El usuario depende de recargar la página a la fuerza. | **Automáticas en segundo plano.** El Service Worker actualiza la versión silenciosamente. |
| **Costos y Publicación** | Crear una app nativa requiere programar para iOS y Android por separado (miles de dólares). | **Un solo código fuente.** Funciona igual en Android, iPhone, Windows y Mac. |

---

## 📌 Diapositiva 6: ¿Por qué esto beneficia a Zacatecas Centro?
* **Muros gruesos de cantera rosa y callejones:** En el Centro Histórico de Zacatecas, la señal celular 4G/5G con frecuencia se atenúa o se pierde al entrar a casonas históricas o callejones angostos. La PWA garantiza que el catálogo y la información del comercio sigan funcionando en todo momento.
* **Turismo inteligente:** Un visitante paseando por el Centro puede consultar las tiendas, precios y direcciones sin agotar su plan de datos móviles o roaming.
* **Soberanía y economía local:** Comercios locales compiten en internet con herramientas de primer nivel tecnológico sin intermediarios que absorban sus ganancias.

---

## 📌 Diapositiva 7: Conclusión
1. **Digitalización integral:** Se logró digitalizar 10 negocios emblemáticos de Zacatecas en una sola plataforma multi-inquilino.
2. **La PWA es el estándar moderno:** Ofrece la inmediatez de la web junto con la potencia de una app móvil.
3. **Proyecto en vivo:** Accesible en [https://atelier-zacatecas.onrender.com/](https://atelier-zacatecas.onrender.com/).
