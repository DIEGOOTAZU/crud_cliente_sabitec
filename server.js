const express = require('express');
const { createProxyMiddleware } = require('http-proxy-middleware');
const app = express();
const port = 3000;

// Proxy para redirigir solicitudes al servidor Apache
app.use('/', createProxyMiddleware({
  target: 'http://localhost', // URL base del servidor Apache
  changeOrigin: true,
  pathRewrite: {
    '^/': '/CRUD_CLIENTES/', // Redirige todas las solicitudes al subdirectorio donde está tu código PHP
  },
}));

// Iniciar el servidor Express
app.listen(port, '0.0.0.0', () => {
  console.log(`Server running at http://0.0.0.0:${port}/`);
});
