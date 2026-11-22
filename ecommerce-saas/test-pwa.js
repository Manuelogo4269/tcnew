/**
 * ATELIER ZACATECAS — SUITE DE PRUEBAS AUTOMATIZADAS PWA 100%
 * Ejecuta una auditoría integral sobre el servidor en vivo o local.
 * Uso: node test-pwa.js [URL_BASE]
 */

const BASE_URL = process.argv[2] || 'https://atelier-zacatecas.onrender.com';

const colors = {
  reset: "\x1b[0m",
  green: "\x1b[32m",
  red: "\x1b[31m",
  cyan: "\x1b[36m",
  yellow: "\x1b[33m",
  bold: "\x1b[1m",
  dim: "\x1b[2m"
};

async function runTests() {
  console.log(`\n${colors.cyan}${colors.bold}================================================================${colors.reset}`);
  console.log(`${colors.cyan}${colors.bold}   ATELIER ZACATECAS — AUDITORÍA AUTOMATIZADA PWA 100%           ${colors.reset}`);
  console.log(`${colors.dim}   Objetivo: ${BASE_URL}${colors.reset}`);
  console.log(`${colors.cyan}${colors.bold}================================================================${colors.reset}\n`);

  let totalTests = 0;
  let passedTests = 0;

  async function test(name, fn) {
    totalTests++;
    process.stdout.write(`  [TEST ${totalTests}] ${name} ... `);
    try {
      const startTime = Date.now();
      const detail = await fn();
      const elapsed = Date.now() - startTime;
      passedTests++;
      console.log(`${colors.green}${colors.bold}✓ PASS${colors.reset} ${colors.dim}(${elapsed}ms)${colors.reset}`);
      if (detail) console.log(`         ${colors.dim}↳ ${detail}${colors.reset}`);
    } catch (err) {
      console.log(`${colors.red}${colors.bold}✗ FAIL${colors.reset}`);
      console.log(`         ${colors.red}↳ Error: ${err.message}${colors.reset}`);
    }
  }

  // 1. Endpoint PWA HTML
  await test("Página principal PWA (/pwa) responde HTTP 200", async () => {
    const res = await fetch(`${BASE_URL}/pwa`);
    if (res.status !== 200) throw new Error(`HTTP Status ${res.status}`);
    const html = await res.text();
    if (!html.includes('<title>Atelier Zacatecas')) throw new Error("Título no encontrado");
    if (!html.includes('manifest.json')) throw new Error("No referencia manifest.json");
    if (!html.includes('service-worker.js')) throw new Error("No referencia service-worker.js");
    return `HTML válido (${(html.length / 1024).toFixed(1)} KB)`;
  });

  // 2. index.html PWA directo
  await test("Página estática PWA (/index.html) responde HTTP 200", async () => {
    const res = await fetch(`${BASE_URL}/index.html`);
    if (res.status !== 200) throw new Error(`HTTP Status ${res.status}`);
    return "Disponible como fallback estático";
  });

  // 3. Web App Manifest
  let manifestData = null;
  await test("manifest.json responde y tiene estructura válida", async () => {
    const res = await fetch(`${BASE_URL}/manifest.json`);
    if (res.status !== 200) throw new Error(`HTTP Status ${res.status}`);
    manifestData = await res.json();
    if (!manifestData.name) throw new Error("Falta campo 'name'");
    if (!manifestData.short_name) throw new Error("Falta campo 'short_name'");
    if (manifestData.display !== 'standalone') throw new Error(`display '${manifestData.display}' no es 'standalone'`);
    if (!manifestData.icons || manifestData.icons.length < 2) throw new Error("Se requieren al menos 2 iconos");
    return `Nombre: "${manifestData.name}", Display: ${manifestData.display}`;
  });

  // 4. Icono 192x192
  await test("Icono reglamentario 192x192 (/app-icons/icon-192.png) accesible", async () => {
    const res = await fetch(`${BASE_URL}/app-icons/icon-192.png`);
    if (res.status !== 200) throw new Error(`HTTP Status ${res.status}`);
    const type = res.headers.get("content-type");
    if (!type || !type.includes("image/png")) throw new Error(`Content-Type inesperado: ${type}`);
    const buf = await res.arrayBuffer();
    return `Tamaño: ${(buf.byteLength / 1024).toFixed(1)} KB (image/png)`;
  });

  // 5. Icono 512x512
  await test("Icono reglamentario 512x512 (/app-icons/icon-512.png) accesible", async () => {
    const res = await fetch(`${BASE_URL}/app-icons/icon-512.png`);
    if (res.status !== 200) throw new Error(`HTTP Status ${res.status}`);
    const type = res.headers.get("content-type");
    if (!type || !type.includes("image/png")) throw new Error(`Content-Type inesperado: ${type}`);
    const buf = await res.arrayBuffer();
    return `Tamaño: ${(buf.byteLength / 1024).toFixed(1)} KB (image/png)`;
  });

  // 6. Service Worker
  await test("service-worker.js accesible y contiene listeners esenciales", async () => {
    const res = await fetch(`${BASE_URL}/service-worker.js`);
    if (res.status !== 200) throw new Error(`HTTP Status ${res.status}`);
    const code = await res.text();
    if (!code.includes("addEventListener('install'")) throw new Error("Falta listener 'install'");
    if (!code.includes("addEventListener('activate'")) throw new Error("Falta listener 'activate'");
    if (!code.includes("addEventListener('fetch'")) throw new Error("Falta listener 'fetch'");
    if (!code.includes("caches.open")) throw new Error("Falta integración Cache Storage");
    return "Eventos install, activate, fetch y Cache Storage validados";
  });

  // 7. Fallback sw.js
  await test("sw.js alias accesible y operativo", async () => {
    const res = await fetch(`${BASE_URL}/sw.js`);
    if (res.status !== 200) throw new Error(`HTTP Status ${res.status}`);
    return "Soporte dual /sw.js y /service-worker.js";
  });

  // 8. Pantalla Offline de Contingencia
  await test("offline.html de respaldo accesible con HTTP 200", async () => {
    const res = await fetch(`${BASE_URL}/offline.html`);
    if (res.status !== 200) throw new Error(`HTTP Status ${res.status}`);
    const html = await res.text();
    if (!html.includes("Sin Conexión")) throw new Error("Contenido offline no detectado");
    return "Interfaz de respaldo para desconexión lista";
  });

  // 9. Favicon Válido
  await test("favicon.ico no está vacío y responde correctamente", async () => {
    const res = await fetch(`${BASE_URL}/favicon.ico`);
    if (res.status !== 200) throw new Error(`HTTP Status ${res.status}`);
    const buf = await res.arrayBuffer();
    if (buf.byteLength < 500) throw new Error("favicon.ico sospechosamente vacío");
    return `Tamaño: ${(buf.byteLength / 1024).toFixed(1)} KB`;
  });

  // 10. Portal Principal con Link a la PWA
  await test("Portal Principal (/) incluye enlace a la PWA y Service Worker", async () => {
    const res = await fetch(`${BASE_URL}/`);
    if (res.status !== 200) throw new Error(`HTTP Status ${res.status}`);
    const html = await res.text();
    if (!html.includes('/pwa')) throw new Error("Enlace /pwa no encontrado en portal");
    return "Enlace directo '📲 App PWA Móvil' presente en cabecera";
  });

  // Resumen Final
  const score = Math.round((passedTests / totalTests) * 100);
  console.log(`\n${colors.cyan}${colors.bold}----------------------------------------------------------------${colors.reset}`);
  console.log(`  ${colors.bold}RESUMEN DE PRUEBAS:${colors.reset} ${passedTests} de ${totalTests} aprobadas`);
  console.log(`  ${colors.bold}CALIFICACIÓN FINAL:${colors.reset} ${score === 100 ? colors.green : colors.yellow}${colors.bold}${score}% ${score === 100 ? "🏆 ¡EXCELENTE (100% CUMPLIDO)!" : "⚠️ CON ADVERTENCIAS"}${colors.reset}`);
  console.log(`${colors.cyan}${colors.bold}================================================================${colors.reset}\n`);

  process.exit(score === 100 ? 0 : 1);
}

runTests().catch(err => {
  console.error("Fallo crítico en la suite de pruebas:", err);
  process.exit(1);
});
